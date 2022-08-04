<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsabilidads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id');
            $table->string('tarea');
            $table->string('descripcion',2048);
            $table->string('periocidad')->default('');
            $table->string('status')->default('pendiente');
            $table->string('documento')->default('');
            $table->dateTime('fecha_de_expiracion')->nullable();
            //$table->bigInteger('padre')->default(0);
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
        Schema::dropIfExists('responsabilidads');
    }
};
