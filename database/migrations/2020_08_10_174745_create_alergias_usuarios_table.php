<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlergiasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alergias_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->bigInteger('id_alergia')->constrained('alergias')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->primary(['id_usuario','id_alergia']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alergias_usuarios');
    }
}
