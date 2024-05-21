<?php

namespace App\Actions\Users\UserTickets;

use App\Contracts\Actions\AbstractActionable;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserTicketDeleteAction extends AbstractActionable
{
    public function __construct(
        protected User $user,
        protected Ticket $ticket
    ) {
        //
    }

    public function run(): JsonResponse
    {
        $this->user->tickets()->delete($this->ticket->id);

        return $this->success("Ticket deleted.");
    }
}
