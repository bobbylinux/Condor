<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatiOrdine extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('stati_ordine', function(Blueprint $table) {
            $table->increments('id');
            $table->string('stato',25);
            $table->boolean('cancellato')->default(false);
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
        Schema::drop('stati_ordine');
    }

}
