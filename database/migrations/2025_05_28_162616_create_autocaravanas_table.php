<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autocaravanas', function (Blueprint $table) {
            $table->id();
            $table->string('modelo', 100);
            $table->text('descripcion')->nullable();
            $table->integer('plazas');
            $table->decimal('precio_por_dia', 10, 2);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autocaravanas');
    }
};
