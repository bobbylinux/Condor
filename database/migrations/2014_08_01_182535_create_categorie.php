<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorie extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categorie', function(Blueprint $table) {
                    $table->increments('id'); //chiave primaria
                    $table->string('nome', 255); //nome della categoria
                    $table->text('descrizione')->nullable(); //descrizione testuale opzionale della categoria
                    $table->integer('padre')->unsigned()->nullable(); //id numerico del padre
                    $table->boolean('cancellato')->default(false); //flag di cancellazione: true = cancellato, false = non cancellato, default = false
                    $table->timestamp('data_creazione')->default(DB::raw('CURRENT_TIMESTAMP')); //data creazione default sysdate
                    $table->timestamp('data_modifica')->default(DB::raw('CURRENT_TIMESTAMP')); //data modifica default sysdate
                    $table->timestamp('data_cancellazione')->nullable();//data cancellazione 
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categorie');
	}

}
