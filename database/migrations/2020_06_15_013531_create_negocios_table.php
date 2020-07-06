<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nombre',100);
            $table->string('img',100)->nullable();
            $table->string('descripcion',300)->nullable();
            $table->decimal('latitud',10,8)->nullable();
            $table->decimal('longitud',11,8)->nullable();
            $table->string('pais',100);
            $table->string('ciudad',100);
            $table->string('correo',150)->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->string('whatsapp',100)->nullable();

            $table->float('valoracion_1')->nullable();
            $table->float('valoracion_2')->nullable();
            $table->float('valoracion_3')->nullable();
            $table->float('valoracion_4')->nullable();
            $table->float('valoracion_5')->nullable();
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
        Schema::dropIfExists('negocios');
    }
}
