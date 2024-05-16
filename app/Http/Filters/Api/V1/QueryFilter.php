<?php

namespace App\Http\Filters\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Builder $builder;
    protected Request $request;
    protected array $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter(array $array): Builder
    {
        foreach ($array as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort(string $attributes): Builder
    {
        $sortAttributes = explode(',', $attributes);

        foreach($sortAttributes as $sortAttribute) {
            $direction = str_starts_with($sortAttribute, '-') ? 'desc' : 'asc';
            $sortAttribute = ltrim($sortAttribute, '-');

            if (!array_key_exists($sortAttribute, $this->sortable) && !in_array($sortAttribute, $this->sortable)) {
                continue;
            }

            $columnName = $this->sortable[$sortAttribute] ?? $sortAttribute;

            $this->builder->orderBy($columnName, $direction);
        }

        return $this->builder;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }
}
