<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('user_id')->comment('ユーザーID');
            $table->integer('product_id')->comment('作品ID');
            $table->boolean('spoil')->comment('ネタバレフラグ true:ネタバレあり false:なし');
            $table->string('contents')->nullable()->comment('レビュー内容');
            $table->integer('result')->comment('参加結果 0:無回答 1:成功 2:失敗');
            $table->float('rating', 2, 1)->comment('評価');
            $table->date('joined_at')->nullable()->comment('参加日');
            $table->softDeletes();
            $table->boolean('exist')->nullable()->generatedAs('case when deleted_at is null then 1 else null end')->comment('論理削除確認 1:未削除 null:削除済');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unique(['user_id', 'product_id', 'exist'], 'unique_user_id_product_id_on_reviews');
        });

        // DB::statement("COMMENT ON TABLE reviews IS 'レビューテーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
