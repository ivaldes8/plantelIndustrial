<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->required();
            $table->string('codREU')->required();
            $table->string('dpa')->required();
            $table->unsignedBigInteger('org_id')->unsigned()->nullable();
            $table->foreign('org_id')->references('id')->on('organismos')->nullOnDelete();
            $table->unsignedBigInteger('osde_id')->unsigned()->nullable();
            $table->foreign('osde_id')->references('id')->on('osdes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidads');
    }
}
