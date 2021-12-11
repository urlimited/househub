<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmPhoneAuthCode;
use App\Http\Requests\RegisterResidentUser;
use App\Http\Requests\SendConfirmationPhoneCall;
use App\UseCases\RegisterUseCase;
use App\UseCases\UseCaseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\MaxAttemptsExceededException;

final class RegisterController extends Controller
{
    public function registerResidentUser(RegisterResidentUser $request): JsonResponse
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

    public function confirmPhoneAuthCode(ConfirmPhoneAuthCode $request): JsonResponse
    {
        $this->validateIsHeaderContentTypeApplicationJSON($request);

        try {
            $useCase = new RegisterUseCase();

            $result = $useCase->confirmAuthenticationCode($request->all());

            if($result->status === UseCaseResult::StatusSuccess)
                return response()->json(data: $result->content, status: 200);
            else
                return response()->json(data: [
                    'errors' => [
                        'code' => $result->message
                    ]
                ], status: 422);
        } catch (\Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage()
            ], status: 500);
        }

    }
}
