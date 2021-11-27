<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUsers(Request $request): JsonResponse
    {
        return response()->json(data: 'qweqwewqeqwe', status: 200);
    }
}
