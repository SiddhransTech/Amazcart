<?php

namespace Modules\MultiVendor\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Setup\Services\StateService;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\MultiVendor\Services\ProfileService;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\MultiVendor\Repositories\CommisionRepository;
use Modules\MultiVendor\Http\Requests\SellerAccountRequest;
use Modules\MultiVendor\Http\Requests\SellerBankAccountRequest;
use Modules\MultiVendor\Http\Requests\SellerReturnAddressRequest;
use Modules\MultiVendor\Http\Requests\SellerWarehouseAddressRequest;
use Modules\MultiVendor\Http\Requests\SellerBusinessInformationRequest;

class ProfileController extends Controller
{
    protected $seller;
    protected $stateService;

    public function __construct(ProfileService $seller, StateService $stateService)
    {
        $this->middleware('maintenance_mode');
        $this->seller = $seller;
        $this->stateService = $stateService;
    }

    public function index()
    {
        $countries = $this->stateService->getCountries();

        if (Auth::check()) {
            $id = getParentSellerId();
            $seller = $this->seller->getData($id);
            $commissionRepo = new CommisionRepository();
            $commissions = $commissionRepo->getAll();
            $pricings = Pricing::where('status', 1)->get();
            return view('multivendor::profile.index', compact('seller', 'countries', 'commissions', 'pricings'));
        } else {
            return abort(404);
        }
    }


    public function sellerAccountUpdate(SellerAccountRequest $request, $id)
    {
        try {
            $request['holiday_date'] = date('Y-m-d',strtotime($request->holiday_date));
            $request['holiday_date_start'] = date('Y-m-d',strtotime($request->holiday_date_start));
            $request['holiday_date_end'] = date('Y-m-d',strtotime($request->holiday_date_end));
            $this->seller->sellerAccountUpdate($request->except('_token'), $id);
            if($request->commission_type == 3)
            {
                if(auth()->user()->role->type == 'seller')
                {
                    $subscription = getParentSeller()->SellerSubscriptions;
                    return redirect()->route('seller.subscription_payment_select',encrypt($subscription->id));
                }else{
                    $subscription = SellerSubcription::where('seller_id', $id)->first();
                    $plan = Pricing::where('id', $subscription->pricing_id)->first();
                    if($subscription->expiry_date == ''){
                        $expire_date = date("Y-m-d",strtotime("+".$plan->expire_in.' days',strtotime(date("Y-m-d"))), );
                    }else{
                        $expire_date = date("Y-m-d",strtotime("+".$plan->expire_in.' days',strtotime($subscription->expiry_date)));
                    }
                    $subscription->update([
                        "is_paid" => 1,
                        "expiry_date" => $expire_date,
                        "last_payment_date" => date("Y-m-d")
                    ]);
                }
            }

            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Seller account update successful.');
            $user  = getParentSeller();
            if ($user->role->type != 'superadmin' && $user->role->type != 'admin') {
                return redirect()->route('seller.profile.index');
            } else {
                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }
    public function businessInformationUpdate(SellerBusinessInformationRequest $request, $id)
    {

        try {
            $this->seller->businessInformationUpdate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Business information update successful.');
            $user  = auth()->user();
            if ($user->role->type != 'admin' && $user->role->type != 'superadmin') {
                return redirect()->route('seller.profile.index');
            } else {
                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }
    public function bankAccountUpdate(SellerBankAccountRequest $request, $id)
    {

        try {
            $this->seller->bankAccountUpdate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Bank account update successful.');
            $user  = auth()->user();
            if ($user->role->type != 'admin' && $user->role->type != 'superadmin') {
                return redirect()->route('seller.profile.index');
            } else {
                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }

    public function businessImgDelete(Request $request)
    {
        $del = $this->seller->businessImgDelete($request->id);
        LogActivity::successLog('Business img delete successful.');
        return $del;
    }

    public function bankImgDelete(Request $request)
    {
        $del = $this->seller->bankImgDelete($request->id);
        LogActivity::successLog('Bank img delete successful.');
        return $del;
    }

    public function warehouseAddressUpdate(SellerWarehouseAddressRequest $request, $id)
    {

        try {
            $this->seller->warehouseAddressUpdate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Warehouse address update successful.');
            $user  = auth()->user();
            if ($user->role->type != 'admin' && $user->role->type != 'superadmin') {
                return redirect()->route('seller.profile.index');
            } else {
                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }
    public function returnAddressUpdate(SellerReturnAddressRequest $request, $id)
    {

        try {
            $this->seller->returnAddressUpdate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Return address update successful.');
            $user  = auth()->user();
            if ($user->role->type != 'admin' && $user->role->type != 'superadmin') {
                return redirect()->route('seller.profile.index');
            } else {
                return back();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }

    public function returnAddresChange(Request $request)
    {

        $update = $this->seller->returnAddressChange($request->except('_token'));
        LogActivity::successLog('Return addres change successful.');
        return $update;
    }


    public function tabSelect($id)
    {
        Session::put('profile_tab', $id);
        return 'done';
    }
}
