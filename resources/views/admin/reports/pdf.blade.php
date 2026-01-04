<!-- resources/views/admin/reports/pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report {{ $dateFrom }} - {{ $dateTo }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Report</h2>
    <p>Period: {{ $dateFrom }} to {{ $dateTo }}</p>
    <p>Total Revenue: ${{ number_format($totalRevenue,2) }}</p>
    <p>Total Orders: {{ $totalOrders }}</p>

    <h3>Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Table</th>
                <th>Payment Method</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->table->name ?? '-' }}</td>
                <td>{{ $order->paymentMethod->name ?? '-' }}</td>
                <td>${{ number_format($order->total,2) }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
