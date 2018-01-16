<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username', 20)->default('')->unique()->comment('用户名');
            $table->string('avatar', 20)->default('')->comment('头像文件名');
            $table->string('lastloginip', 64)->default('')->comment('上次登录IP');
            $table->unsignedInteger('lastlogintime')->default(0)->comment('上次登录时间');
            $table->unsignedInteger('lastchattime')->default(0)->comment('上次发言时间');
        });
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
