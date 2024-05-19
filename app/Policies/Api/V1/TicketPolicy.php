<?php

namespace App\Policies\Api\V1;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('api.tickets.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) {
            return $user->hasPermissionTo('api.tickets.show');
        }

        return $user->hasPermissionTo('api.tickets.show') && $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('api.tickets.store');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) {
            return $user->hasPermissionTo('api.tickets.update');
        }

        return $user->hasPermissionTo('api.tickets.update') && $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) {
            return $user->hasPermissionTo('api.tickets.destroy');
        }

        return $user->hasPermissionTo('api.tickets.destroy') && $ticket->user_id === $user->id;
    }
}
