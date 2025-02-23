<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateMigrationForAlgoliaMenuDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $menu = DB::table('backendmenus')->where('route','setup.algolia.search.config')->first();
        if($menu)
        {
            DB::table('backendmenu_users')->where("backendmenu_id", $menu->id)->delete();
            DB::table('backendmenus')->where('id',$menu->id)->first();
            DB::table('permissions')->where('route','setup.algolia.search.config')->delete();
        }

        // $analytics  = DB::table("permissions")->where('route','setup.google-analytics-update')->first();
        // if($analytics)
        // {
        //    $getAnalytics =  DB::table("permissions")->where('id',$analytics->id)->update([
        //        "route" => "setup.google-analytics-update"
        //    ]);

        // }

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
