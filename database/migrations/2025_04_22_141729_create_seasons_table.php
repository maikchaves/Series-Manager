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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('number');


            //uma linha cria o series_id e a outra relaciona com a tabela series. 
            //Isso pode ser feito com apenas uma linha. Laravel reconhece a tabela pelo nome do campo
            //$table->unsignedBigInteger('series_id');
            //$table->foreign('series_id')->references('id')->on('series');
            $table->foreignId('series_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('seasons');
    }
};
