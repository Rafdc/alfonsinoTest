<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $arrayCount['partner'] = DB::table('partner')
                                    ->whereNull('deleted_at')
                                    ->count();

        $arrayCount['prodotti'] = DB::table('prodotti')
                                    ->whereNull('deleted_at')
                                    ->count();

        $arrayCount['ordini'] = DB::table('ordini')
                                    ->whereNull('deleted_at')
                                    ->count();

        return view('home')
                ->withArrayCount($arrayCount);
    }
}
