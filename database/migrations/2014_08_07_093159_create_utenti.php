<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtenti extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('utenti', function(Blueprint $table) {
            $table->increments('id'); //chiave primaria
            $table->string('username', 128)->unique(); //nome utente con standard email es: email@email.com
            $table->string('password', 64); //password che verrà crittografata secondo gestione di laravel
            $table->integer('ruolo')->references('id')->on('ruolo_utenti'); //ruolo in relazione con la tabella dei ruoli
            $table->boolean('confermato')->default(false);
            $table->string('codice_conferma')->nullable();
            // required for Laravel 4.1.26
            $table->string('remember_token', 100)->nullable();
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
        Schema::drop('utenti');
    }

}
