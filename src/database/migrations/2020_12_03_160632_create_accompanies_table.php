<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAccompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompanies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('user_id')->comment('ユーザーID');
            $table->integer('performance_id')->comment('公演ID');
            $table->string('contents')->comment('募集文');
            $table->softDeletes();
            $table->boolean('exist')->nullable()->generatedAs('case when deleted_at is null then 1 else null end')->comment('論理削除確認 1:未削除 null:削除済');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('performance_id')->references('id')->on('performances');
        });

        DB::statement("COMMENT ON TABLE accompanies IS '同行者募集テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accompanies');
    }
}
