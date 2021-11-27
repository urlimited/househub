<?php

namespace App\Http\Controllers;

use App\UseCases\RegisterUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerResidentUser(Request $request): JsonResponse
    {
        $useCase = new RegisterUseCase();

        $result = $useCase->registerResidentUser($request->all());

        return response()->json(data: $result, status: 200);
    }
}
