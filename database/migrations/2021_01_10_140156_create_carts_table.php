<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('product_type', 50)->nullable();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedInteger('qty')->default(1);
            $table->double('price')->default(0);
            $table->double('total_price')->default(0);
            $table->string('sku')->nullable();
            $table->boolean('is_select')->default(0);
            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->unsignedBigInteger('box_design_id')->nullable();
            $table->foreign('box_design_id')->references('id')->on('box_designs');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
                
            $table->foreign('seller_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        // Make sure box_designs table exists first
        if (Schema::hasTable('box_designs')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->foreign('box_design_id')
                    ->references('id')->on('box_designs')
                    ->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['box_design_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['seller_id']);
        });
        
        Schema::dropIfExists('carts');
    }
}



// -- Make product_id nullable
// ALTER TABLE `carts` MODIFY `product_id` BIGINT UNSIGNED NULL;

// -- Add box_design_id column
// ALTER TABLE `carts` ADD `box_design_id` BIGINT UNSIGNED NULL;

// -- Add foreign key constraint
// ALTER TABLE `carts` ADD CONSTRAINT `carts_box_design_id_foreign` 
// FOREIGN KEY (`box_design_id`) REFERENCES `box_designs` (`id`);