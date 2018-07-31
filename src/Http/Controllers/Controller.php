<?php

namespace Multidots\Admin\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * Current active menu of side bar
     *
     * @var string
     */
    public $activeSidebarMenu = "";

    /**
     * Current active sub-menu of side bar
     *
     * @var string
     */
    public $activeSidebarSubMenu = "";

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setupNavigation();
    }

    /**
     * Sets navigation data for sidebar
     *
     * @return void
     */
    protected function setupNavigation()
    {
        View::share('activeSidebarMenu', $this->activeSidebarMenu);
        View::share('activeSidebarSubMenu', $this->activeSidebarSubMenu);
    }

    /**
     * get current page number for pagination
     * @param  int  $page
     * @return void
     */
    public function getCurrentPageNo($page)
    {

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
    }
}
