<?php

namespace App\Actions;

use App\Contracts\Actions\Actionable;
use Illuminate\Support\Facades\DB;
use Throwable;

class ActionHandler
{
    public function handle(Actionable $service)
    {
        try {
            return DB::transaction(function () use ($service) {
                return $service->run();
            });
        } catch (Throwable $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
