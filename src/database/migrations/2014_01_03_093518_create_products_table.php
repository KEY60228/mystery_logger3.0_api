<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('contents')->nullable();
            $table->string('image_name')->default('no_image.jpeg');
            $table->integer('limitTime')->nullable();
            $table->integer('requiredTime')->nullable();
            $table->integer('minParty')->nullable();
            $table->integer('maxParty')->nullable();
            $table->integer('organizer_id');
            $table->integer('category_id');
            $table->timestamps();
            $table->foreign('organizer_id')->references('id')->on('organizers');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
