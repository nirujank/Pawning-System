<?php

namespace App\Http\Controllers;

use App\Models\Carratage;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        $carratage = Carratage::all();
        return view('invoice.invoice',compact('carratage'));
    }
}
