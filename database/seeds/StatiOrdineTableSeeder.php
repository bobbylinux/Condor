<?php

class StatiOrdineTableSeeder extends Seeder{
    public function run()
	{
		DB::table('stati_ordine')->delete();
		DB::table('stati_ordine')->insert(array(
			'stato' => 'nuovo'
		));
                DB::table('stati_ordine')->insert(array(
			'stato' => 'confermato'
		));
                DB::table('stati_ordine')->insert(array(
			'stato' => 'spedito'
		));                
                DB::table('stati_ordine')->insert(array(
			'stato' => 'consegnato'
		));                
                DB::table('stati_ordine')->insert(array(
			'stato' => 'annullato'
		));
                DB::table('stati_ordine')->insert(array(
			'stato' => 'reso'
		));
                DB::table('stati_ordine')->insert(array(
			'stato' => 'cancellato'
		));
	}
}
