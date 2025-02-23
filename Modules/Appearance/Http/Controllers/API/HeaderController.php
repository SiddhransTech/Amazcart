<?php

namespace Modules\Appearance\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Appearance\Services\HeaderService;
use Modules\Appearance\Transformers\SliderResource;

/**
* @group Appearance
*
* APIs For Appearance
*/
class HeaderController extends Controller
{
    protected $headerService;
    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    /**
     * Slider List
     *
     * @response{
     *  "data": [
     *       {
     *           "id": 1,
     *           "name": "KTM RC 390",
     *           "url": null,
     *           "data_type": "product",
     *           "data_id": 1,
     *           "slider_image": "uploads/images/14-06-2021/60c6da6f7adde.png",
     *           "status": 1,
     *           "is_newtab": 1,
     *           "position": 598776,
     *           "created_at": "2021-06-14T04:26:23.000000Z",
     *           "updated_at": "2021-06-14T04:26:23.000000Z",
     *           "product": {
     *               "id": 1,
     *               "user_id": 4,
     *               "product_id": 2,
     *               "tax": 15,
     *               "tax_type": "0",
     *               "discount": 50,
     *               "discount_type": "1",
     *               "discount_start_date": "06/01/2021",
     *               "discount_end_date": "07/31/2021",
     *               "product_name": "KTM RC 390",
     *               "slug": "ktm-rc-390-4",
     *               "thum_img": null,
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 6500,
     *               "max_sell_price": 6500,
     *               "total_sale": 0,
     *               "avg_rating": 0,
     *               "recent_view": "2021-06-14 10:26:55",
     *               "created_at": "2021-06-03T05:57:34.000000Z",
     *               "updated_at": "2021-06-14T04:26:55.000000Z",
     *               "variantDetails": [],
     *               "MaxSellingPrice": 6500,
     *               "hasDeal": 0,
     *               "rating": 0,
     *               "skus": [
     *                   {
     *                       "id": 1,
     *                       "user_id": 4,
     *                       "product_id": 1,
     *                       "product_sku_id": "2",
     *                       "product_stock": 0,
     *                       "purchase_price": 0,
     *                       "selling_price": 6500,
     *                       "status": 1,
     *                       "created_at": "2021-06-03T05:57:34.000000Z",
     *                       "updated_at": "2021-06-03T05:57:34.000000Z",
     *                       "product_variations": []
     *                   }
     *               ],
     *               "reviews": []
     *           },
     *           "category": {
     *               "id": 1,
     *               "name": "Electronics",
     *               "slug": "electronics",
     *               "parent_id": 0,
     *               "depth_level": 1,
     *               "icon": null,
     *               "searchable": 1,
     *               "status": 1,
     *               "total_sale": 35,
     *               "avg_rating": 0.15,
     *               "commission_rate": 10,
     *               "created_at": "2021-05-31T07:27:03.000000Z",
     *               "updated_at": "2021-06-13T11:19:09.000000Z",
     *               "AllProducts": {
     *                   product info ...
     *               },
     *           "brand": {
     *               "id": 1,
     *               "name": "Samsung",
     *               "logo": "uploads/images/31-05-2021/60b4902a55d8d.jpeg",
     *               "description": null,
     *               "link": null,
     *               "status": 1,
     *               "featured": 1,
     *               "meta_title": null,
     *               "meta_description": null,
     *               "sort_id": 3,
     *               "total_sale": 0,
     *               "avg_rating": 0,
     *               "slug": "samsung",
     *               "created_by": null,
     *               "updated_by": 1,
     *               "created_at": "2021-05-31T07:28:42.000000Z",
     *               "updated_at": "2021-06-08T10:55:28.000000Z",
     *               "AllProducts": {
     *                   product info ...
     *               },
     *           "tag": {
     *               "id": 1,
     *               "product_id": 1,
     *               "tag": "apple",
     *               "created_at": "2021-06-01T12:31:38.000000Z",
     *               "updated_at": "2021-06-01T12:31:38.000000Z"
     *           }
     *       }
     *   ]
     * }
     */

    public function getSliders(){
        $sliders = $this->headerService->getSliders();

        if(count($sliders) > 0){
            return SliderResource::collection($sliders);
        }else{
            return response()->json([
                'message' => trans('app.slider not found')
            ],404);
        }
    }

    /**
     * Single slider
     * @urlParam id integer required id of slider
     * @response{
     *  "data": {
     *       "id": 9,
     *       "name": "test from tag",
     *       "url": null,
     *       "data_type": "tag",
     *       "data_id": 4,
     *       "slider_image": "uploads/images/13-06-2021/60c5d7217b91e.png",
     *       "status": 1,
     *       "is_newtab": 1,
     *       "position": 598776,
     *       "created_at": "2021-06-13T10:00:01.000000Z",
     *       "updated_at": "2021-06-13T10:00:01.000000Z",
     *       "product": {
     *
     *       },
     *       "category": {
     *
     *       },
     *       "brand": null,
     *       "tag": {
     *           "id": 4,
     *           "product_id": 3,
     *           "tag": "ktm",
     *           "created_at": "2021-05-29T07:13:28.000000Z",
     *           "updated_at": "2021-05-29T07:13:28.000000Z"
     *       }
     *   }
     * }
     */

    public function getSingleSlider($id){
        $slider = $this->headerService->getSingleSlider($id);
        if($slider){
            return new SliderResource($slider);
        }else{
            return response()->json([
                'message' => trans('app.slider not found')
            ],404);
        }
    }
}
