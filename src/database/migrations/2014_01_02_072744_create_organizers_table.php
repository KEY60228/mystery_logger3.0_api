<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->string('service_name')->comment('サービス名');
            $table->string('kana_service_name')->comment('サービス名読み');
            $table->string('company_name')->nullable()->comment('団体・企業名');
            $table->string('kana_company_name')->nullable()->comment('団体・企業名読み');
            $table->string('website')->nullable()->comment('サイトURL');
            $table->string('image_name')->default('/storage/organizer_img/noimage.png')->comment('団体イメージ画像');
            $table->string('zipcode')->nullable()->comment('本拠地郵便番号');
            $table->string('addr_prefecture')->nullable()->comment('本拠地都道府県');
            $table->string('addr_city')->nullable()->comment('本拠地市区町村');
            $table->string('addr_block')->nullable()->comment('本拠地町域以下');
            $table->string('addr_building')->nullable()->comment('本拠地建屋以下');
            $table->string('tel')->nullable()->comment('代表電話番号');
            $table->string('mail')->nullable()->comment('代表メールアドレス');
            $table->timestamps();
        });

        // DB::statement("COMMENT ON TABLE organizers IS '主催団体・企業テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizers');
    }
}
