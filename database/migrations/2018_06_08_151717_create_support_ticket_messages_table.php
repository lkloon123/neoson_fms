<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->unsignedInteger('post_by_user_id');
            $table->unsignedInteger('support_ticket_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_by_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('support_ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_ticket_messages');
    }
}
