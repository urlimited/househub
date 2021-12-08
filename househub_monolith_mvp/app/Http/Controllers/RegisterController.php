<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendConfirmationPhoneCall;
use App\UseCases\RegisterUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\MaxAttemptsExceededException;

final class RegisterController extends Controller
{
    public function registerResidentUser(SendConfirmationPhoneCall $request): JsonResponse
    {
        $this->validateIsHeaderContentTypeApplicationJSON($request);

        $useCase = new RegisterUseCase();

        $result = [
            'data' => $useCase->registerResidentUser($request->all())
        ];

        return response()->json(data: $result, status: 200);
    }

    public function sendConfirmationPhoneCall(SendConfirmationPhoneCall $request): JsonResponse
    {
        $this->validateIsHeaderContentTypeApplicationJSON($request);

        try{
            $useCase = new RegisterUseCase();

            $useCase->sendAuthenticationCall($request->all());

            return response()->json(status: 201);
        } catch (MaxAttemptsExceededException $exception) {
            return response()->json(data: [
                'errors' => [
                    'max_attempts' => 'Max attempts are reached, the user is banned'
                ]
            ], status: 429);
        } catch (\Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage()
            ], status: 500);
        }

    }
}
