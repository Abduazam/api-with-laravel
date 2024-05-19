<?php

namespace App\Http\Controllers\Api\V1\Tickets;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filter): JsonResponse|AnonymousResourceCollection
    {
        try {
            $this->authorize('viewAny', Ticket::class);

            return TicketResource::collection(Ticket::filter($filter)->paginate(10));
        } catch (AuthorizationException $exception) {
            return $this->error("You don't have access.", 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): JsonResponse|TicketResource
    {
        try {
            $this->authorize('create', Ticket::class);

            return DB::transaction(function () use ($request) {
                $ticket = Ticket::create($request->mappedAttributes());

                return new TicketResource($ticket);
            });
        } catch (AuthorizationException $exception) {
            return $this->error("You don't have access.", 403);
        } catch (Throwable $exception) {
            return $this->success("Couldn't create a new ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $ticketId): JsonResponse|TicketResource
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            $this->authorize('view', $ticket);

            if ($this->include('user')) {
                return new TicketResource($ticket->load('user'));
            }

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
        } catch (AuthorizationException $exception) {
            return $this->error("You don't have access.", 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, int $ticketId): JsonResponse|TicketResource
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            $this->authorize('update', $ticket);

            return DB::transaction(function () use ($request, $ticket) {
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
        } catch (AuthorizationException $exception) {
            return $this->error("You don't have access.", 403);
        } catch (Throwable $exception) {
            return $this->success("Couldn't update a ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $ticketId): JsonResponse|TicketResource
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            $this->authorize('destroy', $ticket);

            return DB::transaction(function () use ($ticket) {
                $ticket->delete();

                return $this->success("Ticket deleted.");
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
        } catch (AuthorizationException $exception) {
            return $this->error("You don't have access.", 403);
        } catch (Throwable $exception) {
            return $this->success("Couldn't delete a ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }
}
