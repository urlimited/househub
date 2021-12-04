<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterResidentUser;
use App\UseCases\RegisterUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerResidentUser(RegisterResidentUser $request): JsonResponse
    {
        if($request->header('Content-Type') !== 'application/json')
            return response()->json(data: [
                'errors' => [
                    'header' => 'Content-Type must be application/json'
                ]
            ], status: 422);

        $useCase = new RegisterUseCase();

        $result = [
            'data' => $useCase->registerResidentUser($request->all())
        ];

        return response()->json(data: $result, status: 200);
    }
}
