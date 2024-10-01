<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();
        $totalStock = Product::sum('stock');

        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'totalStock'));
    }
}
