<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('algo');
            $table->string('algo_setup_name');
            $table->unsignedInteger('software_id')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('software_id')->references('id')->on('software')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('software_usages');
    }
}
