<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalMenus' => Menu::count(),
            'totalTables' => Table::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'todayRevenue' => Order::where('payment_status', 'paid')
                ->whereDate('created_at', today())
                ->sum('total_amount'),
            'recentOrders' => Order::with(['table', 'paymentMethod'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}