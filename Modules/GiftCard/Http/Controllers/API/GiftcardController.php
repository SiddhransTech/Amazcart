<?php

namespace Modules\GiftCard\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\GiftCardRepository;
use Illuminate\Contracts\Support\Renderable;
/**
* @group Giftcards
*
* APIs for Giftcards
*/
class GiftcardController extends Controller
{
    protected $giftcardRepository;
    public function __construct(GiftCardRepository $giftcardRepository){
        $this->giftcardRepository = $giftcardRepository;
    }

    /**
     * Giftcard List
     * @response{
     *      "giftcards": {
     *       "current_page": 1,
     *       "data": [
     *           {
     *               "id": 1,
     *               "name": "gift card $100",
     *               "sku": "gift-card-100",
     *               "selling_price": 100,
     *               "thumbnail_image": "uploads/images/12-08-2021/6115214880e05.jpeg",
     *               "discount": 5,
     *               "discount_type": 0,
     *               "start_date": "2021-08-01",
     *               "end_date": "2021-11-30",
     *               "description": "<p>test product</p>",
     *               "status": 1,
     *               "avg_rating": 0,
     *               "created_by": 1,
     *               "updated_by": null,
     *               "shipping_id": 1,
     *               "created_at": "2021-08-12T13:25:28.000000Z",
     *               "updated_at": "2021-08-12T13:31:35.000000Z",
     *               "galary_images": [],
     *               "shipping_method": {
     *                    shipping info
     *                }
     *           }
     *       ],
     *       "first_page_url": "http://ecommerce.test/api/gift-card/list?page=1",
     *       "from": 1,
     *       "last_page": 1,
     *       "last_page_url": "http://ecommerce.test/api/gift-card/list?page=1",
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/gift-card/list?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "next_page_url": null,
     *       "path": "http://ecommerce.test/api/gift-card/list",
     *       "per_page": 10,
     *       "prev_page_url": null,
     *       "to": 1,
     *       "total": 1
     *   },
     *   "message": "success"
     * }
     */

    public function index(){
        $giftcards = $this->giftcardRepository->getAll('new',10);
        if(count($giftcards) > 0){
            return response()->json([
                'giftcards' => $giftcards,
                'seller' => app('general_setting')->company_name,
                'message' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'giftcards' => $giftcards,
                'message' => trans('app.List empty')
            ], 404);
        }
    }

    /**
     * Single Giftcard
     * @urlParam slug string required giftcard sku
     * @response{
     *      "giftcard": {
     *       "id": 1,
     *       "name": "gift card $100",
     *       "sku": "gift-card-100",
     *       "selling_price": 100,
     *       "thumbnail_image": "uploads/images/12-08-2021/6115214880e05.jpeg",
     *       "discount": 5,
     *       "discount_type": 0,
     *       "start_date": "2021-08-01",
     *       "end_date": "2021-11-30",
     *       "description": "<p>test product</p>",
     *       "status": 1,
     *       "avg_rating": 0,
     *       "created_by": 1,
     *       "updated_by": null,
     *       "shipping_id": 1,
     *       "created_at": "2021-08-12T13:25:28.000000Z",
     *       "updated_at": "2021-08-12T13:31:35.000000Z",
     *       "ActiveReviews": {
     *           "current_page": 1,
     *           "data": [],
     *           "first_page_url": "http://ecommerce.test/api/gift-card/gift-card-100?page=1",
     *           "from": null,
     *           "last_page": 1,
     *           "last_page_url": "http://ecommerce.test/api/gift-card/gift-card-100?page=1",
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://ecommerce.test/api/gift-card/gift-card-100?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "next_page_url": null,
     *           "path": "http://ecommerce.test/api/gift-card/gift-card-100",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": null,
     *           "total": 0
     *       },
     *       "galary_images": [],
     *       "shipping_method": {
     *           "id": 1,
     *           "method_name": "Email Delivery (within 24 Hours)",
     *           "logo": null,
     *           "phone": "25656895655",
     *           "shipment_time": "12-24 hrs",
     *           "cost": 0,
     *           "is_active": 1,
     *           "request_by_user": null,
     *           "is_approved": 1,
     *           "created_at": null,
     *           "updated_at": "2021-08-08T04:05:13.000000Z"
     *       }
     *   },
     *   "seller": "Amaz cart",
     *   "message": "success"
     * }
     */


    public function giftcard($slug){
        $giftcard = $this->giftcardRepository->getBySlug($slug);

        if($giftcard){
            return response()->json([
                'giftcard' => $giftcard,
                'seller' => app('general_setting')->company_name,
                'message' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ],404);
        }
    }




    /**
     * Customers Purchased Giftcards
     *
     * @response{
     *      "giftcards": {
     *       "current_page": 1,
     *       "data": [
     *           {
     *               "id": 1,
     *               "gift_card_id": 1,
     *               "qty": 1,
     *               "order_id": 3,
     *               "is_used": 1,
     *               "secret_code": "210814-124626-7863-13041",
     *               "mail_sent_date": "2021-08-14",
     *               "is_mail_sent": 1,
     *               "created_at": "2021-08-14T06:46:26.000000Z",
     *               "updated_at": "2021-08-14T06:48:26.000000Z",
     *               "order": {
     *                   "id": 3,
     *                   "customer_id": 4,
     *                   "order_payment_id": 3,
     *                   "order_type": null,
     *                   "order_number": "order-9595-210814121455",
     *                   "payment_type": 4,
     *                   "is_paid": 1,
     *                   "is_confirmed": 1,
     *                   "is_completed": 1,
     *                   "is_cancelled": 0,
     *                   "cancel_reason_id": null,
     *                   "customer_email": "customer@gmail.com",
     *                   "customer_phone": "2365659686569",
     *                   "customer_shipping_address": 1,
     *                   "customer_billing_address": 1,
     *                   "number_of_package": 1,
     *                   "grand_total": 95,
     *                   "sub_total": 100,
     *                   "discount_total": 5,
     *                   "shipping_total": 0,
     *                   "number_of_item": 1,
     *                   "order_status": 0,
     *                   "tax_amount": 0,
     *                   "created_at": "2021-08-14T06:14:55.000000Z",
     *                   "updated_at": "2021-08-14T06:46:21.000000Z"
     *               },
     *               "gift_card": {
     *                   "id": 1,
     *                   "name": "gift card $100",
     *                   "sku": "gift-card-100",
     *                   "selling_price": 100,
     *                   "thumbnail_image": "uploads/images/12-08-2021/6115214880e05.jpeg",
     *                   "discount": 5,
     *                   "discount_type": 0,
     *                   "start_date": "2021-08-01",
     *                   "end_date": "2021-11-30",
     *                   "description": "<p>test product</p>",
     *                   "status": 1,
     *                   "avg_rating": 0,
     *                   "created_by": 1,
     *                   "updated_by": null,
     *                   "shipping_id": 1,
     *                   "created_at": "2021-08-12T13:25:28.000000Z",
     *                   "updated_at": "2021-08-12T13:31:35.000000Z",
     *                   "galary_images": [],
     *                   "shipping_method": {
     *                           shipping info
     *                       }
     *               }
     *           }
     *       ],
     *       "first_page_url": "http://ecommerce.test/api/gift-card/my-purchased-list?page=1",
     *       "from": 1,
     *       "last_page": 1,
     *       "last_page_url": "http://ecommerce.test/api/gift-card/my-purchased-list?page=1",
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/gift-card/my-purchased-list?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "next_page_url": null,
     *       "path": "http://ecommerce.test/api/gift-card/my-purchased-list",
     *       "per_page": 6,
     *       "prev_page_url": null,
     *       "to": 1,
     *       "total": 1
     *   },
     *   "message": "Success"
     *
     * }
     */
    public function myPurchasedGiftcardList(Request $request){

        $giftcards = $this->giftcardRepository->myPurchasedGiftCard($request->user(),$request->all());
        if(count(value: $giftcards) > 0){
            return response()->json([
                'giftcards' => $giftcards,
                'message' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.List empty')
            ],404);
        }
    }

    /**
     * Giftcard add to wallet
     * @bodyParam secret_code string required secret code
     * @response{
     *      "mesage": "Allready Used"
     * }
     */
     public function giftcardAddToWallet(Request $request){

        $request->validate([
            'secret_code' => 'required'
        ]);

        $result = $this->giftcardRepository->myPurchasedGiftCardRedeemToWalletFromWalletRecharge($request->all(), $request->user());
        if($result == 'success'){
            return response()->json([
                'mesage' => trans('app.Redeem Successfully')
            ],201);
        }
        elseif($result == 'used'){
            return response()->json([
                'mesage' => trans('app.Allready Used')
            ],202);
        }else{
            return response()->json([
                'mesage' => trans('app.Invalid Gift card')
            ],404);
        }

     }
}
