<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmPhoneAuthCode;
use App\Http\Requests\RegisterResidentUser;
use App\Http\Requests\RequestForServiceCompanyRegister;
use App\Http\Requests\SendConfirmationPhoneCall;
use App\UseCases\RegisterUseCase;
use App\UseCases\UseCaseResult;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Support\Facades\App;

final class RegisterController extends Controller
{
    public function registerResidentUser(RegisterResidentUser $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RegisterUseCase::class);

            $result = [
                'data' => $useCase->registerResidentUser($request->all())
            ];

            return response()->json(data: $result, status: 200);
        } catch (Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ], status: 500);
        }
    }

    public function registerUser(RegisterResidentUser $request){

    }

    public function registerCompany(){

    }

    public function requestRegistrationForServiceCompany(RequestForServiceCompanyRegister $request): JsonResponse {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RegisterUseCase::class);

            $result = [
                'data' => $useCase->requestForRegistrationServiceCompany($request->all())
            ];

            return response()->json(data: $result, status: 200);
        } catch (Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ], status: 500);
        }
    }

    public function registerServiceCompany() {

    }

    public function registerServiceCompanyUser() {

    }

    public function sendConfirmationPhoneCall(SendConfirmationPhoneCall $request): JsonResponse
    {
        $this->validateIsHeaderContentTypeApplicationJSON($request);

        try {
            $useCase = App::make(RegisterUseCase::class);

            $useCase->sendAuthenticationCall($request->all());

            return response()->json(status: 201);
        } catch (MaxAttemptsExceededException $exception) {
            return response()->json(data: [
                'errors' => [
                    'max_attempts' => 'Max attempts are reached, the user is banned'
                ]
            ], status: 429);
        } catch (Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ], status: 500);
        }

    }

    public function confirmPhoneAuthCode(ConfirmPhoneAuthCode $request): JsonResponse
    {
        $this->validateIsHeaderContentTypeApplicationJSON($request);

        try {
            $useCase = App::make(RegisterUseCase::class);

            $result = $useCase->confirmAuthenticationCode($request->all());

            if ($result->status === UseCaseResult::StatusSuccess)
                return response()->json(data: [
                    'data' => $result->content
                ], status: 200);
            else
                return response()->json(data: [
                    'errors' => [
                        'code' => $result->message
                    ]
                ], status: 422);
        } catch (Exception $e) {
            return response()->json(data: [
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ], status: 500);
        }

    }
}
