<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('super-admin')) {
            $totalProducts = Product::count();
            $totalTransactions = Transaction::count();
            $totalShops = Shop::count();
            $totalCustomers = User::role('user')->count();
        } elseif (Auth::user()->hasRole('seller')) {
            $shop = Shop::where('user_id', Auth::user()->id)->first();
            if ($shop) {
                $totalProducts = Product::where('shop_id', $shop->id)->count();
                $totalTransactions = Transaction::where('shop_id', $shop->id)->count();
            } else {
                $totalProducts = 0;
                $totalTransactions = 0;
            }
            $totalShops = false;
            $totalCustomers = false;
        }

        // dd($totalProducts);
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalTransactions' => $totalTransactions,
            'totalShops' => $totalShops,
            'totalCustomers' => $totalCustomers
        ]);
    }
}
