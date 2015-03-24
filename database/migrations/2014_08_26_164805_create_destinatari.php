<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinatari extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('destinatari', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('utente');            
            $table->foreign('utente')->references('id')->on('utenti');//chiave esterna per utenti
            $table->string('cognome',255);
            $table->string('nome',255);
            $table->string('indirizzo',500);
            $table->string('note',255)->nullable();
            $table->string('citta',255);
            $table->string('cap',25);
            $table->string('provincia',16)->nullable();
            $table->string('paese',255);
            $table->string('recapito',255)->nullable();
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
        Schema::drop('destinatari');
    }

}
