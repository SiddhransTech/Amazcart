<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Traits\SendMail;
use Illuminate\Support\Str;
use App\Traits\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Brand;
use Illuminate\Support\Facades\Lang;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Schema;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\UnitType;
use Modules\GiftCard\Entities\GiftCard;

use Modules\Marketing\Entities\BulkSMS;
use Modules\Product\Entities\Attribute;
use Illuminate\Database\Schema\Blueprint;
use Modules\Seller\Entities\SellerProduct;
use SebastianBergmann\LinesOfCode\Counter;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\GeneralSetting\Entities\SmsTemplate;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\OrderManage\Entities\DeliveryProcess;
use Modules\GeneralSetting\Entities\VersionHistory;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;

class DemoController extends Controller
{
    use SendMail, Notification;
    public function translate()
    {

        $notification = NotificationSetting::where('slug','new-order')->first();

        if ($notification) {
            $this->notificationSend($notification->id,2);
        }




    }

    public function dbImport()
    {
        DeliveryProcess::query()->delete();
        $sql_path = base_path('static_sql/delivery_process.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    public function permissionTranslate()
    {
        $permissions = DB::table('permissions')->get();
        $trans = [];
        foreach($permissions as $permission)
        {
            $permission_key = str_replace('-','_',Str::slug($permission->name));
            $key = 'permission.'.$permission_key;
            DB::table('permissions')->where('id',$permission->id)->update(['translation' => $key]);
            $trans[$permission_key] = $permission->name;
        }
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("notification_setting_id")->nullable();
            $table->foreign("user_id")->on("users")->references("id")->onDelete('cascade');
            $table->foreign("notification_setting_id")->on("notification_settings")->references("id")->onDelete('cascade');
            $table->string("type")->nullable();
            $table->timestamps();
        });
        $users = User::all();

        foreach($users as $user){
            $notificationSettings =(new NotificationSetting())->getNotificationSettingByUserRoleType($user->id);
            foreach($notificationSettings as $notificationSetting){
                UserNotificationSetting::create([
                    'user_id' => $user->id,
                    'notification_setting_id' =>  $notificationSetting->id,
                    'type' => $notificationSetting->type
                ]);
            }
        }

        $notifications = CustomerNotification::whereNotIn('id',[66,67,68])->get();
        foreach($notifications as $noti)
        {
            $nt = CustomerNotification::where('id',$noti->id)->first();
            if($nt)
            {
                $nt->setTranslation('title','en',$nt->title);
                $nt->save();
            }
        }

    }


    public function supportTicket()
    {

        $sub_permissions = [
            [
                "id" => 1004,
                "module_id" => 56,
                "parent_id" => 1001,
                "module" => "Torod",
                "name" => "Warehouses",
                "route" => "torod.warehouses",
                "type" => 2,
                "translation" => "torod.warehouses"
            ],
            [
                "id" => 1005,
                "module_id" => 56,
                "parent_id" => 1004,
                "module" => "Torod",
                "name" => "Create",
                "route" => "torod.warehouses.create",
                "type" => 3,
                "translation" => "torod.warehouse_create"
            ],
            [
                "id" => 1006,
                "module_id" => 56,
                "parent_id" => 1004,
                "module" => "Torod",
                "name" => "Edit",
                "route" => "torod.warehouses.edit",
                "type" => 3,
                "translation" => "torod.warehouse_edit"
            ],
            [
                "id" => 1007,
                "module_id" => 56,
                "parent_id" => 1004,
                "module" => "Torod",
                "name" => "Delete",
                "route" => "torod.warehouses.delete",
                "type" => 3,
                "translation" => "torod.warehouse_delete"
            ],
        ];
        DB::table('permissions')->insert($sub_permissions);

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


    public function email()
    {

            $order = Order::query()->first();
            $notificationUrl = route('frontend.my_purchase_order_detail',encrypt($order->id));
            $notificationUrl = str_replace(url('/'),'',$notificationUrl);
            $this->notificationUrl = $notificationUrl;
            $this->adminNotificationUrl = 'ordermanage/total-sales-list';
            $this->routeCheck = 'order_manage.total_sales_index';
            $this->typeId = EmailTemplateType::where('type','order_cancel_email_template')->first()->id;//order email templete type id
            $this->order_on_notification = $order;
            $notification = NotificationSetting::where('slug','order_cancel_email_template')->first();

            if ($notification) {
                $this->notificationSend($notification->id, $order->customer_id);
            }
            return $order;

    }



    public function testJazzCash()
    {
        return view('jaazcash_test');
    }
}
