<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdiniDetail extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ordini_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ordine'); //listino master
            $table->foreign('ordine')->references('id')->on('ordini_master');//chiave esterna per listini_master            
            $table->integer('prodotto'); //prodotto
            $table->foreign('prodotto')->references('id')->on('listini_detail');//chiave esterna per prodotti            
            $table->double('prezzo',10,2)->default(0); //prezzo del prodotto
            $table->integer('sconto')->default(0); //percentuale sconto
            $table->integer('quantita')->default(1); //quantità richiesta
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
        Schema::drop('ordini_detail');
    }

}
