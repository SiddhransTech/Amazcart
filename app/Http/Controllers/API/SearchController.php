<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Modules\Seller\Entities\SellerProduct;
use App\Http\Resources\SearchCategoryRespose;
use Modules\UserActivityLog\Traits\LogActivity;

class SearchController extends Controller
{
    public function liveSearch(Request $request){
        $request->validate([
            'cat_id' => 'required',
            'keyword' => 'required'
        ]);
        try {
            $productService = new ProductRepository(new SellerProduct);
            $data = $productService->searchProduct($request->all());
            $response['tags'] = $data['tags'];
            $response['products'] = $data['products'];
            $response['categories'] = SearchCategoryRespose::collection($data['categories']);
            return response()->json($response,200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => trans('app.Something went wrong')
            ],503);
        }
    }
}
