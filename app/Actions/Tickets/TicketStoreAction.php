<?php

namespace App\Actions\Tickets;

use App\Contracts\Actions\AbstractActionable;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\Ticket;

class TicketStoreAction extends AbstractActionable
{
    public function __construct(protected array $data)
    {
        //
    }

    public function run(): TicketResource
    {
        $user = Ticket::create($this->data);

        return new TicketResource($user);
    }
}
