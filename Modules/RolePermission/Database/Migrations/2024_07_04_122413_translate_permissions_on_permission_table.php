<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TranslatePermissionsOnPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('permissions','translation'))
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
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
