<?php

namespace App\Http\Filters\Api\V1\Tickets;

use App\Http\Filters\Api\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketFilter extends QueryFilter
{
    protected array $sortable = [
        'id',
        'status',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function include(string $value): Builder
    {
        return $this->builder->with($value);
    }

    public function id(string $value): Builder
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function title(string $value): Builder
    {
        return $this->builder->where('title', 'like', "%{$value}%");
    }

    public function status(string $value): Builder
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }
}
