<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Product\Entities\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Resources\SliderResource;
use Modules\Product\Entities\Category;
use Modules\Language\Entities\Language;
use App\Http\Resources\LanguageResource;


use App\Http\Resources\ToppicksResource;
use App\Http\Resources\FlashDealResource;
use Modules\Marketing\Entities\FlashDeal;
use App\Http\Resources\NewUserZoneResource;
use App\Http\Resources\TopCategoryResource;
use Modules\Marketing\Entities\NewUserZone;
use App\Http\Resources\FeaturedBrandResource;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomCategory;
use App\Http\Resources\Api\v1\RecommendedProductListResource;

class HomepageController extends Controller
{
    public function index()
    {
        $homepagesection = HomePageSection::where('section_name', 'feature_categories')->first();

        $categories = Category::with(['sellerProducts.product', 'sellerProducts.seller', 'categoryImage', 'parentCategory', 'subCategories'])->whereHas('sellerProducts');
        if ($homepagesection->type == 1) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 2) {
            $categories = $categories->latest();
        }
        if ($homepagesection->type == 3) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 4) {
            $categories = $categories->orderByDesc('avg_rating');
        }
        if ($homepagesection->type == 6) {
            $category_ids = HomepageCustomCategory::where('section_id', $homepagesection->id)->pluck('category_id')->toArray();
            $categories = $categories->whereRaw("id in ('" . implode("','", $category_ids) . "')");
        }
        $paginate = 12;
        if (app('theme')->folder_path == 'amazy') {
            $paginate = 8;
        }
        if ($homepagesection->type == 5) {
            $categories = $categories->withCount('sellerProducts')->orderByDesc('seller_products_count')->take(12)->get();
        } else {
            $categories = $categories->take($paginate)->get();
        }
        $top_categories = TopCategoryResource::collection($categories);
        $brands = Brand::where('status', 1)->where('featured', 1)->latest()->take(20)->get();
        $featured_brands = FeaturedBrandResource::collection($brands);
        $sliders = HeaderSliderPanel::where('status', 1)->where('data_type', '!=', 'url')->orderBy('position')->get();
        $sliders = SliderResource::collection($sliders);
        $new_user_zone = NewUserZone::with('coupon.coupon')->where('status', 1)->first();
        if ($new_user_zone) {
            $new_user_zone = new NewUserZoneResource($new_user_zone);
        } else {
            $new_user_zone = null;
        }

        $flash_deall = FlashDeal::where('status', 1)->first();
        $flash_deal = null;
        if ($flash_deall) {
            $flash_deal = new FlashDealResource($flash_deall);
        }

        $section = HomePageSection::where('section_name', 'top_picks')->first();

        if ($section) {
            $top_picks =   ToppicksResource::collection($section->getApiProductByQuery());
        }

        return response()->json([
            'top_categories' => $top_categories,
            'featured_brands' => $featured_brands,
            'sliders' => $sliders,
            'new_user_zone' => $new_user_zone,
            "flash_deal" => $flash_deal,
            "top_picks" => $top_picks,
            'msg' => trans('app.Success'),
        ], 200);
    }

    public function recomandedProduct()
    {
        $products = HomePageSection::where('section_name', 'more_products')->first()->getHomePageProductByQuery();
        return RecommendedProductListResource::collection($products);
    }
    public function getTopCategoryData()
    {
        $homepagesection = HomePageSection::where('section_name', 'feature_categories')->first();
        $categories = Category::with(['sellerProducts.product', 'sellerProducts.seller', 'categoryImage', 'parentCategory', 'subCategories'])->whereHas('sellerProducts');
        if ($homepagesection->type == 1) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 2) {
            $categories = $categories->latest();
        }
        if ($homepagesection->type == 3) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 4) {
            $categories = $categories->orderByDesc('avg_rating');
        }
        if ($homepagesection->type == 6) {
            $category_ids = HomepageCustomCategory::where('section_id', $homepagesection->id)->pluck('category_id')->toArray();
            $categories = $categories->whereRaw("id in ('" . implode("','", $category_ids) . "')");
        }
        $paginate = 12;
        if (app('theme')->folder_path == 'amazy') {
            $paginate = 8;
        }
        if ($homepagesection->type == 5) {
            $categories = $categories->withCount('sellerProducts')->orderByDesc('seller_products_count')->take(12)->get();
        } else {
            $categories = $categories->take($paginate)->get();
        }
        $top_categories = TopCategoryResource::collection($categories);
        if (count($top_categories) > 0) {
            return response()->json([
                'top_categories' => $top_categories,
                'message' => trans('app.Success'),
            ], 200);
        } else {
            return response()->json([
                'message' => trans('app.No data found'),
            ], 404);
        }
    }

    public function getFeaturedBrandData()
    {
        $brands = Brand::where('status', 1)->where('featured', 1)->latest()->take(20)->get();
        $featured_brands = FeaturedBrandResource::collection($brands);
        if (count($featured_brands) > 0) {
            return response()->json([
                'featured_brands' => $featured_brands,
                'message' =>  trans('app.Success'),
            ], 200);
        } else {
            return response()->json([
                'message' => trans('app.No data found'),
            ], 404);
        }
    }

    public function getSliderData()
    {
        $sliders = HeaderSliderPanel::where('status', 1)->where('data_type', '!=', 'url')->orderBy('position')->get();
        $sliders = SliderResource::collection($sliders);
        if (count($sliders) > 0) {
            return response()->json([
                'sliders' => $sliders,
                'message' => trans('app.Success'),
            ], 200);
        } else {
            return response()->json([
                'message' => trans('app.No data found'),
            ], 404);
        }
    }

    public function getTopPickData()
    {
        $section = HomePageSection::where('section_name', 'top_picks')->first();
        if ($section) {
            $top_picks = ToppicksResource::collection($section->getApiProductByQuery());
        } else {
            $top_picks = [];
        }
        if (count($top_picks) > 0) {
            return response()->json([
                'top_picks' => $top_picks,
                'message' => trans('app.Success'),
            ], 200);
        } else {
            return response()->json([
                'message' => trans('app.No data found'),
            ], 404);
        }
    }


    public function setLocale(Request $request)
    {
        try{
            if($request->lang && auth()->check())
            {
                app()->setLocale($request->lang);
                \Session::put('locale',$request->lang);

                User::where('id',auth()->id())->update([
                    "lang_code" => $request->lang,
                ]);
                return response()->json([
                    "lang" => $request->lang,
                    "success" => true,
                    "message" => trans("app.Language changed successfully")
                ],'200');
            }
            return response()->json([
                "status" => 0,
                "message" => trans("app.Language code can not be empty")
            ],'200');
        }catch(\Exception $e){
            return response()->json([
                "data" => [],
                "message" => trans('app.Something went wrong'),
                "success" => trans('app.error')
            ],501);
        }
    }


    public function getLanguages()
    {
        try{
            $languages = Language::where('status',1)->get();
            $langs =  LanguageResource::collection($languages);
            return response()->json([
                "data" => $langs,
                "message" => trans("app.getting data"),
                "success" => true
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "data" => [],
                "message" => trans('app.Something went wrong'),
                "success" => trans('app.error')
            ],501);
        }
    }

    public function getLang(Request $request)
    {

        $locale = !empty($request->get('lang')) ? $request->get('lang'):'en';
        $language = Language::where('status',1)->where('code',$locale)->first();
        if($language)
        {
            app()->setLocale($locale);
            \Session::put('locale',$locale);
            $lang_array = Lang::get("app");
            $data = [
                "rtl" =>  $language->rtl == 1 ? true:false,
                "code" =>  $language->code,
                "native" =>  $language->native,
                "lang" =>  $lang_array,
                "message" =>  trans("app.getting data"),
            ];
            return response()->json([
                "data" =>  $data,
                "success" => true
            ]);
        }
    }
}
