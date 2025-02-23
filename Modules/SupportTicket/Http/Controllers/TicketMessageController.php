<?php

namespace Modules\SupportTicket\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Entities\TicketMessage;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\TicketMessageFile;
use Auth;
use App\Admin;
use App\Models\User;
use Notification;
use App\Notifications\SupportTicketNotification;
use App\Notifications\SupportTicketUserNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

use Modules\FormBuilder\Repositories\FormBuilderRepositories;
use Modules\OrderManage\Entities\CustomerNotification;
use Illuminate\Support\Facades\DB;

class TicketMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','maintenance_mode']);
    }



    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'ticket_id' => 'required|numeric',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,sql',
            'status_id' => 'nullable'
        ]);


        try {

            $ticket_id = $request->input('ticket_id');
            if ($request->text != '') {
                $ticketMessage = TicketMessage::create([
                    'ticket_id' => $ticket_id,
                    'text'      => $request->input('text'),
                    'user_id' => auth()->user()->id,
                    'type' => $request->type
                ]);


                if ($request->hasFile('ticket_file')) {

                    if (!file_exists(asset_path('uploads/message_ticket_image/'))) {
                        mkdir(asset_path('uploads/message_ticket_image/'), 0777, true);
                    }

                    $files = $request->file('ticket_file');
                    foreach ($files as $file) {
                        $file_original_name = $file->getClientOriginalName();
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $file->move(asset_path('uploads/message_ticket_image/'), $fileName);
                        $filePath = 'uploads/message_ticket_image/' . $fileName;

                        $messageFile = new TicketMessageFile();
                        $messageFile->message_id = $ticketMessage->id;
                        $messageFile->url = $filePath;
                        $messageFile->name = $file->getClientOriginalName();
                        $messageFile->type = $file->getClientOriginalExtension();
                        $messageFile->save();
                    }
                }
            }





            $status_id = $request->input('status_id');

            $this->updateTicketStatus($ticket_id, $status_id, Carbon::now());
            $tick = SupportTicket::where('id',$ticket_id)->first();
             $notification = DB::table('notification_settings')->where('slug','ticket-replied')->first();
             if ($notification) {
                //admin
                $user_id = $tick->user_id;
                if($tick->user_id == auth()->id())
                {
                    $user_id = 1;
                }
                $admin_notification = (array) json_decode($notification->message);
                $langs = getLanguageList();
                $adminNot = new CustomerNotification();
                foreach($langs as $key => $lang)
                {
                   if(isset($admin_notification[$lang->code]))
                   {
                       $adminNot->setTranslation('title',$lang->code,$admin_notification[$lang->code]);
                   }
                }
                $adminNot->customer_id = $user_id;
                $adminNot->read_status = 0;
                $adminNot->super_admin_read_status = 0;
                $adminNot->url = '#';
                $adminNot->save();
                //customer
             }

            Toastr::success(__('common.send_successfully'), __('common.success'));
            LogActivity::successLog('ticket message store successful.');
            return redirect()->back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }


    public function updateTicketStatus($ticketId, $statusId, $updated_at)
    {
        $ticket = SupportTicket::findOrFail($ticketId);

        if (!$statusId) {
            $statusId = $ticket->status_id;
        }
        if ($ticket->status_id != $statusId) {
            $ticket->status_id = $statusId;
        }
        $ticket->updated_at = $updated_at;

        LogActivity::successLog('ticket message update successful.');
        $ticket->save();
    }
}
