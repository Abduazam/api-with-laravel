<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use App\Actions\ActionHandler;
use Illuminate\Http\JsonResponse;
use App\Actions\Users\UserStoreAction;
use App\Actions\Users\UserDeleteAction;
use App\Actions\Users\UserUpdateAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Filters\Api\V1\Users\UserFilter;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\Api\V1\Users\StoreUserRequest;
use App\Http\Requests\Api\V1\Users\UpdateUserRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends ApiController
{
    /**
     * Users index.
     * @throws AuthorizationException
     */
    public function index(UserFilter $filter): JsonResponse|AnonymousResourceCollection
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(User::filter($filter)->paginate(5));
    }

    /**
     * User store.
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request, ActionHandler $handler): JsonResponse|UserResource
    {
        $this->authorize('create', User::class);

        return $handler->handle(
            new UserStoreAction($request->mappedAttributes())
        );
    }

    /**
     * User show.
     * @throws AuthorizationException
     */
    public function show(User $user): JsonResponse|UserResource
    {
        $this->authorize('view', $user);

        if ($this->include('tickets')) {
            $user->load('tickets');
        }

        return new UserResource($user);
    }

    /**
     * User update.
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user, ActionHandler $handler): JsonResponse|UserResource
    {
        $this->authorize('update', $user);

        return $handler->handle(
            new UserUpdateAction($user, $request->mappedAttributes())
        );
    }

    /**
     * User delete.
     * @throws AuthorizationException
     */
    public function destroy(User $user, ActionHandler $handler): JsonResponse
    {
        $this->authorize('delete', $user);

        return $handler->handle(
            new UserDeleteAction($user)
        );
    }
}
