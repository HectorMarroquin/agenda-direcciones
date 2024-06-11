<?php

// database/migrations/YYYY_MM_DD_HHmmss_create_direcciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionsTable extends Migration
{
    public function up()
    {
        Schema::create('direccions', function (Blueprint $table) {
            $table->id();
            $table->text('direccion');
            $table->foreignId('contacto_id')->constrained('contactos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('direccions');
    }
}
