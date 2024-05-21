<?php

namespace App\Actions\Tickets;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\Ticket;

class TicketUpdateAction extends AbstractActionable
{
    public function __construct(
        protected Ticket $ticket,
        protected array $data
    ) {
        //
    }

    public function run(): TicketResource
    {
        $this->ticket->update($this->data);

        return new TicketResource($this->ticket);
    }
}
