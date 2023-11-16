<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Party;
use App\PurchaseMaster;
use App\SaleMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');

        $this->middleware('auth');

        $this->middleware(function($request,$next){
            $this->user = Auth::user(); //here
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalParties = Party::count();
        $todaysCustomers = Customer::whereDate('created_at', Carbon::today())->count();
        $todaysParties = Party::whereDate('created_at', Carbon::today())->count();
        $totalSales = SaleMaster::sum('amount');
        $totalPurchase = PurchaseMaster::sum('amount');
        $todaysSale = SaleMaster::whereDate('created_at', Carbon::today())->sum('amount');
        $todaysPurchase = PurchaseMaster::whereDate('created_at', Carbon::today())->sum('amount');

        return view('home', compact('totalCustomers', 'totalParties','totalParties','todaysCustomers','todaysParties', 'totalSales', 'totalPurchase', 'todaysSale', 'todaysPurchase'));
    }
}
