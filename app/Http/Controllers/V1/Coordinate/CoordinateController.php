<?php

namespace App\Http\Controllers\V1\Coordinate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinate\PointIndexRequest;
use App\Http\Requests\Coordinate\PointStoreRequest;
use App\Http\Resources\Geocoding\PointsResource;
use App\Operations\Geocoding\PointOperation;
use App\Operations\User\UserOperations;
use App\Repositories\Geocoding\PointRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CoordinateController extends Controller
{
    public function __construct(
        protected UserOperations $userOperations,
        protected PointOperation $geocodeOperations,
        protected PointRepository $pointRepository
    )
    {
    }

    /**
     * @param PointStoreRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(PointStoreRequest $request): JsonResponse
    {
        $user = $this->userOperations->getAuthUser();
        $pointDto = $request->getPoint();

        $status = $this->geocodeOperations->storePoint($user, $pointDto);

        return new JsonResponse([
            'status' => 'success',
            'result' => $status
        ], HttpResponse::HTTP_CREATED);
    }

    /**
     * @param PointIndexRequest $request
     * @return JsonResponse
     */
    public function index(PointIndexRequest $request): JsonResponse
    {
        $filter = $request->getPointsFilterDto();
        $points = $this->pointRepository->getUsersPoints($filter);

        return new JsonResponse([
            'status' => 'success',
            'result' => [
                'data' => PointsResource::collection($points),
                'meta' => [
                    'pagination' => [
                        'total' => $points->total(),
                        'per_page' => $points->perPage(),
                        'current_page' => $points->currentPage(),
                    ],
                ],
            ],

        ], HttpResponse::HTTP_OK);
    }
}
