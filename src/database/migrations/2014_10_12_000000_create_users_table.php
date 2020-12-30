<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('代理キー');
            $table->integer('pre_register_id')->comment('仮登録ID');
            $table->string('account_id')->unique()->comment('アカウントID');
            $table->string('name')->comment('アカウントネーム');
            $table->string('profile')->nullable()->comment('プロフィール文');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('パスワード');
            $table->string('image_name')->default('/storage/user_img/default.jpeg')->comment('ユーザー画像のパス');
            $table->rememberToken();
            $table->softDeletes();
            $table->boolean('exist')->nullable()->generatedAs('case when deleted_at is null then 1 else null end')->comment('論理削除確認 1:未削除 null:削除済');
            $table->timestamps();
            $table->foreign('pre_register_id')->references('id')->on('pre_registers');
        });

        // DB::statement("COMMENT ON TABLE users IS 'ユーザーテーブル';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
