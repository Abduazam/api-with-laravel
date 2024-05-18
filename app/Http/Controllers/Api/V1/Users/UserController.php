<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\Api\V1\Users\UserFilter;
use App\Http\Requests\Api\V1\Users\StoreUserRequest;
use App\Http\Requests\Api\V1\Users\UpdateUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilter $filter): AnonymousResourceCollection
    {
        return UserResource::collection(User::filter($filter)->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse|UserResource
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = User::create($request->mappedAttributes());

                return new UserResource($user);
            });
        } catch (Throwable $exception) {
            return $this->success("Couldn't create a new user.", [
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $userId): JsonResponse|UserResource
    {
        try {
            $user = User::findOrFail($userId);

            if ($this->include('tickets')) {
                return new UserResource($user->load('tickets'));
            }

            return new UserResource($user);
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found.", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $userId): JsonResponse|UserResource
    {
        try {
            $user = User::findOrFail($userId);

            return DB::transaction(function () use ($request, $user) {
                $user->update($request->mappedAttributes());

                return new UserResource($user);
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found.", 404);
        } catch (Throwable $exception) {
            return $this->success("Couldn't update a user.", [
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId)
    {
        try {
            $user = User::findOrFail($userId);

            return DB::transaction(function () use ($user) {
                $user->delete();

                return $this->success("User deleted.");
            });
        } catch (ModelNotFoundException $exception) {
            return $this->error("User not found.", 404);
        } catch (Throwable $exception) {
            return $this->success("Couldn't delete a user.", [
                'error' => $exception->getMessage()
            ]);
        }
    }
}
