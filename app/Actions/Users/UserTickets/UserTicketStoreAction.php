<?php

namespace App\Actions\Users\UserTickets;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\User;

class UserTicketStoreAction extends AbstractActionable
{
    public function __construct(
        protected User $user,
        protected array $data
    ) {
        //
    }

    public function run(): TicketResource
    {
        $ticket = $this->user->tickets()->create($this->data);

        return new TicketResource($ticket);
    }
}
