<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAlgoliaSearchConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('algolia_search_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        DB::statement("INSERT INTO `algolia_search_configurations` (`id`, `status`, `created_at`, `updated_at`) VALUES
        (1, 0, '2023-04-13 08:55:58', NULL)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('algolia_search_configurations');
    }
}
