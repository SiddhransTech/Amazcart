<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxDesignsTable extends Migration
{
    public function up()
    {
        Schema::create('box_designs', function (Blueprint $table) {
            // Box configuration fields
            $table->id();
            $table->float('breadth');
            $table->float('length');
            $table->float('height');
            $table->float('thickness');
            $table->integer('flute_freq');
            $table->string('model_path')->nullable();
            $table->string('image_path')->nullable();
            
            // Face configuration (using JSON columns to store all faces)
            $table->json('faces')->nullable()->comment('JSON containing all face configurations');
            
            // Alternatively, if you prefer separate columns for each face:
            /*
            $table->json('front_face')->nullable();
            $table->json('back_face')->nullable();
            $table->json('left_face')->nullable();
            $table->json('right_face')->nullable();
            $table->json('top_face')->nullable();
            $table->json('bottom_face')->nullable();
            */
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('box_designs');
    }
}

// Here's the SQL statement to update your existing carts table to add the box_design_id column and its foreign key constraint:

//     -- First add the new column (if it doesn't exist)
//     ALTER TABLE `carts` 
//     ADD COLUMN `box_design_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL AFTER `shipping_method_id`;
    
//     -- Then add the foreign key constraint (only if box_designs table exists)
//     ALTER TABLE `carts` 
//     ADD CONSTRAINT `carts_box_design_id_foreign` 
//     FOREIGN KEY (`box_design_id`) 
//     REFERENCES `box_designs` (`id`) 
//     ON DELETE SET NULL 
//     ON UPDATE CASCADE;
    
//     -- Add index for better performance
//     ALTER TABLE `carts` 
//     ADD INDEX `carts_box_design_id_foreign` (`box_design_id`);