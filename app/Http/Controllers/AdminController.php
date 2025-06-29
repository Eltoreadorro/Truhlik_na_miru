<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::where('status', 'new')->count(),
            'categories' => Category::count(),
            'revenue' => Order::where('status', 'completed')->sum('total')
        ];

        $recentOrders = Order::with(['items.variant.product'])
                            ->latest()
                            ->take(5)
                            ->get();

        $recentProducts = Product::with('category')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentProducts'));
    }
}
