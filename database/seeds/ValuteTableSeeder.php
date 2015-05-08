<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValuteTableSeeder
 *
 * @author roberto
 */
class ValuteTableSeeder extends Seeder {
    
    public function run() {
        DB::table('valute')->delete();
        
        Valuta::create(array(
            'nome' => 'Euro',
            'simbolo' => '€',
            'sigla' => 'EUR'
        ));
        
    }

}
