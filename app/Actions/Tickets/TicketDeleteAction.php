<?php

namespace App\Actions\Tickets;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TicketDeleteAction extends AbstractActionable
{
    public function __construct(protected Ticket $ticket)
    {
        //
    }

    public function run(): JsonResponse
    {
        $this->ticket->delete();

        return $this->success("Ticket deleted.");
    }
}
