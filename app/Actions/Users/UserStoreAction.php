<?php

namespace App\Actions\Users;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class UserStoreAction extends AbstractActionable
{
    public function __construct(protected array $data)
    {
        //
    }

    public function run(): UserResource
    {
        $user = User::create($this->data);

        return new UserResource($user);
    }
}
