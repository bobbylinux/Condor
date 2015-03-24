<?php

use Illuminate\Database\Seeder;

class ConfigurazioneTableSeeder extends Seeder {

    public function run() {
        DB::table('configurazione')->delete();
        
        DB::table('configurazione')->insert(array(
            'titolo' => 'Condor',
            'logo' => '',
            'sfondo' => '#000000',
            'lingua' => 'it',
        ));
        
        
    }

}
