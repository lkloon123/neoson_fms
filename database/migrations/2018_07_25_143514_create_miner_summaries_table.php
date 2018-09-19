<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinerSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miner_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('algo');
            $table->integer('gpu_count');
            $table->string('hashrate');
            $table->integer('accepted_hash');
            $table->integer('rejected_hash');
            $table->integer('up_time');
            $table->unsignedInteger('miner_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('miner_id')->references('id')->on('miners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miner_summaries');
    }
}
