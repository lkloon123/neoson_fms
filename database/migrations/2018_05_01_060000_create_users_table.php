<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('secret_2fa')->nullable()->default(null);
            $table->integer('timestamp_2fa')->nullable()->default(null);
            $table->string('temp_2fa')->nullable()->default(null);
            $table->rememberToken();
            $table->unsignedInteger('bot_id')->nullable()->default(null);
            $table->boolean('available')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('bot_id')->references('id')->on('bots')->onDelete('cascade');
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
