<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImmaginiProdotti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immagini_prodotti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('immagine')->unsigned()->index();
            $table->foreign('immagine')->references('id')->on('immagini')->onDelete('cascade');   
            $table->integer('prodotto')->unsigned()->index();
            $table->foreign('prodotto')->references('id')->on('prodotti')->onDelete('cascade');            $table->boolean('cancellato')->default(false); //flag di cancellazione: true = cancellato, false = non cancellato, default = false
            $table->timestamp('data_creazione')->default(DB::raw('CURRENT_TIMESTAMP')); //data creazione default sysdate
            $table->timestamp('data_modifica')->default(DB::raw('CURRENT_TIMESTAMP')); //data modifica default sysdate
            $table->timestamp('data_cancellazione')->nullable(); //data cancellazione 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('immagini_prodotti');
    }
}
