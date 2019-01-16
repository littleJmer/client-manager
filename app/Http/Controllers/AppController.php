<?php

namespace App\Http\Controllers;

use App\Client;

use Illuminate\Http\Request;

class AppController extends Controller
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
    public function dashboard()
    {
        return view('app.dashboard');
    }

    public function client_create()
    {
        return view('app.client');
    }

    public function client_edit($id)
    {
        return view('app.client', [ 'client' => Client::find($id) ]);
    }

    public function import_csv()
    {
        return view('app.import-csv');
    }
}
