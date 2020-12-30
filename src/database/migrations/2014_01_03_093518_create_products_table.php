<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('organizer_id')->comment('主催団体ID');
            $table->integer('category_id')->comment('カテゴリーID');
            $table->string('name')->comment('作品名');
            $table->string('kana_name')->comment('作品名読み');
            $table->string('phrase')->nullable()->comment('作品フレーズ');
            $table->string('website')->nullable()->comment('作品WEBページ');
            $table->string('image_name')->default('/storage/product_img/no_image.png')->comment('作品画像');
            $table->integer('limitTime')->nullable()->comment('制限時間');
            $table->integer('requiredTime')->nullable()->comment('所要時間');
            $table->integer('minParty')->nullable()->comment('最小人数');
            $table->integer('maxParty')->nullable()->comment('最大人数');
            $table->timestamps();
            $table->foreign('organizer_id')->references('id')->on('organizers');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        // DB::statement("COMMENT ON TABLE products IS '作品テーブル';");
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
