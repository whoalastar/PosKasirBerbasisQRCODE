<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'paymentMethod', 'orderItems.menu']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('table') && $request->table) {
            $query->where('table_id', $request->table);
        }

        // Changed pagination from 15 to 10
        $orders = $query->latest()->paginate(10);
        $tables = \App\Models\Table::all();

        return view('admin.orders.index', compact('orders', 'tables'));
    }

    public function show(Order $order)
    {
        $order->load(['table', 'paymentMethod', 'orderItems.menu', 'transaction']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,unpaid,paid,failed,refunded'
        ]);

        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;

        // Update order status and payment status
        $updateData = ['status' => $request->status];
        
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $order->update($updateData);

        // Handle stock management when order is completed
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            foreach ($order->orderItems as $item) {
                $menu = $item->menu;
                if ($menu->stock >= $item->quantity) {
                    $menu->decrement('stock', $item->quantity);
                } else {
                    // Log warning or handle insufficient stock
                    \Log::warning("Insufficient stock for menu {$menu->name}. Required: {$item->quantity}, Available: {$menu->stock}");
                }
            }
        }

        // Handle transaction status updates
        if ($request->has('payment_status')) {
            $transaction = $order->transaction;
            if ($transaction) {
                $transactionStatus = match($request->payment_status) {
                    'paid' => 'completed',
                    'failed' => 'failed',
                    'refunded' => 'refunded',
                    'pending', 'unpaid' => 'pending',
                    default => 'pending'
                };
                
                $transaction->update(['status' => $transactionStatus]);
            } elseif ($request->payment_status === 'paid') {
                // Create transaction if it doesn't exist and payment is marked as paid
                Transaction::create([
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'status' => 'completed',
                ]);
            }
        }

        // Determine success message
        $messages = [];
        if ($oldStatus !== $request->status) {
            $messages[] = "Order status updated to " . ucfirst($request->status);
        }
        if ($request->has('payment_status') && $oldPaymentStatus !== $request->payment_status) {
            $messages[] = "Payment status updated to " . ucfirst($request->payment_status);
        }

        $successMessage = empty($messages) ? 'Order updated successfully' : implode(' and ', $messages);

        return redirect()->back()->with('success', $successMessage);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,unpaid,paid,failed,refunded'
        ]);

        $updateData = ['status' => $request->status];
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $updatedCount = Order::whereIn('id', $request->order_ids)
            ->update($updateData);

        return redirect()->back()->with('success', "{$updatedCount} orders updated successfully");
    }

    public function getReceiptData(Order $order)
    {
        $order->load(['orderItems.menu', 'table', 'paymentMethod']);
        return response()->json($order);
    }
    
    public function quickActions(Request $request, Order $order)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'mark_paid':
                $order->update(['payment_status' => 'paid']);
                $this->updateTransactionStatus($order, 'completed');
                $message = 'Order marked as paid';
                break;
                
            case 'mark_ready':
                $order->update(['status' => 'ready']);
                $message = 'Order marked as ready';
                break;
                
            case 'complete_order':
                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'paid'
                ]);
                $this->updateTransactionStatus($order, 'completed');
                $this->decreaseStock($order);
                $message = 'Order completed successfully';
                break;
                
            default:
                return redirect()->back()->with('error', 'Invalid action');
        }

        return redirect()->back()->with('success', $message);
    }

    private function updateTransactionStatus(Order $order, $status)
    {
        $transaction = $order->transaction;
        if ($transaction) {
            $transaction->update(['status' => $status]);
        } elseif ($status === 'completed') {
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'status' => 'completed',
            ]);
        }
    }

    private function decreaseStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $menu = $item->menu;
            if ($menu->stock >= $item->quantity) {
                $menu->decrement('stock', $item->quantity);
            }
        }
    }
}