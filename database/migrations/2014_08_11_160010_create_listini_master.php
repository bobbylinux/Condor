<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListiniMaster extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('listini_master', function(Blueprint $table) {
            $table->increments('id'); //primary key
            $table->string('codice',16)->unique(); //codice del listino
            $table->string('nome',255)->unique(); //nome del listino
            $table->timestamp('data_inizio')->default(DB::raw('CURRENT_TIMESTAMP')); //data inizio validità listino default sysdate
            $table->timestamp('data_fine')->nullable(); //data fine validià listino
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
        Schema::drop('listini_master');
    }

}
