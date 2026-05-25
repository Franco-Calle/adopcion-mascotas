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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refugio_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo'); // Perro, Gato, Conejo, etc.
            $table->string('raza')->nullable();
            $table->string('edad'); // 3 meses, 2 años, etc.
            $table->string('tamaño'); // Pequeño, Mediano, Grande
            $table->text('historia');
            $table->enum('estado', ['disponible', 'en_proceso', 'adoptado'])->default('disponible');
            $table->boolean('esterilizado')->default(false);
            $table->boolean('vacunado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
