<?php

class UtenteTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('utenti')->delete();
		Utente::create(array(
			'username' => 'roberto.bani@gmail.com',
			'password'    => Hash::make('password'),
			'ruolo' => '3',
                        'confermato' => true
		));
                Utente::create(array(
			'username' => 'roberto.bani@dedalus.eu',
			'password'    => Hash::make('password'),
			'ruolo' => '2',
                        'confermato' => true
		));
                Utente::create(array(
			'username' => 'bobbylinux@hotmail.it',
			'password'    => Hash::make('password'),
			'ruolo' => '1',
                        'confermato' => true
		));
	}

}