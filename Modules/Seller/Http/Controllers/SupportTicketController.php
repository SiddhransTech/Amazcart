<?php

namespace Modules\Seller\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use Modules\Seller\Http\Requests\CreateSupportTicketMessageRequest;
use Modules\Seller\Http\Requests\CreateSupportTicketRequest;
use Modules\Seller\Http\Requests\UpdateSupportTicketRequest;
use Modules\Seller\Services\SupportTicketService;
use Modules\SupportTicket\Entities\SupportTicket;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Illuminate\Support\Facades\DB;
class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->middleware('maintenance_mode');
        $this->supportTicketService = $supportTicketService;
    }

    public function index()
    {
        try{
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['StatusList'] = $this->supportTicketService->statusList();
            $data['TicketList'] = $this->supportTicketService->getTickets();

            if(isset($_GET['category_id'])){
                $data['category_id'] = $_GET['category_id'];
            }
            if(isset($_GET['priority_id'])){
                $data['priority_id'] = $_GET['priority_id'];
            }
            if(isset($_GET['status_id'])){
                $data['status_id'] = $_GET['status_id'];
            }

            return view('seller::support_ticket.index', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){

        $TicketList = $this->supportTicketService->getTickets();
        return DataTables::of($TicketList)
        ->addIndexColumn()
        ->addColumn('subject', function($TicketList){
            return '<a target="_blank" href="'.route('seller.support-ticket.show',$TicketList->id).'">'.$TicketList->subject.'</a>';
        })
        ->addColumn('category', function($TicketList){
            return $TicketList->category->name;
        })
        ->addColumn('priority', function($TicketList){
            return $TicketList->priority->name;
        })
        ->addColumn('status', function($TicketList){
            return $TicketList->status->name;
        })
        ->addColumn('action',function($TicketList){
            return view('seller::support_ticket.components._action_td',compact('TicketList'));
        })
        ->rawColumns(['subject','action'])
        ->toJson();

    }


    public function search(Request $request){

        $category_id = $request->category_id;
        $priority_id = $request->priority_id;
        $status_id = $request->status_id;
        $TicketList = $this->supportTicketService->getBySearch($category_id,$priority_id,$status_id);

        return DataTables::of($TicketList)
        ->addIndexColumn()
        ->addColumn('subject', function($TicketList){
            return '<a target="_blank" href="'.route('seller.support-ticket.show',$TicketList->id).'">'.$TicketList->subject.'</a>';
        })
        ->addColumn('category', function($TicketList){
            return $TicketList->category->name;
        })
        ->addColumn('priority', function($TicketList){
            return $TicketList->priority->name;
        })
        ->addColumn('status', function($TicketList){
            return $TicketList->status->name;
        })
        ->addColumn('action',function($TicketList){
            return view('seller::support_ticket.components._action_td',compact('TicketList'));
        })
        ->rawColumns(['subject','action'])
        ->toJson();
    }

    public function create()
    {
        try{
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['StatusList'] = $this->supportTicketService->statusList();
            return view('seller::support_ticket.create', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }


    public function store(CreateSupportTicketRequest $request)
    {
        try{
            
            $this->supportTicketService->store($request->except('_token'));
            $notification = DB::table('notification_settings')->where('slug','ticket-created')->first();
            if ($notification) {
                //admin
                $admin_notification = (array) json_decode($notification->admin_msg);
                $langs = getLanguageList();
                $adminNot = new CustomerNotification();
                foreach($langs as $key => $lang)
                {
                   if(isset($admin_notification[$lang->code]))
                   {
                       $adminNot->setTranslation('title',$lang->code,$admin_notification[$lang->code]);
                   }
                }
                $adminNot->customer_id = 1;
                $adminNot->read_status = 0;
                $adminNot->super_admin_read_status = 0;
                $adminNot->url = '#';
                $adminNot->save();
                //customer
            }
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Support Ticket Created Successfully.');
            return redirect()->route('seller.support-ticket.index');
        }
        catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }


    public function show($id)
    {

        try{
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['StatusList'] = $this->supportTicketService->statusList();
            $data['SupportTicket'] = $this->supportTicketService->getById($id);
            return view('seller::support_ticket.show', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function message(CreateSupportTicketMessageRequest $request){

        try{
            $this->supportTicketService->createMessage($request->except('_token'));
            Toastr::success(__('ticket.replied_successfully'), __('common.success'));
            LogActivity::successLog('Support Ticket Replied Successfully.');
            return redirect()->back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit($id)
    {
        try{
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['StatusList'] = $this->supportTicketService->statusList();
            $data['editData'] = $this->supportTicketService->getById($id);
            return view('seller::support_ticket.edit', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }


    public function update(UpdateSupportTicketRequest $request, $id)
    {
        try{
            $this->supportTicketService->update($request->except('_token'), $id);

            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Support Ticket Updated Successfully.');
            return redirect()->route('seller.support-ticket.index');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }



}
