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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_autocaravana')->constrained('autocaravanas')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('pago_realizado')->default(false);
        $table->decimal('porcentaje_pagado', 5, 2)->default(0.00);
            $table->timestamps();
            
            // Índices para mejorar búsquedas por fechas
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
