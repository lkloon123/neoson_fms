<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('miner_name');
            $table->boolean('available')->default(true);
            $table->unsignedInteger('current_mining_wallet_id')->nullable()->default(null);
            $table->unsignedInteger('farm_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miners');
    }
}
