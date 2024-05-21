<?php

namespace App\Actions\Users;

use App\Contracts\Actions\AbstractActionable;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserDeleteAction extends AbstractActionable
{
    public function __construct(protected User $user)
    {
        //
    }

    public function run(): JsonResponse
    {
        $this->user->delete();

        return $this->success("User deleted.");
    }
}
