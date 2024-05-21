<?php

namespace App\Policies\Api\V1;

use App\Models\User;

class UserTicketsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('api.users.tickets.index');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('api.users.tickets.show');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('api.users.tickets.store');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('api.users.tickets.update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('api.users.tickets.destroy');
    }
}
