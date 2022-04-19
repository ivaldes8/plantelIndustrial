<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadorProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicador_productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('value')->required();
            $table->date('date')->required();
            $table->string('unidad')->required();
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
        Schema::dropIfExists('indicador_productos');
    }
}
