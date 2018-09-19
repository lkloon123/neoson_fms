<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticker');
            $table->string('algo');
            $table->integer('port');
            $table->integer('height')->nullable()->default(null);
            $table->integer('workers')->nullable()->default(null);
            $table->string('hashrate')->nullable()->default(null);
            $table->string('estimate')->nullable()->default(null);
            $table->integer('lastblock')->nullable()->default(null);
            $table->integer('timesincelast')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_datas');
    }
}
