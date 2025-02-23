<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $general_setting = DB::table('general_settings')->first();
        if($general_setting)
        {
            $copyright  = '{"en":"Copyright \u00a9 Amazcart '.date("Y").'. All rights reserved."}';
            DB::table('general_settings')->where('id',$general_setting->id)->update([
                'footer_copy_right' => $copyright
            ]);
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
