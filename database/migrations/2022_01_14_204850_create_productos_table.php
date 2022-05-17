<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('desc')->required();
            $table->unsignedBigInteger('cpcu_id')->unsigned()->nullable();
            $table->foreign('cpcu_id')->references('id')->on('cpcus')->nullOnDelete();
            // $table->unsignedBigInteger('saclap_id')->unsigned()->nullable();
            // $table->foreign('saclap_id')->references('id')->on('saclaps')->nullOnDelete();
            $table->unsignedBigInteger('nae_id')->unsigned()->nullable();
            $table->foreign('nae_id')->references('id')->on('naes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
