<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budgets;
use App\Models\Products;
use App\Models\Companies;
use App\Models\Customers;
use App\Models\ProviderInfo;
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
        $products = Products::count();
        $providers = ProviderInfo::count();
        $budgets = Budgets::count();
        $users = User::count();
        $customers = Customers::count();
        $companies = Companies::count();

        return view('home', compact('products', 'providers', 'budgets', 'users', 'customers', 'companies'));
    }
}
