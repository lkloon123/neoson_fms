<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_controls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('rpc_user');
            $table->text('rpc_password');
            $table->text('rpc_port');
            $table->text('rpc_host');
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
        Schema::dropIfExists('wallet_controls');
    }
}
