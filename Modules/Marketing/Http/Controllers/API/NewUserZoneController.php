<?php

namespace Modules\Marketing\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\NewUserZoneRepository;
use Illuminate\Contracts\Support\Renderable;
use Modules\Marketing\Services\NewUserZoneService;
use Modules\Marketing\Transformers\NewUserZoneCategoryProducts;
use Modules\Marketing\Transformers\NewUserZoneProductsResource;

class NewUserZoneController extends Controller
{
    protected $newUserZoneService;

    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->newUserZoneService = $newUserZoneService;
    }

    // New User Zone

    public function getActiveNewUserZone()
    {
        $data = $this->newUserZoneService->getActiveNewUserZone();

        if($data){
            return response()->json([
                'new_user_zone' => $data['new_user_zone'],
                'allCategoryProducts' => $data['allCategoryProducts'],
                'allCouponCategoryProducts' => $data['allCouponCategoryProducts'],
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ], 400);
        }

    }


    // pagination from product


    public function fetchProductData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $new_user_zone = $newuserRepo->getById($slug);
        $products = NewUserZoneProductsResource::collection($new_user_zone->products()->paginate(12));
        $products->appends([
            'item' => 'product'
        ]);
        return response()->json(["data" => $products]);

    }

    // Pagination from single category

    public function fetchCategoryData(Request $request, $slug){
        $newuserRepo = new NewUserZoneRepository();
        $category = $newuserRepo->getCategoryById($request->parent_data);
        $products = $category->category->AllProducts;
        $products = NewUserZoneCategoryProducts::collection($newuserRepo->getAllProductsForCategories($slug));

        return response()->json(['data' => $products]);
    }

    // Pagination from single coupon category

    public function fetchCouponCategoryData(Request $request, $slug){
        $newuserRepo = new NewUserZoneRepository();
        $category = $newuserRepo->getCouponCategoryById($request->parent_data);
        $products = NewUserZoneCategoryProducts::collection($category->category->AllProducts);

        return response()->json(['data' => $products]);
    }

    // Pagination from all category

    public function fetchAllCategoryData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $products = NewUserZoneCategoryProducts::collection($newuserRepo->getAllProductsForCategories($slug));

        return response()->json([
            'allCategoryProducts' => $products
        ]);
    }

    // Pagination from all coupon category

    public function fetchAllCouponCategoryData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $allCouponCategoryProducts = NewUserZoneCategoryProducts::collection($newuserRepo->getAllProductsForCouponCategories($slug));

        return response()->json([
            'allCouponCategoryProducts' => [
                    "data" => $allCouponCategoryProducts
                ]
        ]);
    }


}
