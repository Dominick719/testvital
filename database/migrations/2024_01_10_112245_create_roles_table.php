<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            
            // ID para la tabla de la BDD
            $table->id();

            // columna para la tabla BDD
            $table->string('name', 50);
            $table->string('slug', 25);
            // columnas especiales para la tabla de la BDD
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
