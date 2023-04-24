<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Customer;
use App\Models\Interest;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

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
        $articles = count(Article::all());
        $invoices = count(Invoice::all());
        $interest_rate = Interest::orderBy('created_at', 'desc')->first();

        $customers = count(Customer::all());
        return view('home',compact('articles','invoices','customers','interest_rate'));
    }
}
