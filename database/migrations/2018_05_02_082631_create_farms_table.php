<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('farm_name');
            $table->boolean('available')->default(true);
            $table->unsignedInteger('pool_id')->nullable()->default(null);
            $table->unsignedInteger('coin_id')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('pool_id')->references('id')->on('pools')->onDelete('cascade');
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farms');
    }
}
