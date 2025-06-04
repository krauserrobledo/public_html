<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_reserva')->constrained('reservas')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('metodo_pago', ['Stripe', 'PayPal', 'Square', 'Revolut']);
            $table->timestamp('fecha_pago')->useCurrent();
            $table->decimal('cantidad_pagada', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
