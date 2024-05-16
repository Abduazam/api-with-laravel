<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Filters\Api\V1\Tickets\TicketFilter;
use App\Http\Resources\Api\V1\TicketResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserTicketsController extends Controller
{
    public function __invoke(User $user, TicketFilter $filter): AnonymousResourceCollection
    {
        return TicketResource::collection(
            $user->tickets()->filter($filter)->paginate()
        );
    }
}
