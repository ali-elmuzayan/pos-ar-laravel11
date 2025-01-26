
<!DOCTYPE html>
<html lang="ar" dir="rtl" style="direction: rtl">
<head>
    <title>فاتورة شراء</title>
    <meta charset="utf-8">

    <style>
        * {
            margin:0;
            padding:0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            text-align: right;
            direction: rtl;
        }
        .bill {
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
        }
        .header {
            margin-top:-20px;
        }
        .items-table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: right;
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
        <p><strong>رقم الفاتورة:</strong> {{ $order->invoice_no }}</p>
        <p><strong>التاريخ:</strong> {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
    </div>

    <table class="items-table">
        <thead>
        <tr>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الإجمالي</th>
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
        <p><strong>العنوان:</strong>{{$setting->address}} </p>
        <p>تشرفنا بتعاملكم معنا!</p>
    </div>
</div>


</body>
</html>

