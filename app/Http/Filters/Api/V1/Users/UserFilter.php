<?php

namespace App\Http\Filters\Api\V1\Users;

use App\Http\Filters\Api\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    protected array $sortable = [
        'id',
        'emailVerifiedAt' => 'email_verified_at',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function include(string $value): Builder
    {
        return $this->builder->with($value);
    }

    public function name(string $value): Builder
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }

    public function email(string $value): Builder
    {
        return $this->builder->where('email', 'like', "%{$value}%");
    }

    public function emailVerifiedAt(string $value): Builder
    {
        if ($value === 'true') {
            return $this->builder->whereNotNull('email_verified_at');
        }

        return $this->builder->whereNull('email_verified_at');
    }
}
