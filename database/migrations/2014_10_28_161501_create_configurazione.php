<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurazione extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('configurazione', function(Blueprint $table) {
            $table->increments('id');
            $table->string('titolo', 255);
            $table->string('logo', 4000)->nullable();
            $table->string('sfondo', 7)->default('#000000');
            $table->string('lingua', 2)->default('it');
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
        Schema::drop('configurazione');
    }

}
