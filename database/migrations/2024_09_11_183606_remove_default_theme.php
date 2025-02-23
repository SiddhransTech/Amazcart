<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Appearance\Entities\Theme;
use Modules\Appearance\Entities\ThemeColor;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(Schema::hasTable('themes'))
        {
               $default_theme = Theme::where('folder_path',operator: 'default',)->first();
               if($default_theme)
               {
                  $default_theme = Theme::query()->where('folder_path',operator: 'amazy',)->update([
                    "status" => 1,
                    "is_active" => 1
                  ]);
                  Theme::where('id',$default_theme)->delete();
               }
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
