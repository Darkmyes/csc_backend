<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedades_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_enfermedad')->constrained('enfermedades')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->primary(['id_usuario','id_enfermedad']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enfermedades_usuarios');
    }
}
