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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users', 'user_id');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices', 'invoice_id');
            $table->unsignedInteger('invoice_number');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('is_opened')->default(0);
            $table->boolean('is_locked')->default(0);
            $table->boolean('is_closed')->default(0);
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
        Schema::dropIfExists('tickets');
    }
};
