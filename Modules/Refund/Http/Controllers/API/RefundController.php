<?php

namespace Modules\Refund\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Refund\Repositories\RefundReasonRepository;
use Modules\Refund\Repositories\RefundProcessRepository;
use App\Http\Resources\Api\v1\Orders\ReturnReasonsResource;

/**
* @group Refund & Despotes
*
* APIs for Refund & Despotes
*/

class RefundController extends Controller
{
    protected $refundReasonRepository;
    protected $refundProcessRepository;

    public function __construct(RefundReasonRepository $refundReasonRepository, RefundProcessRepository $refundProcessRepository){
        $this->refundReasonRepository = $refundReasonRepository;
        $this->refundProcessRepository = $refundProcessRepository;
    }

    //refund reason

    /**
     * Refund Reason
     * @response{
     *      "reasons": [
     *           {
     *               "id": 5,
     *               "reason": "Problematic Product.",
     *               "created_at": "2021-08-14T11:02:52.000000Z",
     *               "updated_at": "2021-08-14T11:02:52.000000Z"
     *           },
     *           {
     *               "id": 4,
     *               "reason": "Choose another product.",
     *               "created_at": "2021-08-14T11:02:18.000000Z",
     *               "updated_at": "2021-08-14T11:02:18.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "reason": "Change Of mind.",
     *               "created_at": "2021-08-14T11:02:02.000000Z",
     *               "updated_at": "2021-08-14T11:02:02.000000Z"
     *           }
     *       ],
     *       "measege": "success"
     * }
     */

    public function ReasonList(){
        $reasons = $this->refundReasonRepository->getAll();
        if(count($reasons) > 0){
            return response()->json([
                'reasons' => ReturnReasonsResource::collection($reasons),
                'measege' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.List empty')
            ],404);
        }
    }

    /**
     * Single Refund Reason
     * @response{
     *      "reason": {
     *           "id": 1,
     *           "reason": "Duplicate Product.",
     *           "created_at": "2021-08-14T11:01:34.000000Z",
     *           "updated_at": "2021-08-14T11:01:34.000000Z"
     *       },
     *       "message": "success"
     * }
     */

    public function reason($id){
        $reason = $this->refundReasonRepository->getById($id);

        if($reason){
            return response()->json([
                'reason' => $reason,
                'message' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ],404);
        }
    }


    //refund process

    /**
     * Process List
     * @response{
     *      "processes": [
     *           {
     *               "id": 1,
     *               "name": "Pending",
     *               "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
     *               Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *               "created_at": "2021-08-14T11:31:17.000000Z",
     *               "updated_at": "2021-08-14T11:31:17.000000Z"
     *           },
     *           {
     *               "id": 2,
     *               "name": "Processing",
     *               "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
     *                literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *               "created_at": "2021-08-14T11:31:33.000000Z",
     *               "updated_at": "2021-08-14T11:31:33.000000Z"
     *           },
     *           {
     *               "id": 3,
     *               "name": "Receive",
     *               "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from
     *               45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *               "created_at": "2021-08-14T11:31:47.000000Z",
     *               "updated_at": "2021-08-14T11:31:47.000000Z"
     *           },
     *           {
     *               "id": 4,
     *               "name": "Shipping",
     *               "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC,
     *                making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *               "created_at": "2021-08-14T11:32:08.000000Z",
     *               "updated_at": "2021-08-14T11:32:08.000000Z"
     *           },
     *           {
     *               "id": 5,
     *               "name": "Delivered",
     *               "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC,
     *                making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *               "created_at": "2021-08-14T11:32:23.000000Z",
     *               "updated_at": "2021-08-14T11:32:23.000000Z"
     *           }
     *       ],
     *       "measege": "success"
     * }
     */

    public function processList(){
        $processes = $this->refundProcessRepository->getAll();
        if(count($processes) > 0){
            return response()->json([
                'processes' => $processes,
                'measege' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.List empty')
            ],404);
        }
    }

    /**
     * Single Process
     * @response{
     *      "process": {
     *       "id": 1,
     *       "name": "Pending",
     *       "description": "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one",
     *       "created_at": "2021-08-14T11:31:17.000000Z",
     *       "updated_at": "2021-08-14T11:31:17.000000Z"
     *   },
     *   "message": "success"
     * }
     */

    public function process($id){
        $process = $this->refundProcessRepository->getById($id);
        if($process){
            return response()->json([
                'process' => $process,
                'message' => trans('app.Success')
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ],404);
        }
    }



}
