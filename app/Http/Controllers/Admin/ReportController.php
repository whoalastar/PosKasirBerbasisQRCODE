<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        // Financial summary - hanya menghitung order yang completed DAN paid
        $totalRevenue = Order::where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->sum('total_amount');

        // Total pesanan dalam periode (semua status)
        $totalOrders = Order::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->count();

        // Pesanan yang sudah selesai (completed)
        $completedOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->count();

        // Daily sales - hanya order completed dan paid
        $dailySales = Order::where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling items - hanya dari order yang completed
        $topItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('orders.status', 'completed')
            ->select(
                'menus.name',
                'menus.id', 
                DB::raw('SUM(order_items.quantity) as total_quantity'), 
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('menus.id', 'menus.name')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get();

        // Payment method breakdown - hanya order completed dan paid
        $paymentBreakdown = DB::table('orders')
            ->join('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('orders.status', 'completed')
            ->where('orders.payment_status', 'paid')
            ->select(
                'payment_methods.name',
                'payment_methods.id',
                DB::raw('COUNT(*) as count'), 
                DB::raw('SUM(orders.total_amount) as total')
            )
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->orderBy('total', 'desc')
            ->get();

        // Additional metrics
        $averageOrderValue = $completedOrders > 0 ? $totalRevenue / $completedOrders : 0;
        
        // Completion rate
        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'dailySales',
            'topItems',
            'paymentBreakdown',
            'dateFrom',
            'dateTo',
            'averageOrderValue',
            'completionRate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $data = $this->getReportData($dateFrom, $dateTo);

        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        
        $filename = 'laporan-penjualan-' . $dateFrom . '-to-' . $dateTo . '.pdf';
        
        return $pdf->download($filename);
    }

    public function previewPdf(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $data = $this->getReportData($dateFrom, $dateTo);

        return view('admin.reports.pdf-preview', $data);
    }

    private function getReportData($dateFrom, $dateTo)
    {
        // Total revenue dari order completed dan paid
        $totalRevenue = Order::where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->sum('total_amount');

        // Total orders dalam periode
        $totalOrders = Order::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->count();

        // Completed orders
        $completedOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->count();

        // Orders detail untuk PDF
        $orders = Order::with(['table', 'paymentMethod', 'orderItems.menu'])
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();

        // Top items
        $topItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('orders.status', 'completed')
            ->select(
                'menus.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'), 
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('menus.id', 'menus.name')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get();

        // Payment breakdown
        $paymentBreakdown = DB::table('orders')
            ->join('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('orders.status', 'completed')
            ->where('orders.payment_status', 'paid')
            ->select(
                'payment_methods.name',
                DB::raw('COUNT(*) as count'), 
                DB::raw('SUM(orders.total_amount) as total')
            )
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->orderBy('total', 'desc')
            ->get();

        // Daily sales
        $dailySales = Order::where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'orders' => $orders,
            'topItems' => $topItems,
            'paymentBreakdown' => $paymentBreakdown,
            'dailySales' => $dailySales,
            'averageOrderValue' => $completedOrders > 0 ? $totalRevenue / $completedOrders : 0,
            'completionRate' => $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0,
        ];
    }

    public function getDashboardStats()
    {
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');

        // Stats hari ini
        $todayStats = [
            'revenue' => Order::where('status', 'completed')
                ->where('payment_status', 'paid')
                ->whereDate('created_at', $today)
                ->sum('total_amount'),
            'orders' => Order::whereDate('created_at', $today)->count(),
            'completed' => Order::where('status', 'completed')
                ->whereDate('created_at', $today)
                ->count(),
        ];

        // Stats bulan ini
        $monthStats = [
            'revenue' => Order::where('status', 'completed')
                ->where('payment_status', 'paid')
                ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$thisMonth])
                ->sum('total_amount'),
            'orders' => Order::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$thisMonth])
                ->count(),
            'completed' => Order::where('status', 'completed')
                ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$thisMonth])
                ->count(),
        ];

        return [
            'today' => $todayStats,
            'month' => $monthStats,
        ];
    }
}