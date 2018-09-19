<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsNotifyOnceToNicehashAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nicehash_accounts', function (Blueprint $table) {
            $table->boolean('is_notify_once')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nicehash_accounts', function (Blueprint $table) {
            $table->dropColumn('is_notify_once');
        });
    }
}
