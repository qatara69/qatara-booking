<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable();
			$table->string('status')->nullable();
			$table->string('ip_address')->nullable();
			$table->string('device')->nullable();
			$table->string('platform')->nullable();
			$table->string('browser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_info');
    }
}
