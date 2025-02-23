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
        if(Schema::hasTable('home_page_sections'))
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('home_page_sections')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $home_page_section = base_path('static_sql/homepage_sections.sql');
            DB::unprepared(file_get_contents($home_page_section));
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
