<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $storage = base_path("modules_statuses.json");
        $file = file_get_contents($storage);
        $json = json_decode($file);
        unset($json->PageBuilder);
        file_put_contents($storage, json_encode($json, JSON_PRETTY_PRINT));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
