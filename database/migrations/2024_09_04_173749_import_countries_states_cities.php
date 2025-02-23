<?php

use Illuminate\Support\Facades\DB;
use Modules\Setup\Entities\Country;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\State;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if(Schema::hasTable('countries'))
        {
            Country::query()->truncate();
            $country_path = base_path('static_sql/countries.sql');
            DB::unprepared(file_get_contents($country_path));
        }

        if(Schema::hasTable('states'))
        {
            State::query()->truncate();
            $country_path = base_path('static_sql/states.sql');
            DB::unprepared(file_get_contents($country_path));
        }

        if(Schema::hasTable('cities'))
        {
            
            City::query()->truncate();
            $file_directory = base_path('static_sql/cities');
            $total_files = count(\File::files($file_directory));
            for($i=1;$i<=$total_files;$i++){
                $sql_path = base_path('static_sql/cities/cities_'.$i.'.sql');
                DB::unprepared(file_get_contents($sql_path));
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');






    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
