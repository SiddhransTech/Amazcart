<?php

namespace Modules\Setup\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\SetupService;
use Modules\Setup\Services\CountryService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Setup\Entities\AlgoliaSearchConfiguration;

class SetupController extends Controller
{
    protected $setupService;

    public function __construct(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function algoliaSearchConfig()
    {
        $algoliaSearch = AlgoliaSearchConfiguration::first();
        return response()->json([
            'algoliaSearch' => $algoliaSearch,
            'message' => trans('app.Success')
        ]);
    }

    public function updateAlgoliaSearchConfig(Request $request)
    {
        $status = $request->status;
        $algoliaSearch = $this->setupService->updateAlgoliaSearchConfig($status);

        if($algoliaSearch){
            return response()->json([
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.Error')
            ], 500);
        }
    }
}
