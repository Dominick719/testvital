<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Relación
            // Un rol puede tener muchos usuarios y a un usuario le pertenece un rol
            $table->unsignedBigInteger('role_id')->after('id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        // Para que se elimine el campo cuando se haga un rollback de la BDD
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
    }
};
