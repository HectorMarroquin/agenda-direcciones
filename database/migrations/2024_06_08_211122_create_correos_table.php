<?php

// database/migrations/YYYY_MM_DD_HHmmss_create_correos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreosTable extends Migration
{
    public function up()
    {
        Schema::create('correos', function (Blueprint $table) {
            $table->id();
            $table->string('correo');
            $table->foreignId('contacto_id')->constrained('contactos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('correos');
    }
}
