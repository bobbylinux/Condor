<?php
namespace App\Http\Controllers;

use \App\Http\Controllers\Controller as BaseController;

class BackController extends BaseController
{
    public function showDashboard() {
        return view('dashboard');
    }

}
