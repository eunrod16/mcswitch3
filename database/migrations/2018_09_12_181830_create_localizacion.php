<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('localizacion', function (Blueprint $table) {
          $table->increments('id');
          $table->string('codigo');
          $table->string('nombre');
          $table->string('canal');
          $table->string('pantallas');
          $table->string('orientacion');
          $table->unique('codigo');
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
        Schema::dropIfExists('localizacion');
    }
}
