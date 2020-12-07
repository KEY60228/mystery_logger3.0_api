<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('product_id')->comment('作品ID');
            $table->integer('venue_id')->comment('会場ID');
            $table->integer('active_id')->comment('0:公演終了 1:公演中');
            $table->date('start_date')->nullable()->comment('公演開始日');
            $table->date('end_date')->nullable()->comment('公演終了日');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('venue_id')->references('id')->on('venues');
        });

        // DB::statement("COMMENT ON TABLE performances IS '公演テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
