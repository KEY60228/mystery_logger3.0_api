<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('organizer_id')->comment('主催団体ID');
            $table->string('name')->comment('会場名');
            $table->string('kana_name')->comment('会場名読み');
            $table->string('zipcode')->nullable()->comment('郵便番号');
            $table->string('addr_prefecture')->nullable()->comment('都道府県');
            $table->string('addr_city')->nullable()->comment('市区町村');
            $table->string('addr_block')->nullable()->comment('町域以下');
            $table->string('addr_building')->nullable()->comment('建屋以下');
            $table->string('lat')->nullable()->comment('緯度');
            $table->string('long')->nullable()->comment('経度');
            $table->string('tel')->nullable()->comment('電話番号');
            $table->timestamps();
            $table->foreign('organizer_id')->references('id')->on('organizers');
        });

        DB::statement("COMMENT ON TABLE venues IS '会場テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}
