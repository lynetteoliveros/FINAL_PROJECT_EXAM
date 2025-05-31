<?php

namespace App\Policies;

use App\Enums\TicketSeverity;
use App\Models\Ticket;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Ticket $ticket): bool
    {
        // Admin can view all tickets
        if ($user->isAdmin()) {
            return true;
        }

        // Users can view tickets from their department
        if ($user->department_id === $ticket->department_id) {
            return true;
        }

        // Everyone can view critical tickets
        return $ticket->severity === TicketSeverity::CRITICAL->value;
    }

    public function create(User $user): bool
    {
        // All authenticated users can create tickets
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        // Admin can update any ticket
        if ($user->isAdmin()) {
            return true;
        }

        // Supervisors can update any ticket in their department
        if ($user->isSupervisor() && $user->department_id === $ticket->department_id) {
            return true;
        }

        // Junior Officers and Officers
        if (($user->isJuniorOfficer() || $user->isOfficer()) && $user->department_id === $ticket->department_id) {
            // Can update if assigned to them
            if ($ticket->assigned_to === $user->id) {
                return true;
            }

            // Can handle LOW severity tickets in their department
            if ($ticket->severity === TicketSeverity::LOW) {
                return true;
            }
        }

        return false;
    }

    public function transfer(User $user, Ticket $ticket): bool
    {
        // Admin can transfer any ticket
        if ($user->isAdmin()) {
            return true;
        }

        // Supervisors can transfer tickets from their own department
        if ($user->isSupervisor() && $user->department_id === $ticket->department_id) {
            return true;
        }

        return false;
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        // Admin can assign any ticket
        if ($user->isAdmin()) {
            return true;
        }

        // Supervisors can assign tickets in their department
        if ($user->isSupervisor() && $user->department_id === $ticket->department_id) {
            return true;
        }

        return false;
    }
}