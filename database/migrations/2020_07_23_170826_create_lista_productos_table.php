<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_producto')->constrained('producto')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_bar')->constrained('bar')->onUpdate('cascade')->onDelete('restrict');
            $table->double('precio');
	    $table->string('img', 200)->nullable();
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
        Schema::dropIfExists('lista_productos');
    }
}
