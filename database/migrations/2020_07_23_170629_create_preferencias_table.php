<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferencias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_categoria_alimento')->constrained('categoria_alimentos')->onUpdate('cascade')->onDelete('restrict');
            $table->tinyInteger('valor');
            $table->timestamps();
            $table->primary(['id_usuario','id_categoria_alimento']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preferencias');
    }
}
