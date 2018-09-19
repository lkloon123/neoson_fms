<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 16, 8);
            $table->decimal('fee', 16, 8)->nullable()->default(null);
            $table->string('withdraw_address');
            $table->text('txid')->nullable()->default(null);
            $table->text('miner_ids');
            $table->string('status')->default('pending email');
            $table->ipAddress('ip');
            $table->text('errMsg')->nullable()->default(null);
            $table->unsignedInteger('coin_id');
            $table->unsignedInteger('farm_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraw_histories');
    }
}
