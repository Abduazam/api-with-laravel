<?php

namespace App\Http\Filters\Api\V1\Tickets;

use App\Http\Filters\Api\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketFilter extends QueryFilter
{
    public function include(string $value): Builder
    {
        return $this->builder->with($value);
    }

    public function status(string $value): Builder
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }
}
