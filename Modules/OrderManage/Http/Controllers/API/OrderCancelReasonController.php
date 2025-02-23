<?php

namespace Modules\OrderManage\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Routing\Controller;
use App\Http\Resources\CancelReasonResource;
use Illuminate\Contracts\Support\Renderable;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\OrderManage\Repositories\CancelReasonRepository;

/**
* @group Order Manage
*
* APIs for customer Order
*/
class OrderCancelReasonController extends Controller
{
    protected $cancelReasonRepository;
    protected $orderService;
    public function __construct(CancelReasonRepository $cancelReasonRepository, OrderService $orderService){
        $this->cancelReasonRepository = $cancelReasonRepository;
        $this->orderService = $orderService;
    }

    /**
     * Order Cancel Reasons
     * @response{
     *      "reasons": [
     *           {
     *               "id": 1,
     *               "name": "Change of mind.",
     *               "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, co",
     *               "created_at": "2021-08-14T12:42:19.000000Z",
     *               "updated_at": "2021-08-14T12:42:19.000000Z"
     *           },
     *           {
     *               "id": 2,
     *               "name": "Late delivery.",
     *               "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, co",
     *               "created_at": "2021-08-14T12:42:34.000000Z",
     *               "updated_at": "2021-08-14T12:42:34.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "name": "Seller is not good.",
     *               "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, co",
     *               "created_at": "2021-08-14T12:42:54.000000Z",
     *               "updated_at": "2021-08-14T12:42:54.000000Z"
     *           }
     *       ],
     *       "message": "success"
     * }
     */

    public function index(){
        $reasons = $this->cancelReasonRepository->getAll();
        $reasons = CancelReasonResource::collection($reasons);
        if(count($reasons) > 0){
            return response()->json([
                'reasons' => $reasons,
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.List empty')
            ], 404);
        }
    }

    /**
     * Single Order Cancel Reason
     * @response{
     *      "reason": {
     *           "id": 1,
     *           "name": "Change of mind.",
     *           "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, co",
     *           "created_at": "2021-08-14T12:42:19.000000Z",
     *           "updated_at": "2021-08-14T12:42:19.000000Z"
     *       },
     *       "message": "success"
     * }
     */

    public function reason($id){
        $reason = $this->cancelReasonRepository->getById($id);
        if($reason){
            return response()->json([
                'reason' => $reason,
                'message' => trans('app.Success')
            ], 200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ], 404);
        }
    }

    /**
     * Order Cancel
     * @bodyParam order_id string required example: Order-69-210920125307
     * @bodyParam reason integer required example: 2
     * @response{
     *      "message": "Order Cancelled Successfully"
     * }
     */

    public function cancelStore(Request $request){

        $request->validate([
            'order_id' => 'required',
            'reason' => 'required',
        ]);

        try {
            $data = $this->orderService->orderFindByOrderID($request->order_id);
            if($data){
                if($request->user()->id == $data->customer_id && $data->is_confirmed != 1){
                    $data->update([
                        'is_cancelled' => 1,
                        'cancel_reason_id' => $request->reason
                    ]);
                    foreach($data->packages as $pkg){
                        $pkg->update([
                            'is_cancelled' => 1
                        ]);
                    }
                    LogActivity::successLog('Purchase order cancel successful for '.$request->user()->first_name);
                    return response()->json([
                        'message' => trans('app.Order Cancelled Successfully')
                    ],202);
                }else {
                    return response()->json([
                        'message' => trans('app.Order not found')
                    ],404);
                }
            }else{
                return response()->json([
                    'message' => trans('app.Order Cancelled Failed')
                ],302);
            }

            return 'ok';
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'message' => trans('app.order not cancelled. error occured')
            ],503);

        }
    }


}
