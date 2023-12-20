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
        Schema::create('responsavel_dados', function (Blueprint $table) {
            $table->id();
            $table->string('grauParentesco');
            $table->string('nomeResponsavel');
            $table->string('cpfResponsavel');
            $table->string('rgResponsavel');
            $table->string('rgFrenteResponsavel')->unique();
            $table->string('rgVersoResponsavel')->unique();
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
        Schema::dropIfExists('responsavel_dados');
    }
};
