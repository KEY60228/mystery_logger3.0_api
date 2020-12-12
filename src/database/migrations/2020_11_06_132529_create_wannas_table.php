<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWannasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wannas', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('user_id')->comment('ユーザーID');
            $table->integer('product_id')->comment('作品ID');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unique(['user_id', 'product_id'], 'unique_wannas');
        });

        // DB::statement("COMMENT ON TABLE wannas IS '作品に対する行きたいテーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wannas');
    }
}
