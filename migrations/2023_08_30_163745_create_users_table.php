<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 32)->comment('编号');
            $table->string('name', 100)->nullable()->comment('昵称');
            $table->string('phone', 30)->nullable()->unique()->comment('手机号');
            $table->string('password', 40)->nullable()->comment('密码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->tinyInteger('gender',)->default(0)->comment('性别(0未知 1男 2女)');
            $table->smallInteger('age')->nullable()->comment('年龄');
            $table->string('device', 100)->nullable()->comment('设备号');
            $table->string('oaid_idfa', 100)->nullable()->comment('oaid/idfa');
            $table->tinyInteger('client')->nullable()->comment('客户端(1安卓；2ios)');
            $table->string('channel', 50)->nullable()->comment('渠道');
            $table->string('version', 50)->nullable()->comment('版本号');
            $table->string('model', 50)->nullable()->comment('机型');
            $table->tinyInteger('login_type')->default(0)->comment('登录类型(0临时；1手机号；2wechat；3qq；4apple；5weibo；10密码)');
            $table->datetimes();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
