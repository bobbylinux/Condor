<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrello extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('carrello', function(Blueprint $table) {
            $table->increments('id'); //chiave primaria
            $table->integer('utente'); //id dell'utente
            $table->foreign('utente')->references('id')->on('utenti');//chiave esterna per utenti
            $table->integer('prodotto'); //id del prodotto (listini_detail)
            $table->foreign('prodotto')->references('id')->on('listini_detail');//chiave esterna per utenti
            $table->integer('quantita')->default(1); //quantità del prodotto inserito
            $table->boolean('cancellato')->default(false); //flag di cancellazione: true = cancellato, false = non cancellato, default = false
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
    public function down() {
        Schema::table('carrello', function(Blueprint $table) {
            //
        });
    }

}
