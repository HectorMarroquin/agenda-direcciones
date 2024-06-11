<?php

// database/migrations/YYYY_MM_DD_HHmmss_create_telefonos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonosTable extends Migration
{
    public function up()
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); // Cambia el tipo de dato de 'integer' a 'string'
            $table->foreignId('contacto_id')->constrained('contactos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telefonos');
    }
}
