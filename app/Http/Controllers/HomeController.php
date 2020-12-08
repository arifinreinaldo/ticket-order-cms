<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $accesses = DB::table('menu_role as mr')
            ->select('mr.menu_id', 'mr.read_access', 'm.menu', 'm.alias')
            ->join('menu as m', 'mr.menu_id', 'm.id')
            ->where('user_role_id', '=', Auth::user()->role)
            ->get();
        session(['menu' => $accesses]);
        return view('home');
    }

    public function noauth()
    {
        return view('noauth');
    }
}
