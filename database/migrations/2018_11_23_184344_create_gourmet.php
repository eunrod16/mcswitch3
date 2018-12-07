<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGourmet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('gourmet', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nombre');
          $table->string('codigo_producto');
          $table->string('codigo_localizacion');
          $table->string('imagen')->nullable();
          $table->boolean('active');
          $table->string('precio_reemplazo')->nullable();;
          $table->foreign('codigo_producto')
          ->references('codigo')->on('producto');
          $table->foreign('codigo_localizacion')
          ->references('codigo')->on('localizacion');
          $table->timestamp('created_at')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
