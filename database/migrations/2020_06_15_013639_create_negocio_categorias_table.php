<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegocioCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocio_categorias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreignId('id_negocio')->constrained('negocios')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('id_categoria')->constrained('categorias')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('negocio_categorias');
    }
}
