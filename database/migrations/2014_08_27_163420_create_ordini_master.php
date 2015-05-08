<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdiniMaster extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ordini_master', function(Blueprint $table) {
            $table->increments('id');
            $table->string('codice_ordine',10)->nullable();
            $table->integer('utente');
            $table->foreign('utente')->references('id')->on('utenti');//chiave esterna per utenti
            $table->integer('destinatario');
            $table->foreign('destinatario')->references('id')->on('destinatari');//chiave esterna per destinatario
            $table->double('totale',10,2)->default(0);
            $table->integer('pagamento');
            $table->foreign('pagamento')->references('id')->on('pagamenti');//chiave esterna per metodo pagamento
            $table->boolean('pagato')->default(false); 
            $table->timestamp('data_pagamento')->nullable(); //data pagamento ordine
            $table->integer('spedizione')->nullable();
            $table->foreign('spedizione')->references('id')->on('spedizioni');//chiave esterna per metodo spedizione
            $table->string('codice_tracking',50)->nullable();
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
        Schema::drop('ordini_master');
    }

}
