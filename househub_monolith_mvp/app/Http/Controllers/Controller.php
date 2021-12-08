<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validateIsHeaderContentTypeApplicationJSON(Request $request): JsonResponse|null{
        if($request->header('Content-Type') !== 'application/json')
            return response()->json(data: [
                'errors' => [
                    'header' => 'Content-Type must be application/json'
                ]
            ], status: 422);

        return null;
    }
}
