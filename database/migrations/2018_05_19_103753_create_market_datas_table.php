<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticker');
            $table->decimal('price', 16, 8);
            $table->decimal('volume', 16, 8);
            $table->decimal('ask', 16, 8)->nullable()->default(null);
            $table->decimal('bid', 16, 8)->nullable()->default(null);
            $table->unsignedInteger('market_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_datas');
    }
}
