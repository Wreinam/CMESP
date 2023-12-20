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
        Schema::create('user_informacoes', function (Blueprint $table) {
            $table->id();
            $table->string("nomeMae");
            $table->string("nomePai")->nullable()->default(NULL);
            $table->date("dataNascimento");
            $table->integer("idade");
            $table->string('cpf')->unique();
            $table->string("rg")->unique();
            $table->string("rgFrente");
            $table->string("rgVerso");
            $table->string("telefoneEmergencia");
            $table->string("endereco");
            $table->string("bairro");
            $table->foreignId("user_id")->constrained("users");
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
        Schema::dropIfExists('user_informacoes');
    }
};
