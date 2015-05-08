<?php namespace App\Http\Controllers;

use \App\Http\Controllers\Controller as BaseController;

class BackController extends BaseController {

    public $layout = 'template.back';

    public function showDashboard() {
        //$this->layout->content = View::make('dashboard');
        return view('dashboard');
    }

}
