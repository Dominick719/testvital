<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            // ID para la tabla de la BDD
            $table->id();

            // columnas para la tabla de la BDD
            $table->string('path');
            $table->morphs('imageable');

            // columnas especiales para la tabla de la BDD
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
