<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosComponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_componentes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_producto')->constrained('producto')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_componente')->constrained('componentes')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('productos_componentes');
    }
}
