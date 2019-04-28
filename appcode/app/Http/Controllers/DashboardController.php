<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\DashboardModel;
use App\Models\PlayerModel;
use Library\Utilities;

class DashboardController extends Controller
{
    private $auth, $dashboardModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth, DashboardModel $dashboardModel)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->dashboardModel = $dashboardModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function getDashboardContent()
    {
        return Utilities::sendResponse(json_encode($this->dashboardModel::getDashboardContent()), '200');
    }
}
