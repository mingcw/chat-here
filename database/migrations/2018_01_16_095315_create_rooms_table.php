<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->default('')->comment('房间名');
            $table->string('description', 140)->nullable()->default('')->comment('房间描述');
            $table->unsignedInteger('capacity')->default(0)->comment('房间容量');
            $table->unsignedInteger('number')->default(0)->comment('当前人数');
            $table->string('username', 140)->default('')->comment('房主名');
        });
    }               

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
