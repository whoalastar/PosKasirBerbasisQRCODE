<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OrderRequest;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function scanTable($tableNumber)
    {
        $table = Table::where('table_number', $tableNumber)->firstOrFail();
        
        if (!$table->is_available) {
            return view('user.table-unavailable', compact('table'));
        }

        $categories = \App\Models\Category::with(['menus' => function($query) {
            $query->where('is_available', true)->where('stock', '>', 0);
        }])->where('is_active', true)->get();

        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('user.menu', compact('table', 'categories', 'paymentMethods'));
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $table = Table::findOrFail($request->table_id);

            // Calculate total amount
            $totalAmount = 0;
            $orderItems = [];

            // Process items - the request now has the correct structure
            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                
                // Double-check availability and stock (already validated in OrderRequest)
                if (!$menu->is_available || $menu->stock < $item['quantity']) {
                    throw new \Exception("Menu {$menu->name} is not available or insufficient stock");
                }

                $itemTotal = $menu->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $menu->price,
                    'total_price' => $itemTotal,
                    'notes' => $item['notes'] ?? null,
                ];
            }

            // Create order with correct status
            $order = Order::create([
                'table_id' => $request->table_id,
                'customer_name' => $request->customer_name,
                'total_amount' => $totalAmount,
                'payment_method_id' => $request->payment_method_id,
                'notes' => $request->notes,
                'status' => 'pending', // Start as pending, will be visible in admin dashboard
                'payment_status' => 'pending',
                'session_id' => session()->getId(),
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Create transaction
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Decrease stock immediately (optional - you might want to do this only when order is confirmed)
            // foreach ($request->items as $item) {
            //     $menu = Menu::find($item['menu_id']);
            //     $menu->decrement('stock', $item['quantity']);
            // }

            DB::commit();

            return redirect()->route('user.order.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        // Only allow access if this is the user's order (by session) or no session restriction
        // You might want to add session-based access control here
        
        $order->load(['table', 'paymentMethod', 'orderItems.menu', 'transaction']);
        return view('user.order-confirmation', compact('order'));
    }

    public function receipt(Order $order)
    {
        $order->load(['table', 'paymentMethod', 'orderItems.menu', 'transaction']);
        return view('user.receipt', compact('order'));
    }

    public function status(Order $order)
    {
        // For real-time status checking via AJAX
        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'updated_at' => $order->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}