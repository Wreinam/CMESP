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
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->json("cardiaco");
            $table->json("alergia");
            $table->json("osseo");
            $table->string("doenca")->nullable();
            $table->string("tratamento")->nullable();
            $table->string("medicamento")->nullable();
            $table->enum('fumante', ['Sim', 'Não'])->default('Não');
            $table->enum('diabetico', ['Sim', 'Não'])->default('Não');
            $table->enum('insulina', ['Sim', 'Não'])->default('Não');
            $table->enum('pressao', ['Normal', 'Alta', 'Baixa'])->default('Normal');
            $table->enum('nadar', ['Sim', 'Não'])->default('Sim');
            $table->foreignId("aluno_id")->constrained("users");
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
        Schema::dropIfExists('anamneses');
    }
};
