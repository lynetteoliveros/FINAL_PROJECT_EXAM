<?php


namespace App\Services;

use App\Models\User;
use App\Models\Notification;

class NotificationService
{
    public function create(User $user, string $title, string $message, string $type = 'info'): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $type
        ]);
    }

    public function notifyTicketAssigned(User $user, int $ticketId): void
    {
        $this->createNotification(
            $user->id,
            'Ticket Assigned',
            "You have been assigned to ticket #{$ticketId}."
        );
    }

    public function notifyTicketStatusChanged(User $user, int $ticketId, string $newStatus): void
    {
        $this->createNotification(
            $user->id,
            'Ticket Status Updated',
            "Ticket #{$ticketId} status has been updated to {$newStatus}."
        );
    }

    public function createNotification(int $userId, string $title, string $message): void
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => 'info',
            'read' => false
        ]);
    }
}