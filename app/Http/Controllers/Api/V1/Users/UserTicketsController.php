<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Requests\Api\V1\Tickets\StoreTicketRequest;
use App\Http\Requests\Api\V1\Tickets\UpdateTicketRequest;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserTicketsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $userId, TicketFilter $filter): JsonResponse|AnonymousResourceCollection
    {
        try {
            $user = User::findOrFail($userId);

            return TicketResource::collection($user->tickets()->filter($filter)->paginate(5));
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found", 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $userId, StoreTicketRequest $request): JsonResponse|TicketResource
    {
        try {
            $user = User::findOrFail($userId);

            $ticket = $user->tickets()->create($request->mappedAttributes());

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found", 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userId, int $ticketId): JsonResponse|TicketResource
    {
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found", 404);
        }

        try {
            $ticket = $user->tickets()->findOrFail($ticketId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found", 404);
        }

        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $userId, int $ticketId, UpdateTicketRequest $request): JsonResponse|TicketResource
    {
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found", 404);
        }

        try {
            $ticket = $user->tickets()->findOrFail($ticketId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found", 404);
        }

        try {
            return DB::transaction(function () use ($request, $ticket) {
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            });
        } catch (Throwable $exception) {
            return $this->success("Couldn't update a ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId, int $ticketId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found", 404);
        }

        try {
            $ticket = $user->tickets()->findOrFail($ticketId);
        } catch (ModelNotFoundException $exception) {
            return $this->error("Ticket not found", 404);
        }

        try {
            return DB::transaction(function () use ($ticket) {
                $ticket->delete();

                return $this->success("Ticket deleted.");
            });
        } catch (Throwable $exception) {
            return $this->success("Couldn't delete a ticket.", [
                'error' => $exception->getMessage()
            ]);
        }
    }
}
