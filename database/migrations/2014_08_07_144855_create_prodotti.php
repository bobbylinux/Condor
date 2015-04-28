<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdotti extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prodotti', function(Blueprint $table) {
            $table->increments('id'); //chiave primaria
            $table->string('codice', 32)->unique();//codice del prodotto
            $table->string('titolo', 128)->unique(); //titolo del prodotto
            $table->text('descrizione')->nullable(); //descrizione del prodotto dettagliata
            $table->integer('quantita')->nullable(); //quantita del prodotto in magazzino
            $table->boolean('spedizione')->default(true); //flag di spedizione fisica del prodotto: true = cancellato, false = non cancellato, default = false
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
        Schema::drop('prodotti');
    }

}
