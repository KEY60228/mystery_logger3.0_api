<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('following_id')->comment('フォローするユーザーID');
            $table->integer('followed_id')->comment('フォローされるユーザーID');
            $table->timestamps();
            $table->foreign('following_id')->references('id')->on('users');
            $table->foreign('followed_id')->references('id')->on('users');
            $table->unique(['following_id', 'followed_id'], 'unique_follows');
        });

        DB::statement("COMMENT ON TABLE follows IS 'フォロー関係テーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
