<?php
//   cart controller 
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Traits\GoogleAnalytics4;
use Illuminate\Http\Request;
use Exception;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\UserActivityLog\Traits\LogActivity;
use App\Http\Resources\CartsResource;
use App\Http\Controllers\API\MinQuantityForBoxDesign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    use GoogleAnalytics4;
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('maintenance_mode');
    }
    public function index()
    {
        try{
            $Data = $this->cartService->getCartData();
            $cartData = $Data['cartData'];
            //ga4
            if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
                $e_productName = 'Product';
                $e_sku = 'sku';
                $e_items = [];
                foreach ($cartData as $cD){
                    foreach ($cD as $c){
                        if($c['product_type'] == 'product'){
                            $e_product = SellerProductSKU::find($c['product_id']);
                            if($e_product){
                                $e_productName = $e_product->product->product_name;
                                $e_sku = !empty($e_product->sku) ? $e_product->sku->sku:'';
                            }
                        }elseif($c['product_type'] == 'gift_card'){
                            $e_product = GiftCard::find($c['product_id']);
                            if($e_product){
                                $e_productName = $e_product->name;
                                $e_sku = $e_product->sku;
                            }
                        }elseif($c['product_type'] == 'box_design'){
                            $e_productName = 'Custom Box Design';
                            $e_sku = 'BOX-'.$c['product_id'];
                        }
                        $e_items[]=[
                            "item_id"=> $e_sku,
                            "item_name"=> $e_productName,
                            "currency"=> currencyCode(),
                            "price"=> $c['price']
                        ];
                    }
                }
                $eData = [
                    'name' => 'view_cart',
                    'params' => [
                        "currency" => currencyCode(),
                        "value"=> 1,
                        "items" => $e_items,
                    ],
                ];
                $this->postEvent($eData);
            }
            //end ga4
            $shipping_costs = $Data['shipping_charge'];
            $free_shipping = $this->cartService->getFreeShipping();
            if(isModuleActive('MultiVendor') && app('general_setting')->seller_wise_payment){
                return view(theme('pages.cart_seller_to_seller'),compact('cartData','shipping_costs','free_shipping'));
            }
            return view(theme('pages.cart'),compact('cartData','shipping_costs','free_shipping'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e;
        }
    }


    public function getBoxDesignCartItems()
{
    try {
        // Initialize cart collection
        $carts = collect();

        // Fetch cart items based on user authentication
        if (auth()->check()) {
            $carts = \App\Models\Cart::with(['boxDesign'])
                ->where('user_id', auth()->user()->id)
                ->where('product_type', 'box_design')
                ->whereHas('boxDesign')
                ->get();
        } else {
            $carts = \App\Models\Cart::with(['boxDesign'])
                ->where('session_id', session()->getId())
                ->where('product_type', 'box_design')
                ->whereHas('boxDesign')
                ->get();
        }

        // Calculate total items
        $items = $carts->sum('qty');

        // Log successful retrieval
        LogActivity::successLog('Box design cart items retrieved successfully.');

        // Prepare response data
        $cartData = $carts->groupBy('seller_id'); // Group by seller if needed
        $shipping_costs = $this->cartService->getCartData()['shipping_charge']; // Reuse existing service method
        $free_shipping = $this->cartService->getFreeShipping();

        // Return view or JSON response based on your application's needs
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'cartData' => CartsResource::collection($carts),
                'items' => $items,
                'shipping_costs' => $shipping_costs,
                'free_shipping' => $free_shipping
            ]);
        }

        // Return view for non-JSON requests
        if (isModuleActive('MultiVendor') && app('general_setting')->seller_wise_payment) {
            return view(theme('pages.cart_seller_to_seller'), compact('cartData', 'shipping_costs', 'free_shipping'));
        }
        return view(theme('pages.cart'), compact('cartData', 'shipping_costs', 'free_shipping'));

    } catch (\Exception $e) {
        LogActivity::errorLog('Failed to retrieve box design cart items: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => env('APP_DEBUG') ? $e->getMessage() : 'An error occurred'
        ], 500);
    }
}
    // public function store(Request $request){
    //     try{
    //         $result = $this->cartService->store($request->except('_token'));
    //         if($result == 'out_of_stock'){
    //             return 'out_of_stock';
    //         }else{
    //             $carts = collect();
    //             if(auth()->check()){
    //                 $carts = \App\Models\Cart::with([
    //                     'product.product.product',
    //                     'giftCard',
    //                     'boxDesign', // Add this
    //                     'product.product_variations.attribute', 
    //                     'product.product_variations.attribute_value.color'
    //                 ])->where('user_id',auth()->user()->id)
    //                 ->where(function($query) {
    //                     $query->where('product_type', 'product')
    //                         ->whereHas('product',function($q){
    //                             return $q->where('status', 1)->whereHas('product', function($q){
    //                                 return $q->activeSeller();
    //                             });
    //                         })
    //                         ->orWhere('product_type', 'gift_card')
    //                         ->whereHas('giftCard', function($q){
    //                             return $q->where('status', 1);
    //                         })
    //                         ->orWhere('product_type', 'box_design')
    //                         ->whereHas('boxDesign');
    //                 })->get();
                    
    //             }else {
    //                 $carts = \App\Models\Cart::with('product.product.product','giftCard','product.product_variations.attribute', 'product.product_variations.attribute_value.color')->where('session_id',session()->getId())->where('product_type', 'product')->whereHas('product',function($query){
    //                     return $query->where('status', 1)->whereHas('product', function($q){
    //                         return $q->activeSeller();
    //                     });
    //                 })->orWhere('product_type', 'gift_card')->where('session_id', session()->getId())->whereHas('giftCard', function($query){
    //                     return $query->where('status', 1);
    //                 })->get();
    //             }
    //             $items = 0;
    //             foreach($carts as $cart){
    //                 $items += $cart->qty;
    //             }
    //             LogActivity::successLog('cart store successful.');
    //             return response()->json([
    //                 'cart_details_submenu' => (string) view(theme('partials._cart_details_submenu'),compact('carts','items')),
    //                 'count_bottom' => $items
    //             ]);
    //         }
    //     }catch(\Exception $e){

    //     }
    // }
    public function store(Request $request)
    {
        Log::info('Request Payload:', $request->all());

        DB::beginTransaction();
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'product_id' => 'nullable|required_if:product_type,product,gift_card|required_if:type,product,gift_card',
                'box_design_id' => 'nullable|required_if:product_type,box_design|required_if:type,box_design|exists:box_designs,id',
                'product_type' => 'required_without:type|in:product,gift_card,box_design',
                'type' => 'required_without:product_type|in:product,gift_card,box_design',
                'qty' => [
                    'required',
                    'numeric',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        if (($request->product_type === 'box_design' || $request->type === 'box_design') && $value < 50) {
                            $fail('Minimum quantity for box designs is 50');
                        }
                    }
                ],
                'price' => 'required|numeric|min:0.01',
                'seller_id' => 'required|exists:users,id'
            ]);

            if ($validator->fails()) {
                Log::error('Cart validation failed', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Use product_type or type
            $productType = $request->has('product_type') ? $request->product_type : $request->type;

            // Determine IDs based on product type
            $productId = $productType === 'box_design' ? null : $request->product_id;
            $boxDesignId = $productType === 'box_design' ? $request->box_design_id : null;

            // Handle authentication and session
            $user = auth()->user();
            $userId = $user ? $user->id : null;
            $sessionId = $user ? null : session()->getId();

            // Validate product, gift card, or box design existence
            if ($productType === 'product') {
                $sku = SellerProductSKU::find($request->product_id);
                if (!$sku) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found'
                    ], 404);
                }
            } elseif ($productType === 'gift_card') {
                $giftCard = GiftCard::find($request->product_id);
                if (!$giftCard) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gift card not found'
                    ], 404);
                }
            } elseif ($productType === 'box_design') {
                $boxDesign = \App\Models\BoxDesign::find($request->box_design_id);
                if (!$boxDesign) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Box design not found'
                    ], 404);
                }
            }

            // Skip stock check for box designs
            if ($productType !== 'box_design') {
                $result = $this->cartService->store($request->except('_token'));
                if ($result == 'out_of_stock') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Out of stock'
                    ], 400);
                }
            }

            // Prepare cart data
            $cartData = [
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $productId,
                'box_design_id' => $boxDesignId,
                'product_type' => $productType,
                'qty' => $request->qty,
                'price' => $request->price,
                'total_price' => $request->price * $request->qty,
                'seller_id' => $request->seller_id,
                'shipping_method_id' => 0,
                'sku' => null,
                'is_select' => 1
            ];

            Log::info('Creating/updating cart item', $cartData);

            // Create or update cart item
            $cartItem = \App\Models\Cart::updateOrCreate(
                [
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    ...($productType !== 'box_design' ? ['product_id' => $productId] : []),
                    ...($productType === 'box_design' ? ['box_design_id' => $boxDesignId] : []),
                    'product_type' => $productType
                ],
                [
                    'product_id' => $productId,
                    'box_design_id' => $boxDesignId,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'total_price' => $request->price * $request->qty,
                    'seller_id' => $request->seller_id,
                    'shipping_method_id' => 0,
                    'sku' => null,
                    'is_select' => 1
                ]
            );

            // Load relationships based on product type
            $relationships = [
                'product.product.product',
                'product.product_variations.attribute',
                'product.product_variations.attribute_value.color',
                'giftCard'
            ];

            if ($productType === 'box_design') {
                $relationships[] = 'boxDesign';
            }

            $cartItem->load($relationships);

            // Get cart count
            $cartCount = $userId
                ? \App\Models\Cart::where('user_id', $userId)->count()
                : \App\Models\Cart::where('session_id', $sessionId)->count();

            DB::commit();

            LogActivity::successLog('Cart item added successfully', [
                'type' => $productType,
                'id' => $productType === 'box_design' ? $boxDesignId : $productId,
                'cart_id' => $cartItem->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Added to cart',
                'count_bottom' => $cartCount,
                'cart_item' => new CartsResource($cartItem)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart store failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add to cart',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }
    public function update(Request $request){
        $this->cartService->update($request->except('_token'));
        return $this->reloadWithData();
    }
    public function updateCartShippingInfo(Request $request)
    {
        try {
            $this->cartService->updateCartShippingInfo($request->except('_token'));
            LogActivity::successLog('update cart info successful.');
            return $this->reloadWithData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e;
        }
    }
    public function updateQty(Request $request)
    {
        $this->cartService->updateQty($request->except('_token'));
        LogActivity::successLog('update cart qty successful.');
        return $this->reloadWithData();
    }
    public function sidebarUpdateQty(Request $request){
        $this->cartService->updateSidebarQty($request->except('_token'));
        LogActivity::successLog('update cart qty successful.');
        return $this->reloadWithData();
    }
    public function selectAll(Request $request)
    {
        $this->cartService->selectAll($request->except('_token'));
        $Data = $this->cartService->getCartData();
        $cartData = $Data['cartData'];
        $shipping_costs = $Data['shipping_charge'];
        return view(theme('partials._cart_details'),compact('cartData','shipping_costs'));
    }
    public function selectAllSeller(Request $request)
    {
        $this->cartService->selectAllSeller($request->except('_token'));
        $Data = $this->cartService->getCartData();
        $cartData = $Data['cartData'];
        $shipping_costs = $Data['shipping_charge'];
        return view(theme('partials._cart_details'),compact('cartData','shipping_costs'));
    }
    public function selectItem(Request $request)
    {
        $this->cartService->selectItem($request->except('_token'));
        $Data = $this->cartService->getCartData();
        $cartData = $Data['cartData'];
        $shipping_costs = $Data['shipping_charge'];
        return view(theme('partials._cart_details'),compact('cartData','shipping_costs'));
    }
    public function destroy(Request $request)
    {
        $this->cartService->deleteCartProduct($request->except('_token'));
        LogActivity::successLog('delete cart successful.');
        return $this->reloadWithData();
    }
    public function destroyAll()
    {
        $this->cartService->deleteAll();
        LogActivity::successLog('delete all cart successful.');
        return $this->reloadWithData();
    }
    private function reloadWithData(){
        $Data = $this->cartService->getCartData();
        $cartData = $Data['cartData'];
        $shipping_costs = $Data['shipping_charge'];
        $carts = collect();
        if(auth()->check()){
            $carts = \App\Models\Cart::with('product.product.product','giftCard','product.product_variations.attribute', 'product.product_variations.attribute_value.color')->where('user_id',auth()->user()->id)->where('product_type', 'product')->whereHas('product',function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('user_id',auth()->user()->id)->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();
        }else {
            $carts = \App\Models\Cart::with('product.product.product','giftCard','product.product_variations.attribute', 'product.product_variations.attribute_value.color')->where('session_id',session()->getId())->where('product_type', 'product')->whereHas('product',function($query){
                return $query->where('status', 1)->whereHas('product', function($q){
                    return $q->activeSeller();
                });
            })->orWhere('product_type', 'gift_card')->where('session_id', session()->getId())->whereHas('giftCard', function($query){
                return $query->where('status', 1);
            })->get();
        }
        $items = 0;
        foreach($carts as $cart){
            $items += $cart->qty;
        }
        $free_shipping = $this->cartService->getFreeShipping();
        if(isModuleActive('MultiVendor') && app('general_setting')->seller_wise_payment){
            $main_cart = (string)view(theme('partials._cart_details_seller_to_seller'),compact('cartData','shipping_costs','free_shipping'));
        }else{
            $main_cart = (string)view(theme('partials._cart_details'),compact('cartData','shipping_costs','free_shipping'));
        }
        return response()->json([
            'MainCart' =>  $main_cart,
            'SubmenuCart' =>  (string)view(theme('partials._cart_details_submenu'),compact('carts','items')),
            'count_bottom' => $items
        ]);
    }
}
