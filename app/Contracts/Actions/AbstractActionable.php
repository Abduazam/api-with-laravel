<?php

namespace App\Contracts\Actions;

use App\Contracts\Traits\ApiResponseTrait;

abstract class AbstractActionable implements Actionable
{
    use ApiResponseTrait;
}
