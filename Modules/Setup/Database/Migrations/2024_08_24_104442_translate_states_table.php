<?php

use Modules\Setup\Entities\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setup\Entities\City;

class TranslateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $states =  DB::table('states')->get();
       foreach($states as $state)
       {
           $st =  State::where('id',$state->id)->first();
           $st->setTranslation('name','en',$state->name);
           $st->save();
       }

       $cities =  DB::table('cities')->get();
       foreach($cities as $city)
       {
           $c =  City::where('id',$city->id)->first();
           $c->setTranslation('name','en',$city->name);
           $c->save();
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
