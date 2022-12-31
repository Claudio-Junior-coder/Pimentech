<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budgets;
use App\Models\Products;
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
        $products = Products::where('draft', 0)->count();
        $providers = ProviderInfo::where('draft', 0)->count();
        $budgets = Budgets::count();
        $users = User::count();

        return view('home', compact('products', 'providers', 'budgets', 'users'));
    }
}
