<?php


namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Enums\TicketSeverity;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $query = Ticket::query();

        // If not admin, only show department tickets
        if (!auth()->user()->isAdmin()) {
            $query->where('department_id', auth()->user()->department_id);
        }

        $statistics = [
            'total' => $query->count(),
            'by_status' => $query->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'by_severity' => $query->select('severity', DB::raw('count(*) as count'))
                ->groupBy('severity')
                ->pluck('count', 'severity')
                ->toArray(),
            'unassigned' => $query->whereNull('assigned_to')->count(),
            'my_tickets' => $query->where('assigned_to', auth()->id())->count()
        ];

        return view('dashboard', compact('statistics'));
    }
}