<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitor_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wallet_address');
            $table->decimal('coin_balance', 16, 8)->nullable()->default(null);
            $table->boolean('available')->default(true);
            $table->unsignedInteger('coin_id');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('monitor_infos');
    }
}
