<?php

class RuoloUtentiTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('ruolo_utenti')->delete();
		RuoloUtente::create(array(
			'ruolo' => 'Utente Standard'			
		));
                RuoloUtente::create(array(
			'ruolo' => 'Utente Amministratore'			
		));
                RuoloUtente::create(array(
			'ruolo' => 'SuperUser'			
		));
	}

}