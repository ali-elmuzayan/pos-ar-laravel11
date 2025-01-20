<!DOCTYPE html>
<html lang="en">
<head>
    <title>فاتورة شراء</title>
    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .bill {
            width: 80mm; /* Adjust as needed */
            margin: 0 auto;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="bill">
    <div class="header">
        <h2>7star</h2>
        <p>فاتورة شراء</p>
    </div>

    <div class="order-details">
        <p><strong>Order ID:</strong> {{ $order->invoice_no }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
    </div>

    <table class="items-table">
        <thead>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderDetails as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>المجموع:</strong> {{ number_format($order->total_amount, 2) }}</p>
        <p>تشرفنا بتعاملكم معنا!</p>
    </div>
</div>
</body>
</html>

