<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\NotificationSetting;

class AddSupportTicketNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tickets = [
            ['event' => "Ticket Create", 'slug' => "ticket-created", 'type' => "system", 'admin_msg' => 'A ticket has been submitted', 'message' => 'A ticket has been submitted', 'seller_access_status' => 1, 'admin_access_status' => 1,'staff_access_status' => 1],
            ['event' => "Replied Ticket", 'slug' => "ticket-replied", 'type' => "system", 'admin_msg' => 'A ticket has been replied' , 'message' => 'A ticket has been replied', 'seller_access_status' => 1, 'admin_access_status' => 1,'staff_access_status' => 1],
        ];


        foreach($tickets as $ticket)
        {
            $notification = new NotificationSetting();
            $notification->setTranslation('admin_msg','en',$ticket['admin_msg']);
            $notification->setTranslation('message','en',$ticket['message']);
            $notification->setTranslation('event','en',$ticket['event']);
            $notification->type = $ticket['type'];
            $notification->slug = $ticket['slug'];
            $notification->user_access_status = 0;
            $notification->seller_access_status = $ticket['seller_access_status'];
            $notification->staff_access_status = $ticket['staff_access_status'];
            $notification->seller_access_status = $ticket['seller_access_status'];
            $notification->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
