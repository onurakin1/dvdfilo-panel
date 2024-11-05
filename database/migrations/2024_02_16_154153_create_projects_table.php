<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->longText('description')->nullable();
            $table->string('hough_id')->nullable();
            $table->string('canny_id')->nullable();
            $table->string('normal_id')->nullable();
            $table->json('hough_data')->nullable();
            $table->json('canny_data')->nullable();
            $table->json('normal_data')->nullable();
            $table->boolean('hough_status')->default(false);
            $table->boolean('canny_status')->default(false);
            $table->boolean('normal_status')->default(false);
            $table->integer('product_count')->default(rand(2000, 3000));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
