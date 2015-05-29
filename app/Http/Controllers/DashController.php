<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;

class DashController extends BaseController
{
    /**
     * Show the index of the dashboard
     *
     * @param  none
     * @return Illuminate\View\View
     */
    public function showDashboard()
    {
        return view('dashboard');//$this->layout->content = View::make('dashboard');
    }
}
