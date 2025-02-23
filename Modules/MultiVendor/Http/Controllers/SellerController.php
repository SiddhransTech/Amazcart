<?php

namespace Modules\MultiVendor\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OrderPayment;
use App\Traits\Notification;
use Illuminate\Http\Request;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\State;
use App\Models\OrderPackageDetail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Setup\Entities\Country;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Marketing\Entities\Coupon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\Review\Entities\SellerReview;
use Modules\Seller\Entities\SellerProduct;
use Illuminate\Contracts\Support\Renderable;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\MultiVendor\Services\SellerService;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\Refund\Entities\RefundRequestDetail;
use Modules\SidebarManager\Entities\Backendmenu;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Bkash\Http\Controllers\BkashController;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\SidebarManager\Entities\BackendmenuUser;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\FrontendCMS\Repositories\PricingRepository;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\Clickpay\Http\Controllers\ClickpayController;
use Modules\PaymentGateway\Services\PaymentGatewayService;
use Modules\MultiVendor\Entities\PackageWiseSellerCommision;
use Modules\PaymentGateway\Http\Controllers\PaytmController;
use Modules\PaymentGateway\Http\Controllers\PayPalController;
use Modules\PaymentGateway\Http\Controllers\StripeController;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\PaymentGateway\Http\Controllers\JazzCashController;
use Modules\PaymentGateway\Http\Controllers\MidtransController;
use Modules\PaymentGateway\Http\Controllers\PaystackController;
use Modules\PaymentGateway\Http\Controllers\RazorpayController;
use Modules\PaymentGateway\Http\Controllers\InstamojoController;
use Modules\PaymentGateway\Http\Controllers\PayUmoneyController;
use Modules\SslCommerz\Library\SslCommerz\SslCommerzNotification;
use Modules\PaymentGateway\Http\Controllers\BankPaymentController;
use Modules\PaymentGateway\Http\Controllers\FlutterwaveController;
use Modules\PaymentGateway\Http\Controllers\TabbyPaymentController;
class SellerController extends Controller
{
    use Notification;
    protected $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->middleware('maintenance_mode');
        $this->sellerService = $sellerService;
    }

    public function index()
    {
        $data['total_products'] = SellerProduct::TotalProducts();
        $data['total_orders'] = OrderPackageDetail::TotalOrders('today');
        $data['total_delivered_orders'] = OrderPackageDetail::TotalDeliveredOrders('today', 'delivered');
        $data['total_not_delivered_orders'] = OrderPackageDetail::TotalDeliveredOrders('today', 'not-delivered');
        $data['total_others_income'] = OrderPackageDetail::TotalOtherIncome('today')['total'];
        $data['total_net_product_sale'] = OrderPackageDetail::NetTotalProductSaleAmount('today');
        $data['total_sale'] = $data['total_others_income'] + $data['total_net_product_sale'];
        $data['shop_review'] = SellerReview::TotalReview('today');
        $data['total_commision'] = PackageWiseSellerCommision::TotalCommision('today');
        $data['total_refund'] = RefundRequestDetail::TotalRefund('today');
        $data['top_sale_products'] = SellerProduct::TopSaleProducts();
        $data['latest_uploaded_products'] = SellerProduct::LatestUploadedProducts();
        $data['latest_orders'] = OrderPackageDetail::LatestOrder();
        $data['latest_refund_requests'] = RefundRequestDetail::LatestRequest();
        $data['graph_total_orders'] = OrderPackageDetail::TotalOrders(null);
        $data['graph_total_delivered_orders'] = OrderPackageDetail::TotalDeliveredOrders(null, 'delivered');
        $data['graph_total_not_delivered_orders'] = OrderPackageDetail::TotalDeliveredOrders(null, 'not-delivered');
        $data['graph_total_shipping'] = OrderPackageDetail::TotalOtherIncome(null)['shipping_cost'];
        $data['graph_total_tax'] = OrderPackageDetail::TotalOtherIncome(null)['tax_amount'];
        $data['graph_total_net_sale'] = OrderPackageDetail::NetTotalProductSaleAmount(null);
        $data['graph_total_sale'] = OrderPackageDetail::TotalOtherIncome(null)['total'] + $data['graph_total_net_sale'];
        $data['graph_total_refund'] = RefundRequestDetail::TotalRefund(null);
        $data['subscription'] = SellerSubcription::with('pricing')->where('seller_id', getParentSellerId())->latest()->first();
        $data['sellerAccount'] = getParentSeller()->SellerAccount;
        $data['order_commission_for_admin'] = $this->sellerService->orderCommissionForAdmin('today');
        if ($data['subscription']) {
            $data['subscription_payment'] = Transaction::where('morphable_type', 'Modules\MultiVendor\Entities\SellerSubcription')->where('morphable_id', $data['subscription']->id)->latest()->take(10)->get();
        }

        return view('multivendor::dashboard.index', $data);
    }

    public function dashboardCards($type)
    {
        $total_orders = OrderPackageDetail::TotalOrders($type);
        $total_delivered_orders = OrderPackageDetail::TotalDeliveredOrders($type, 'delivered');
        $total_not_delivered_orders = OrderPackageDetail::TotalDeliveredOrders($type, 'not-delivered');
        $total_others_income = OrderPackageDetail::TotalOtherIncome($type)['total'];
        $total_net_product_sale = OrderPackageDetail::NetTotalProductSaleAmount($type);
        $total_sale = $total_others_income + $total_net_product_sale;
        $shop_review = SellerReview::TotalReview($type);
        $total_commision = PackageWiseSellerCommision::TotalCommision($type);
        $total_refund = RefundRequestDetail::TotalRefund($type);
        return [
            'total_orders' => $total_orders,
            'total_delivered_orders' => $total_delivered_orders,
            'total_not_delivered_orders' => $total_not_delivered_orders,
            'total_sale' => single_price($total_sale),
            'shop_review' => $shop_review,
            'total_refund' => single_price($total_refund),
            'total_commision' => single_price($total_commision)
        ];
    }


    public function subscriptionPaymentPageDetails($id, PaymentGatewayService $paymentGatewayService)
    {

        $id = decrypt($id);
        $data['seller_subscription'] = SellerSubcription::findOrFail($id);
        //$sellerAccount = getParentSeller()->SellerAccount;
        $data['recharge_amount'] = $data['seller_subscription']->pricing->plan_price;
        $walletRepo = new WalletRepository;
        $data['payment_gateways'] = $walletRepo->activePaymentGayteway();
        $data['gateway_activations'] = $paymentGatewayService->gateway_active()->where('method','!=','Cash On Delivery');
        return view('multivendor::seller_payment.payment', $data);
    }

    public function subscriptionPaymentPage($id, PaymentGatewayService $paymentGatewayService)
    {
        if(auth()->check() == false)
        {
            $user = User::find(session()->get('seller_user_id'));
            Auth::login($user);
        }
        $data['seller_subscription'] = SellerSubcription::findOrFail($id);
       //$sellerAccount = getParentSeller()->SellerAccount;
        $data['recharge_amount'] = $data['seller_subscription']->pricing->plan_price;
        $walletRepo = new WalletRepository;
        $gateway = $walletRepo->activePaymentGayteway();
        $gateway = $gateway->where('slug','!=','wallet');

        $data['gateway_activations'] = $gateway->where('method','!=','Cash On Delivery');
        return view('multivendor::seller_payment.payment_gateway', $data);
    }

    public function subscriptionPayment(Request $request)
    {
        if($request->method == 'Bank Payment'){
            $request->validate([
                "bank_name" => "required",
                "branch_name" => "required",
                "account_number" => "required",
                "account_holder" => "required",
                "image" => "nullable",
            ]);
        }

        try {
            session()->forget('coupon_discount');
            session()->forget('coupon_id');
            session()->forget('coupon_type');
            session()->forget('coupon_amount');
            session()->put('subscription_payment', '1');
            if(empty($request->method) || $request->method  == ''){
                Toastr::error('Payment method is not selected');
                return back();
            }



            DB::beginTransaction();
            if ($request->method == "Stripe") {
                $stripeController = new StripeController;
                $response = $stripeController->stripePost($request->all());
                if(gettype($response) == 'object'){
                    return redirect()->back();
                }
            }
            if ($request->method == "RazorPay") {
                $razorpayController = new RazorpayController;
                $response = $razorpayController->payment($request->all());
            }
            if ($request->method == "Paypal") {
                $paypalController = new PayPalController;
                $response = $paypalController->payment($request->all());
            }
            if ($request->method == "Paystack") {
                $paystackController = new PaystackController;
                return $paystackController->redirectToGateway();
            }
            if ($request->method == "Bank Payment") {

                $bankController = new BankPaymentController;
                $response = $bankController->store($request->all());
            }
            if ($request->method == "PayTm") {
                $paytm = new PaytmController;
                return $paytm->payment($request->all());
            }
            if ($request->method == "Instamojo") {
                $instamojo = new InstamojoController;
                return $instamojo->paymentProcess($request->all());
            }
            if ($request->method == "Midtrans") {
                $midtrans = new MidtransController;
                return $midtrans->paymentProcess($request->all());
            }
            if ($request->method == "Tabby") {
                $tabbyPaymentController = new TabbyPaymentController;
                return $tabbyPaymentController->paymentProcess($request->all());
            }
            if ($request->method == "PayUMoney") {
                $PayUMoney = new PayUmoneyController;
                $data = $request->all();
                $data['amount'] = $request->pay_amount;
                return $PayUMoney->payment($data);
            }
            if ($request->method == "JazzCash") {
                $JazzCash = new JazzCashController;
                return $JazzCash->paymentProcess($request->all());
            }
            if ($request->method == "flutterwave") {
                $flutterWaveController = new FlutterwaveController;
                return $flutterWaveController->payment($request->all());
            }
            if ($request->method == "Bkash") {
                $data['gateway_id'] = encrypt(15);
                $bkashController = new BkashController();
                $response = $bkashController->bkashSuccess($request->all());
            }

            if($request->method == 'Clickpay')
            {
                $data = $request->all();
                $customer['name'] = $request->customer_name;
                $customer['amount'] = round($request->amount,2);
                $customer['email'] = $request->customer_email;
                $customer['phone'] = $request->customer_phone;
                $customer['zip'] = $request->customer_postal_code;
                $customer['description'] = "Products Checkout";
                $customer['callback'] = route('clickpay.callback');
                $customer['return'] = route('clickpay.return');
                $customer['address'] = $request->customer_address;
                $state = State::find($request->customer_state);
                $customer['state'] = !empty($state) ?$state->name:'Riyad';
                $city = City::find($request->customer_city);
                $customer['city'] = !empty($city) ? $city->name:'Ar-Riyad';
                $country = Country::find($request->customer_country);
                $customer['country'] = !empty($country) ? $country->code:'SA';
                $customer['payment_for'] = 'subscription-payment';
                $customer['entry_payment_id'] = auth()->id();
                $clickpay = new ClickpayController();
                $response = $clickpay->payment($customer);
                if($response != false){
                    session()->forget('coupon_discount');
                    session()->forget('coupon_id');
                    session()->forget('coupon_type');
                    return redirect()->to($response)->send();
                }else{
                    Toastr::error(trans('common.Something Went Wrong'),trans('common.error'));
                    return back();
                }
            }

            if ($request->method == "SslCommerz") {
                $post_data = array();
                $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = uniqid(); // tran_id must be unique

                # CUSTOMER INFORMATION
                $post_data['cus_name'] = 'Customer Name';
                $post_data['cus_email'] = 'customer@mail.com';
                $post_data['cus_add1'] = 'Customer Address';
                $post_data['cus_add2'] = "";
                $post_data['cus_city'] = "";
                $post_data['cus_state'] = "";
                $post_data['cus_postcode'] = "";
                $post_data['cus_country'] = "Bangladesh";
                $post_data['cus_phone'] = '8801XXXXXXXXX';
                $post_data['cus_fax'] = "";

                # SHIPMENT INFORMATION
                $post_data['ship_name'] = "Store Test";
                $post_data['ship_add1'] = "Dhaka";
                $post_data['ship_add2'] = "Dhaka";
                $post_data['ship_city'] = "Dhaka";
                $post_data['ship_state'] = "Dhaka";
                $post_data['ship_postcode'] = "1000";
                $post_data['ship_phone'] = "";
                $post_data['ship_country'] = "Bangladesh";

                $post_data['shipping_method'] = "NO";
                $post_data['product_name'] = "Computer";
                $post_data['product_category'] = "Goods";
                $post_data['product_profile'] = "physical-goods";

                # OPTIONAL PARAMETERS
                $post_data['value_a'] = "ref001";
                $post_data['value_b'] = "ref002";
                $post_data['value_c'] = "ref003";
                $post_data['value_d'] = "ref004";

                session(['ssl_payment_type' => $request->type]);
                $sslc = new SslCommerzNotification();
                $payment_options = $sslc->makePayment($post_data);
                $payment_options = \GuzzleHttp\json_decode($payment_options);
                if ($payment_options->status == "success") {
                    return Redirect::to($payment_options->data);
                } else {
                    return redirect('/seller/dashboard');
                }
            }
            if ($request->method == "MercadoPago") {
                $mercadoPagoController = new MercadoPagoController();
                $response = $mercadoPagoController->payment($request->all());

                // send notification
                $notificationUrl = route('admin.subscription_payment_list');
                $notificationUrl = str_replace(url('/'),'',$notificationUrl);
                $this->notificationUrl = $notificationUrl;
                $this->adminNotificationUrl = '/admin/subscription-payment-list';
                $this->routeCheck = 'admin.subscription_payment_list';
                $this->typeId = EmailTemplateType::where('type', 'subscription_payment_email_template')->first()->id;
                $notification = NotificationSetting::where('slug','seller-payout')->first();
                if ($notification) {
                    $this->notificationSend($notification->id, auth()->id());
                }
                DB::commit();
                Toastr::success(__('common.successful'), __('common.success'));
                LogActivity::successLog('Subscription payment successful.');
                return response()->json(['target_url'=>route('seller.dashboard')]);
            }
            // send notification
            $notificationUrl = route('admin.subscription_payment_list');
            $notificationUrl = str_replace(url('/'),'',$notificationUrl);
            $this->notificationUrl = $notificationUrl;
            $this->adminNotificationUrl = '/admin/subscription-payment-list';
            $this->routeCheck = 'admin.subscription_payment_list';
            $this->typeId = EmailTemplateType::where('type', 'subscription_payment_email_template')->first()->id;
            $notification = NotificationSetting::where('slug','seller-payout')->first();
            if ($notification) {
                $this->notificationSend($notification->id, auth()->id());
            }
            DB::commit();
            $this->setupSidebar(auth()->user());
            Toastr::success(__('common.successful'), __('common.success'));
            LogActivity::successLog('Subscription payment successful.');
            return redirect()->route('seller.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function my_subscription_payment()
    {
        $data['subscription'] = SellerSubcription::with('pricing')->where('seller_id', getParentSellerId())->latest()->first();
        $data['sellerAccount'] = getParentSeller()->sellerAccount;
        if ($data['subscription']) {
            $data['subscription_payment'] = Transaction::where('morphable_type', 'Modules\MultiVendor\Entities\SellerSubcription')->where('morphable_id', $data['subscription']->id)->latest()->get();
            return view('multivendor::seller_payment.index', $data);
        }
        return view('multivendor::seller_payment.index');
    }

    public function subscription_payment_index()
    {
        return view('multivendor::subscription_payments.index');
    }

    public function subscription_payment_dtbl()
    {
        $subscription = SubsciptionPaymentInfo::latest();

        return DataTables::of($subscription)
            ->addIndexColumn()
            ->addColumn('name', function ($subscription) {
                return @$subscription->transaction->morphable->user->first_name . ' ' . @$subscription->transaction->morphable->user->last_name;
            })
            ->addColumn('subcription', function ($subscription) {
                return @$subscription->transaction->subscription_payment->commission_type;
            })
            ->addColumn('type', function ($subscription) {
                return 'Yearly';
            })
            ->addColumn('date', function ($subscription) {
                return dateConvert($subscription->created_at);
            })
            ->addColumn('expire_date', function ($subscription) {
                $seller_subscription = DB::table('seller_subcriptions')->where('seller_id',$subscription->seller_id)->first();
                if($seller_subscription)
                {
                   if(!empty($seller_subscription->expiry_date))
                   {
                     return showDate($seller_subscription->expiry_date);
                   }
                }
            })
            ->addColumn('payment_method', function ($subscription) {
                return view('multivendor::subscription_payments.component.method_name', compact('subscription'));
            })
            ->addColumn('amount', function ($subscription) {
                return single_price($subscription->transaction->amount);
            })
            ->addColumn('txn_id', function ($subscription) {
                return $subscription->txn_id;
            })
            ->addColumn('is_approved', function ($subscription) {
                return view('multivendor::subscription_payments.component.status', compact('subscription'));
            })
            ->rawColumns(['is_approved'])
            ->toJson();
    }

    public function approve(Request $request)
    {
        try {
            $subscription_payment = SubsciptionPaymentInfo::findOrFail($request->id);
            $this->expiry_date_set($request->id);
            if ($subscription_payment) {
                $subscription_payment->transaction->morphable->update(['is_paid' => 1]);
                $subscription_payment->update(['is_approved' => $request->status]);
                LogActivity::successLog('Subscription payment approve successful.');
                return 1;
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function expiry_date_set($id)
    {
        $seller_id = SubsciptionPaymentInfo::where('id', $id)->with('transaction')->first()->transaction->created_by;

        $seller_subcription = SellerSubcription::where('seller_id', $seller_id)->oldest()->first();

        $seller_account = SellerAccount::where('user_id', $seller_id)->first();
        $package = Pricing::where('id', $seller_subcription->pricing_id)->first();
        $days = !empty($package) ? $package->expire_in:0;

        if($seller_subcription->expiry_date != null && strtotime($seller_subcription->expiry_date) > strtotime('Y-m-d')){
            $expiry_date = date('Y-m-d', strtotime("+".$days." days", strtotime($seller_subcription->expiry_date)));
        }else{
            $expiry_date = date('Y-m-d', strtotime("+".$days." days", strtotime($seller_subcription->last_payment_date)));
        }
        $seller_subcription->update(['expiry_date' => $expiry_date]);
    }


    public function subscription_crone_job()
    {
        try {
            Artisan::call('command:sellerSubscription');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function bulk_product_upload()
    {
        return view('multivendor::bulk_product_upload.index');
    }

    public function orderCommissionForAdmin(){
        return view('multivendor::order_commission.index');
    }

    public function getOrderCommision(Request $request){

        $data = $this->sellerService->orderCommissionForAdminViaFilter(isset($request->filter)?$request->filter:'today');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('payout_date', function ($data) {
                return dateConvert($data->created_at);
            })
            ->addColumn('order_id', function ($data) {
                return $data->order->order_number;
            })
            ->addColumn('order_amount', function ($data) {
                return single_price($data->amount);
            })
            ->addColumn('commision_amount', function ($data) {
                return single_price($data->commision_amount);
            })
            ->addColumn('payment_method', function ($data) {
                return $data->GatewayName;
            })
            ->addColumn('txn_id', function ($data) {
                return $data->txn_id??'-';
            })
            ->toJson();
    }

    public function planApplyCoupon(Request $request, $plan_id)
    {
        $data = $request->all();
        try{
            $pricing = Pricing::where('id',$plan_id)->first();
            $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_type',4)
                                                                    ->where('is_expire',0)
                                                                    ->where('end_date','>=',date("Y-m-d",strtotime("+1 day")))
                                                                    ->first();

            $discount = 0;
            if(!empty($pricing) && !empty($coupon))
            {
                $price = $pricing->plan_price;
                if($pricing->discount_type ==0)
                {
                    $price = $pricing->plan_price - $pricing->discount;
                }else{
                    $discount_per = ($pricing->plan_price * $pricing->discount)/100;
                    $price = $pricing->plan_price - $discount_per;
                }



                if($coupon->discount_type == 1)
                {
                    $discount = $coupon->discount;
                }else{

                    $discount = ($price * $coupon->discount) / 100;
                }
                session()->put('coupon_discount',$discount);
                session()->put('coupon_id',$coupon->id);
                session()->put('coupon_type',$coupon->discount_type);
                session()->put('coupon_amount',$coupon->discount);
                return response()->json([
                    'status' => 1,
                    "msg" => "Coupon applied successful"
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    "msg" => "Invalid Coupon code"
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 0,
                "msg" => "Something went wrong"
            ]);
        }

    }

    public function setupSidebar($user)
    {
        $role_id = $user->role->type;
        if ($role_id == 'seller') {
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_seller', 1)->get();
        }else{
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_admin', 1)->get();

        }
        $backendMenuUser = BackendmenuUser::with('backendMenu')->where('user_id', $user->id)->get();
            if($backendMenuUser->count() != $backend_menus->count()){

                $backend_menu_not_exsist = $backend_menus->whereNotIn('id', $backendMenuUser->pluck('backendmenu_id')->toArray());
                foreach($backend_menu_not_exsist as $menu){

                    $parent_id = null;
                    $position = 0;
                    if($menu->parent_id){
                        $parentMenu = BackendmenuUser::where('backendmenu_id', $menu->parent_id)->where('user_id', $user->id)->first();
                        if($parentMenu){
                            $parent_id  = $parentMenu->id;
                            $position = BackendmenuUser::where('parent_id', $parent_id)->where('user_id', $user->id)->count() + 1;
                        }
                    }

                    BackendmenuUser::create(['parent_id' => $parent_id, 'user_id' => $user->id, 'backendmenu_id' => $menu->id, 'position' => $position]);
                }
            }
    }

}
