<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadorEntidadPlanProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicador_entidad_plan_productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('value')->nullable();
            $table->date('date')->nullable();
            $table->double('plan')->nullable();
            $table->string('year')->nullable();
            $table->unsignedBigInteger('unidad_id')->unsigned()->nullable();
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->unsignedBigInteger('entidad_id')->unsigned()->nullable();
            $table->foreign('entidad_id')->references('id')->on('entidads')->onDelete('cascade');
            $table->unsignedBigInteger('indicador_id')->unsigned()->nullable();
            $table->foreign('indicador_id')->references('id')->on('indicadors')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicador_entidad_plan_productos');
    }
}
