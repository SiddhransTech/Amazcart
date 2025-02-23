<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\UserActivityLog\Traits\LogActivity;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try{
            $template_types = [
                "order_invoice_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "order_pending_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "paid_payment_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "order_declined_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "order_confirmed_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "order_completed_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "refund_confirmed_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "refund_declined_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "delivery_process_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER}",
                "refund_money_paid_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "refund_pending_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "refund_money_pending_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "refund_completed_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "refund_process_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "gift_card_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{SECRET_CODE},{GIFT_CARD_NAME}",
                "review_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "newsletter_email_template" => "{USER_FIRST_NAME},{WEBSITE_NAME},{EMAIL_SIGNATURE}",
                "wallet_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "order_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE},{ORDER_TRACKING_NUMBER},{WEBSITE_NAME}",
                "register_email_template" => "{CUSTOMER_NAME},{CUSTOMER_EMAIL},{APP_NAME},{EMAIL_SIGNATURE}",
                "notification_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "support_ticket_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "verification_email_template" => "{USER_FIRST_NAME},{VERIFICATION_LINK},{EMAIL_SIGNATURE}",
                "product_review_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "product_disable_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "product_approve_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "product_review_approve_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "product_update_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "withdraw_request_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "Send digital file" => "{USER_FIRST_NAME},{DIGITAL_FILE_LINK},{EMAIL_SIGNATURE}",
                "Subscription email verify" => "{USER_FIRST_NAME},{VERIFICATION_LINK},{EMAIL_SIGNATURE}",
                "Password Reset"=> "{USER_FIRST_NAME},{RESET_LINK},{EMAIL_SIGNATURE}",
                "sub_seller_create_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "seller_create_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "password_reset_otp_email_template" => "{USER_FIRST_NAME},{OTP},{EMAIL_SIGNATURE}",
                "login_otp_email_template" => "{USER_FIRST_NAME},{OTP},{EMAIL_SIGNATURE}",
                "order_otp_email_template" => "{USER_FIRST_NAME},{OTP},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}",
                "registration_otp_email_template" => "{USER_FIRST_NAME},{OTP},{EMAIL_SIGNATURE}",
                "subscription_payment_email_template" => "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "seller_approve_email_template" => "{USER_FIRST_NAME},{WEBSITE_NAME},{EMAIL_SIGNATURE}",
                "seller_suspended_email_template" =>  "{USER_FIRST_NAME},{EMAIL_SIGNATURE}",
                "user_activation_template" => "{USER_FIRST_NAME},{VERIFICATION_LINK},{WEBSITE_NAME},{EMAIL_SIGNATURE",
                "new_user_registration_template" =>  "{USER_FIRST_NAME},{WEBSITE_NAME},{EMAIL_SIGNATURE",

            ];
            $keys = array_keys($template_types);
            foreach($keys as $type)
            {
                $short_code = isset($template_types[$type]) ? $template_types[$type]:'';
                $tem_type = DB::table('email_template_types')->where('type','LIKE',$type)->first();
                if($tem_type)
                {
                    $template = DB::table('email_templates')->where('type_id',$tem_type->id)->first();
                    if($template)
                    {
                        DB::table('email_templates')->where('id',$template->id)->update(
                            [
                                "short_codes" => $template_types[$type]
                            ]
                        );
                    }
                }
            }
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
