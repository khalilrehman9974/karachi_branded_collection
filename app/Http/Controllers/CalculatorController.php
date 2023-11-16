<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function __construct(){

    }

    public function index(){
//        $shipmentTypes =
        return view('calculator.index');
    }
}
