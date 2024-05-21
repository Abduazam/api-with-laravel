<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Actions\ActionHandler;
use App\Actions\Users\UserTickets\UserTicketDeleteAction;
use App\Actions\Users\UserTickets\UserTicketStoreAction;
use App\Actions\Users\UserTickets\UserTicketUpdateAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserTicketsController extends ApiController
{
    /**
     * User tickets index.
     * @throws AuthorizationException
     */
    public function index(User $user, TicketFilter $filter): JsonResponse|AnonymousResourceCollection
    {
        $this->authorize('viewAny', 'user-tickets');

        return TicketResource::collection($user->tickets()->filter($filter)->paginate(5));
    }

    /**
     * User ticket store.
     * @throws AuthorizationException
     */
    public function store(User $user, StoreTicketRequest $request, ActionHandler $handler): JsonResponse|TicketResource
    {
        $this->authorize('create', 'user-tickets');

        return $handler->handle(
            new UserTicketStoreAction($user, $request->mappedAttributes())
        );
    }

    /**
     * User ticket show.
     * @throws AuthorizationException
     */
    public function show(User $user, int $ticketId): JsonResponse|TicketResource
    {
        $this->authorize('view', 'user-tickets');

        $ticket = $user->tickets()->findOrFail($ticketId);

        return new TicketResource($ticket);
    }

    /**
     * User ticket update.
     * @throws AuthorizationException
     */
    public function update(User $user, int $ticketId, UpdateTicketRequest $request, ActionHandler $handler): JsonResponse|TicketResource
    {
        $this->authorize('update', 'user-tickets');

        $ticket = $user->tickets()->findOrFail($ticketId);

        return $handler->handle(
            new UserTicketUpdateAction($ticket, $request->mappedAttributes())
        );
    }

    /**
     * User ticket delete.
     * @throws AuthorizationException
     */
    public function destroy(User $user, int $ticketId, ActionHandler $handler): JsonResponse
    {
        $this->authorize('delete', 'user-tickets');

        $ticket = $user->tickets()->findOrFail($ticketId);

        return $handler->handle(
            new UserTicketDeleteAction($user, $ticket)
        );
    }
}
