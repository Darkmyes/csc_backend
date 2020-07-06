<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('id_negocio')->constrained('negocios')->onUpdate('cascade')->onDelete('restrict');
            $table->string('usuario_sin_cuenta',60)->nullable();
            $table->bigInteger('id_usuario')->nullable();
            $table->string('comentario',300);
            $table->bigInteger('respuesta_de')->nullable()->constrained('comentarios')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
