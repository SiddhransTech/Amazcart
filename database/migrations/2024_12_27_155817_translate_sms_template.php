<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\SmsTemplate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try{
            $smss = DB::table('sms_templates')->get();
            foreach($smss as $sms)
            {
                $s = SmsTemplate::where('id',$sms->id)->first();
                $s->update([
                    "value" => $sms->value,
                    //"subject" => $sms->subject,
                ]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
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
