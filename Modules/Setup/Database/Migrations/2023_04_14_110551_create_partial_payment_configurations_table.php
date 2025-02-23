<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePartialPaymentConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partial_payment_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        DB::statement("INSERT INTO `partial_payment_configurations` (`id`, `status`, `created_at`, `updated_at`) VALUES
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
        Schema::dropIfExists('partial_payment_configurations');
    }
}
