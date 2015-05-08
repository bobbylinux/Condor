<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdiniStato extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ordini_stato', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ordine');            
            $table->foreign('ordine')->references('id')->on('ordini_master');//chiave esterna per ordini
            $table->integer('stato');            
            $table->text('note')->nullable(); //descrizione del prodotto dettagliata
            $table->foreign('stato')->references('id')->on('stati_ordine');//chiave esterna per stato ordine
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
        Schema::drop('ordini_stato');
    }

}
