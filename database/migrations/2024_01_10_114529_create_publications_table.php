<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            // ID para la tabla de la BDD
            $table->id();

            // columnas para la tabla de la BDD
            $table->string('Titulo');
            $table->string('Descripcion');
            $table->string('Beneficios');
            $table->string('Procedimiento');
            $table->boolean('state')->default(true);
            //$table->boolean('state')->default(true);

            // Relación
            $table->unsignedBigInteger('user_id');
            // Un usuario puede realizar muchos publicaciones y una publicacion le pertenece a un usuario
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            // columnas especiales para la tabla de la BDD
            $table->timestamps();
            $table->decimal('average', 5, 2)->nullable();
            
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
