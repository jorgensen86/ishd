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
        Schema::create('imaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->nullable()->references('id')->on('queues');
            $table->string('host');
            $table->string('username');
            $table->string('password');
            $table->unsignedSmallInteger('port');
            $table->char('encryption', 8);
            $table->boolean('validate_cert')->default(0);
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('imaps');
    }
};
