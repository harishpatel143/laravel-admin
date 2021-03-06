<?php

namespace Multidots\Admin\Http\Controllers;

use Multidots\Admin\Http\Controllers\Controller;
use Multidots\Admin\Models\Administrator;

class HomeController extends Controller
{

    /**
     * Active side bar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'dashboard';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        config(['app.name' => 'Dashboard']);
//        $users = User::active()->select('id', 'status')->count();
        $totalAdministrator = Administrator::active()->select('id', 'status')->count();

        return view('admin::home', compact('users', 'totalAdministrator'));
    }

}
