<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected Request $request)
    {
        //
    }

    public function include(string $relation): bool
    {
        $param = $this->request->get('include');

        if (! isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relation), $includeValues);
    }
}
