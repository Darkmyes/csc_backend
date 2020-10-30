<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstilosVidaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estilos_vida_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_estilo_vida')->constrained('estilos_vida')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->primary(['id_usuario','id_estilo_vida']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estilos_vida_usuarios');
    }
}
