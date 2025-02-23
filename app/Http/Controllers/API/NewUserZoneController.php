<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Marketing\Services\NewUserZoneService;
use App\Http\Resources\Api\v1\AllCategoryProductsResource;

class NewUserZoneController extends Controller
{
    private $newUserZoneService;
    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->newUserZoneService = $newUserZoneService;
    }

    public function getAll()
    {
        try {
            $data = $this->newUserZoneService->getActiveNewUserZone();
            return response()->json([
                'new_user_zone' => $data['new_user_zone'],
                'allCategoryProducts' => AllCategoryProductsResource::collection($data['allCategoryProducts']),
                'allCouponCategoryProducts' => AllCategoryProductsResource::collection($data['allCouponCategoryProducts']),
                'message' => trans('app.Success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => trans('app.Not found')
            ], 400);
        }
    }
}
