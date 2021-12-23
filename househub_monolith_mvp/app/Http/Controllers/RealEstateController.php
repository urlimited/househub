<?php

namespace App\Http\Controllers;

use App\Http\Requests\RealEstate\CreateApartment;
use App\UseCases\RealEstateUseCase;
use App\UseCases\UseCaseResult;
use Exception;
use Illuminate\Http\JsonResponse;

final class RealEstateController extends Controller
{
    public function createApartment(CreateApartment $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = new RealEstateUseCase();

            $result = $useCase->createApartmentRealEstate($request->all());

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

    public function createHouse(CreateApartment $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = new RealEstateUseCase();

            $result = $useCase->createHouseRealEstate($request->all());

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

    public function createResidentialComplex(CreateApartment $request): JsonResponse
    {
        try {
            $this->validateIsHeaderContentTypeApplicationJSON($request);

            $useCase = new RealEstateUseCase();

            $result = $useCase->createResidentialComplexRealEstate($request->all());

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
