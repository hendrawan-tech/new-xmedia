<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('external_id');
            $table->string('invoice_url');
            $table->string('price');
            $table->string('image', 80)->nullable();
            $table->enum('status', ['Belum Lunas', 'Proses', 'Lunas']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table
                ->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
