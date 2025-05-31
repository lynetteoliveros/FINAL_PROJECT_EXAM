<?php

namespace App\Http\Controllers;

use App\Enums\TicketSeverity;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
class TicketController extends Controller
{
    //
    protected $notificationService;
    use AuthorizesRequests;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        $tickets = Ticket::query()
            ->when(!auth()->user()->isAdmin(), function ($query) {
                $query->where('department_id', auth()->user()->department_id);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('severity'), function ($query, $severity) {
                $query->where('severity', $severity);
            })
            ->when(request('department'), function ($query, $department) {
                $query->where('department_id', $department);
            })
            ->when(request('assigned'), function ($query, $assigned) {
                if ($assigned === 'assigned') {
                    $query->whereNotNull('assigned_to');
                } elseif ($assigned === 'unassigned') {
                    $query->whereNull('assigned_to');
                } elseif ($assigned === 'mine') {
                    $query->where('assigned_to', auth()->id());
                }
            })
            ->orderByRaw("CASE 
                WHEN severity = 'critical' THEN 1 
                WHEN severity = 'high' THEN 2 
                WHEN severity = 'medium' THEN 3 
                WHEN severity = 'low' THEN 4 
                END")
            ->with(['creator', 'assignedTo', 'department'])
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString(); // This preserves the filter parameters across pagination

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create', [
            'statuses' => TicketStatus::cases(),
            'severities' => TicketSeverity::cases(),
        ]);
    }

    public function store(StoreTicketRequest $request)
    {
        try {
            $ticket = Ticket::create([
                ...$request->validated(),
                'status' => TicketStatus::OPEN->value,
                'severity' => TicketSeverity::from($request->severity)->value,
                'created_by' => auth()->id(),
            ]);

            return redirect()
                ->route('tickets.index')
                ->with('success', "Ticket #{$ticket->id} created successfully.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create ticket. Please try again.');
        }
    }


    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['creator', 'assignedTo', 'department', 'remarks.user']);

        return view('tickets.show', compact('ticket'));
    }


    public function edit(Ticket $ticket)
    {
        try {
            $this->authorize('update', $ticket);

            $statuses = TicketStatus::cases();
            $availableUsers = User::where('department_id', $ticket->department_id)->get();

            return view('tickets.edit', compact('ticket', 'statuses', 'availableUsers'));
        } catch (\Exception $e) {
            \Log::error('Ticket edit authorization failed:', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role,
                'ticket_id' => $ticket->id,
                'ticket_severity' => $ticket->severity,
                'department_match' => auth()->user()->department_id === $ticket->department_id,
                'error' => $e->getMessage()
            ]);

            abort(403, 'Unauthorized action.');
        }
    }




    public function update(Request $request, Ticket $ticket)
    {
        try {
            $validated = $request->validate([
                'status' => ['required', 'string', 'in:' . implode(',', array_column(TicketStatus::cases(), 'value'))],
                'assigned_to' => ['nullable', 'exists:users,id'],
                'department_id' => ['nullable', 'exists:departments,id'],
            ]);

            // If this is a transfer attempt
            if (isset($validated['department_id']) && $validated['department_id'] != $ticket->department_id) {
                $newDeptName = \App\Models\Department::find($validated['department_id'])->name;
                $oldDeptName = $ticket->department->name;
                
                // Update the department
                $ticket->department_id = $validated['department_id'];
                // Clear assignment when transferring departments
                $ticket->assigned_to = null;
                $ticket->save();

                // Add a remark about the transfer
                $ticket->remarks()->create([
                    'user_id' => auth()->id(),
                    'content' => "Ticket transferred from {$oldDeptName} to {$newDeptName} department"
                ]);

                // Notify supervisors of the new department
                try {
                    $supervisors = User::where('department_id', $validated['department_id'])
                        ->where('role', 'supervisor')
                        ->get();
                    
                    foreach ($supervisors as $supervisor) {
                        $this->notificationService->create(
                            $supervisor,
                            "New Ticket Transfer",
                            "Ticket #{$ticket->id} has been transferred to your department from {$oldDeptName}",
                            'info'
                        );
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send transfer notifications: ' . $e->getMessage());
                }

                return redirect()
                    ->route('tickets.index')
                    ->with('success', "Ticket #{$ticket->id} has been transferred to {$newDeptName} department.");
            }

            // For non-transfer updates, check authorization
            if (!$request->user()->can('update', $ticket)) {
                return redirect()
                    ->route('tickets.index')
                    ->with('error', 'You do not have permission to update this ticket.');
            }

            $oldStatus = $ticket->status;
            $oldAssignedTo = $ticket->assigned_to;

            // Update fields
            $ticket->status = $validated['status'];
            if (isset($validated['assigned_to'])) {
                if (!$request->user()->can('assign', $ticket)) {
                    return redirect()
                        ->route('tickets.index')
                        ->with('error', 'You do not have permission to assign this ticket.');
                }
                $ticket->assigned_to = $validated['assigned_to'];
            }

            $ticket->save();

            // Log status change
            if ($oldStatus !== $ticket->status) {
                $ticket->remarks()->create([
                    'user_id' => auth()->id(),
                    'content' => "Status changed from {$oldStatus->label()} to {$ticket->status->label()}"
                ]);

                // Notify about status change if ticket is assigned
                if ($ticket->assigned_to) {
                    try {
                        $this->notificationService->notifyTicketStatusChanged(
                            $ticket->assignedTo,
                            $ticket->id,
                            $ticket->status->label()
                        );
                    } catch (\Exception $e) {
                        \Log::error('Failed to send status change notification: ' . $e->getMessage());
                    }
                }
            }

            // Log assignment change
            if ($oldAssignedTo !== $ticket->assigned_to) {
                $assignedUser = $ticket->assigned_to ? User::find($ticket->assigned_to)->name : 'Unassigned';
                $ticket->remarks()->create([
                    'user_id' => auth()->id(),
                    'content' => "Ticket assigned to {$assignedUser}"
                ]);

                // Send notification to newly assigned user
                if ($ticket->assigned_to) {
                    try {
                        $assignedUser = User::findOrFail($ticket->assigned_to);
                        $this->notificationService->notifyTicketAssigned($assignedUser, $ticket->id);
                    } catch (\Exception $e) {
                        \Log::error('Failed to send notification: ' . $e->getMessage());
                    }
                }
            }

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', 'Ticket updated successfully');

        } catch (\Exception $e) {
            \Log::error('Ticket update failed:', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role,
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('tickets.index')
                ->with('error', 'Failed to update ticket. Please try again.');
        }
    }
}