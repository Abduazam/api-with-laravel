<?php

namespace App\Http\Controllers\Api\V1\Tickets;

use App\Actions\ActionHandler;
use App\Actions\Tickets\TicketDeleteAction;
use App\Actions\Tickets\TicketStoreAction;
use App\Actions\Tickets\TicketUpdateAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketController extends ApiController
{
    /**
     * Tickets index.
     * @throws AuthorizationException
     */
    public function index(TicketFilter $filter): JsonResponse|AnonymousResourceCollection
    {
        $this->authorize('viewAny', Ticket::class);

        return TicketResource::collection(Ticket::filter($filter)->paginate(10));
    }

    /**
     * Ticket store.
     * @throws AuthorizationException
     */
    public function store(StoreTicketRequest $request, ActionHandler $handler): JsonResponse|TicketResource
    {
        $this->authorize('create', Ticket::class);

        return $handler->handle(
            new TicketStoreAction($request->mappedAttributes())
        );
    }

    /**
     * Ticket show.
     * @throws AuthorizationException
     */
    public function show(Ticket $ticket): JsonResponse|TicketResource
    {
        $this->authorize('view', $ticket);

        if ($this->include('user')) {
            $ticket->load('user');
        }

        return new TicketResource($ticket);
    }

    /**
     * Ticket update.
     * @throws AuthorizationException
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket, ActionHandler $handler): JsonResponse|TicketResource
    {
        $this->authorize('update', $ticket);

        return $handler->handle(
            new TicketUpdateAction($ticket, $request->mappedAttributes())
        );
    }

    /**
     * Ticket delete.
     * @throws AuthorizationException
     */
    public function destroy(Ticket $ticket, ActionHandler $handler): JsonResponse|TicketResource
    {
        $this->authorize('destroy', $ticket);

        return $handler->handle(
            new TicketDeleteAction($ticket)
        );
    }
}
