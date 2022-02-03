<?php

namespace App\Http\Controllers;

use App\Http\Requests\RealEstate\CreateApartment;
use App\Http\Requests\RealEstate\CreateHouse;
use App\Http\Requests\RealEstate\CreateResidentialComplex;
use App\Http\Requests\RealEstate\UpdateApartment;
use App\UseCases\RealEstateUseCase;
use App\UseCases\UseCaseResult;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

final class RealEstateController extends Controller
{
    public function createApartment(CreateApartment $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RealEstateUseCase::class);

            $result = $useCase->createApartmentRealEstate($request->validated());

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
                'message' => $e->getMessage()
            ], status: 500);
        }
    }

    public function createHouse(CreateHouse $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RealEstateUseCase::class);

            $result = $useCase->createHouseRealEstate($request->validated());

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
                'message' => $e->getMessage()
            ], status: 500);
        }
    }

    public function createResidentialComplex(CreateResidentialComplex $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RealEstateUseCase::class);

            $result = $useCase->createResidentialComplexRealEstate($request->validated());

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
                'message' => $e->getMessage()
            ], status: 500);
        }
    }

    public function updateApartment(UpdateApartment $request, int $id): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = App::make(RealEstateUseCase::class);

            $result = $useCase->updateApartmentRealEstate($request->validated(), $id);

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
                'message' => $e->getMessage()
            ], status: 500);
        }
    }
}
