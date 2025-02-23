<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\DynamicPage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(Schema::hasTable(table: 'dynamic_pages'))
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DynamicPage::query()->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $pages = base_path('static_sql/footerWidget.sql');
            DB::unprepared(file_get_contents(filename: $pages));
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
