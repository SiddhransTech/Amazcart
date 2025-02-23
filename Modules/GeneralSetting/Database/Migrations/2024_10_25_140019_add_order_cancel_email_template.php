<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\EmailTemplate;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\NotificationSetting;

class AddOrderCancelEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $email_type  = [
            "type" => 'order_cancel_email_template',
            'module' => null
        ];
        $hasType = EmailTemplateType::where('type','order_cancel_email_template')->first();
        if(!$hasType)
        {
            $type =  EmailTemplateType::create($email_type);
            $hasTemplate = EmailTemplate::where('type_id',$type->id)->first();
            if(!$hasTemplate){
                $template = [
                    "type_id" => $type->id,
                    "subject" => '{"en":"Order cancel"}',
                    "value" => $this->template(),
                    "is_active" => 1,
                    "reciepnt_type" => '["customer"]',
                    "short_codes" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",

                ];
                DB::table('email_templates')->insert($template);
            }
        }
        //Notification
            $hasNotification =  NotificationSetting::where('slug','order_cancel_email_template')->first();
            if(!$hasNotification)
            {
                NotificationSetting::create([
                    "event" => "Order Cancel",
                    "slug" => "order_cancel_email_template",
                    "type" => "system,email",
                    "message" => "Order has been canceled",
                    "admin_msg" => "Order has been canceled",
                    "user_access_status" => 1,
                    "seller_access_status" => 0,
                    "admin_access_status" => 1,
                    "staff_access_status" => 1
                ]);
            }

    }

    public function template(){

        return '{"en":"<div style=\"font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;\">Template</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"><p style=\"color: rgb(85, 85, 85);\">Hello {USER_FIRST_NAME}<br><br>An account has been created for you.</p><p style=\"color: rgb(85, 85, 85);\">Please use the following info to login your dashboard:</p><p style=\"color: rgb(85, 85, 85);\">{ORDER_TRACKING_NUMBER}<br></p><hr style=\"box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);\"><p style=\"color: rgb(85, 85, 85);\"><br></p><p style=\"color: rgb(85, 85, 85);\">{EMAIL_SIGNATURE}</p><p style=\"color: rgb(85, 85, 85);\"><br></p></div>\r\n<div style=\"font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;\">Template</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"></div>"}';

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
