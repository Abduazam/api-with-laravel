<?php

namespace App\Http\Controllers\Api\V1\Tickets;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\Ticket;
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
    public function index(TicketFilter $filter): AnonymousResourceCollection
    {
        return TicketResource::collection(Ticket::filter($filter)->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): JsonResponse|TicketResource
    {
        try {
            return DB::transaction(function () use ($request) {
                $ticket = Ticket::create($request->mappedAttributes());

                return new TicketResource($ticket);
            });
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

            if ($this->include('user')) {
                return new TicketResource($ticket->load('user'));
            }

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, int $ticketId): JsonResponse|TicketResource
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            return DB::transaction(function () use ($request, $ticket) {
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
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

            return DB::transaction(function () use ($ticket) {
                $ticket->delete();

                return $this->success("Ticket deleted.");
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found.", 404);
        } catch (Throwable $exception) {
            return $this->success("Couldn't delete a ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }
}
