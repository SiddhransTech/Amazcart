<?php

namespace Modules\Setup\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\CountryService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Setup\Transformers\CityResource;
use Modules\Setup\Transformers\StateResource;
use Modules\Setup\Transformers\CountryResource;

/**
* @group Location
*
* APIs for location like country, state , city
*/
class LocationController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Country
     * @response{
     *     "countries" :{
     *     {
                *"id": 1,
                *"code": "AF",
                *"name": "Afghanistan",
                *"phonecode": "93",
                *"flag": "\/flags\/flag-of-Afghanistan.jpg",
                *"status": 1,
                *"created_at": null,
                *"updated_at": null
    *       }
     *    }
     * }
     */

    public function getCountry(){
        $countries = $this->countryService->getActiveAll();

        if(count($countries) > 0){
            return response()->json([
                'countries' => CountryResource::collection($countries),
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans("app.Not found")
            ]);
        }
    }

    /**
     * State by Country
     * @response{
     * "states": [
    *    {
    *        "id": 337,
    *        "name": "Bagar Hat",
    *        "country_id": 18,
    *        "status": 1,
    *        "created_at": null,
    *        "updated_at": null,
    *        "country": {
    *            "id": 18,
    *            "code": "BD",
    *            "name": "Bangladesh",
    *            "phonecode": "880",
    *            "flag": "/flags/flag-of-Bangladesh.jpg",
    *            "updated_at": null
    *            "status": 1,
    *            "created_at": null,
    *        }
    *    }
    *    ]
     * }
     */

    public function getStateByCountry($id){
        $states = $this->countryService->getStateByCountry($id);
        if(count($states) > 0){
            return response()->json([
                'states' => StateResource::collection($states),
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ]);
        }
    }


    /**
     * City by state
     * @response{
     *
     * "cities": [
     *       {
     *           "id": 7264,
     *           "name": "Bandarban",
     *           "state_id": 338,
     *           "status": 1,
     *           "created_at": null,
     *           "updated_at": null,
     *           "state": {
     *               "id": 338,
     *               "name": "Bandarban",
     *               "country_id": 18,
     *               "status": 1,
     *               "created_at": null,
     *               "updated_at": null
     *           }
     *       }
     *   ],
     *   "message": "success"
     * }
     */

    public function getCityByState($id){
        $cities = $this->countryService->getCityByState($id);
        if(count($cities) > 0){
            return response()->json([
                'cities' => CityResource::collection($cities),
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ]);
        }
    }
}
