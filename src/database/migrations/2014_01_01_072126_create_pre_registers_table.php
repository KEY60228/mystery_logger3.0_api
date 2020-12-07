<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePreRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_registers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('token')->comment('認証トークン');
            $table->integer('status')->comment('認証ステータス 0:未認証 1:認証済 2:本登録済');
            $table->dateTime('expiration_time')->comment('トークン有効期限');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE pre_registers IS '仮登録テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_registers');
    }
}
