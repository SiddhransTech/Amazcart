<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\CountryService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware('maintenance_mode');
        $this->countryService = $countryService;
    }

    public function index()
    {

        try{
            $countries = $this->countryService->getAll();

            return view('setup::location.country.index', compact('countries'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return $e->getMessage();
        }
    }

    public function store(Request $request){


        $request->validate([
            'name' =>'required|max:255|unique:countries',
            'code' => 'required|max:255|unique:countries',
            'phonecode' => 'required|max:255',
            'flag' => 'nullable|mimes:jpg,jpeg,bmp,png'
        ]);

        try{
            $this->countryService->store($request->except('_token'));
            LogActivity::successLog('Country Created Successfully');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function edit($id){

        try{
            $country = $this->countryService->getById($id);
            return view('setup::location.country.components.edit',compact('country',));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function update(Request $request){

        $request->validate([
            'name' =>'required|max:255|unique:countries,name,'.$request->id,
            'code' => 'required|max:255|unique:countries,code,'.$request->id,
            'phonecode' => 'required|max:255',
            'flag' => 'nullable|mimes:jpg,jpeg,bmp,png'
        ]);

        try{
            $this->countryService->update($request->except('_token'));
            LogActivity::successLog('Country Updated Successfully');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function status(Request $request){

        try{
            $this->countryService->status($request->except('_token'));
            LogActivity::successLog('country status updated successfully');
            return true;

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function get_states(Request $request){
        $states = [];
        $db_states =  \Modules\Setup\Entities\State::where('country_id',$request->get('country_id'))->get();
        foreach($db_states as $st)
        {

             $states[] = [
                "id" => $st->id,
                "name" => $st->name,
                "country_id" => $st->country_id,
                "status" => $st->status,
                "created_at" => $st->created_at,
                "updated_at" => $st->updated_at,
                "torod_country_id" =>$st->torod_country_id,
                "torod_state_id" => $st->torod_state_id,
             ];
        }
        return $states;
    }

    public function get_cities(Request $request){
        $cities = [];
        $db_cities =  $this->countryService->getCityByState($request->get('state_id'));
        foreach($db_cities as $ct)
        {
             $cities[] = [
                "id" => $ct->id,
                "name" => $ct->name,
                "state_id" => $ct->state_id,
                "status" => $ct->status,
                "created_at" => $ct->created_at,
                "updated_at" => $ct->updated_at,
                "torod_state_id" => $ct->torod_state_id,
                "torod_city_id" => $ct->torod_city_id,
             ];
        }
        return $cities;
    }

    private function reloadWithData(){

        try{
            $countries = $this->countryService->getAll();
            return response()->json([

                'TableData' =>  (string)view('setup::location.country.components.list', compact('countries',)),
                'createForm' =>  (string)view('setup::location.country.components.create')
            ],200);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

}
