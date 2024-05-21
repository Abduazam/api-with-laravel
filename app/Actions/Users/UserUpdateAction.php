<?php

namespace App\Actions\Users;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class UserUpdateAction extends AbstractActionable
{
    public function __construct(
        protected User $user,
        protected array $data
    ) {
        //
    }

    public function run(): UserResource
    {
        $this->user->update($this->data);

        return new UserResource($this->user);
    }
}
