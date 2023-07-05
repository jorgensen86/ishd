<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable()->index();
            $table->unsignedBigInteger('uid')->nullable()->index();
            $table->foreignId('imap_id')->nullable()->references('id')->on('imaps');
            $table->foreignId('queue_id')->nullable()->constrained('queues');
            $table->string('sender');
            $table->string('reply');
            $table->string('cc');
            $table->string('subject');
            $table->longText('body');
            $table->dateTime('sent_at');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
};
