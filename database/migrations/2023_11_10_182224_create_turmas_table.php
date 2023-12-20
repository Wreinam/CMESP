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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_vagas');
            $table->string('nivel');
            $table->json('dias_semana');
            $table->string('horario');
            $table->integer('idade_minima');
            $table->integer('idade_maxima');
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->foreignId("endereco_id")->constrained("enderecos");
            $table->foreignId("professor_id")->constrained("users");
            $table->foreignId("modalidade_id")->constrained("modalidades");
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
        Schema::dropIfExists('turmas');
    }
};
