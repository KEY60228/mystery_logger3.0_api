<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReviewLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_likes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('user_id')->comment('ユーザーID');
            $table->integer('review_id')->comment('レビューID');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->unique(['user_id', 'review_id'], 'unique_review_likes');
        });

        // DB::statement("COMMENT ON TABLE review_likes IS 'レビューに対するLIKEテーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_likes');
    }
}
