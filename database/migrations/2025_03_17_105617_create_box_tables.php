<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxTables extends Migration
{
    public function up()
    {
        Schema::create('box_configurations', function (Blueprint $table) {
            $table->id();
            $table->decimal('breadth', 5, 2);
            $table->decimal('length', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('thickness', 5, 2);
            $table->integer('flute_freq');
            $table->timestamps(); // Already correct
        });

        Schema::create('box_faces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_configuration_id')->constrained()->onDelete('cascade');
            $table->enum('face_name', ['front', 'back', 'left', 'right', 'top', 'bottom']);
            $table->boolean('has_attachment')->default(false);
            $table->timestamps(); // Added timestamps
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_face_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['text', 'image'])->nullable(); // Made nullable to match controller
            $table->text('content')->nullable(); // Made nullable to match controller
            $table->string('font_style', 50)->nullable();
            $table->string('font_size', 10)->nullable();
            $table->decimal('position_x', 5, 2)->default(0); // Added default
            $table->decimal('position_y', 5, 2)->default(0); // Added default
            $table->decimal('position_z', 5, 2)->default(0); // Added default
            $table->decimal('rotation_x', 5, 2)->default(0); // Added default
            $table->decimal('rotation_y', 5, 2)->default(0); // Added default
            $table->decimal('rotation_z', 5, 2)->default(0); // Added default
            $table->timestamps(); // Added timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('box_faces');
        Schema::dropIfExists('box_configurations');
    }
}