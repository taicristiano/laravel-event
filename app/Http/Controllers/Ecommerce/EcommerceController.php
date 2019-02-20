<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EcommerceController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ecommerces.index');
    }
}
