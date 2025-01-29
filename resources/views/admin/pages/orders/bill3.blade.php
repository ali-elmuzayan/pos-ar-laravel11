<html lang="ar" dir="rtl" style="direction: rtl">
<head>
    <title>فاتورة شراء</title>
    <meta charset="utf-8">

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'amiri', sans-serif;
            font-size: 12px;
            text-align: center;
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0; /* Ensure no default margin */
            padding: 0; /* Ensure no default padding */
        }
        /*.bill {*/
        /*    width: 80mm;*/
        /*    margin: 0 auto;*/
        /*    padding: 0;*/
        /*    text-align: center;*/
        /*}*/
        /*.row {*/
        /*    display: flex;*/
        /*    justify-content: center;*/
        /*}*/
        /*.header, .footer {*/
        /*    text-align: center;*/
        /*}*/
        /*.header {*/
        /*    margin: 0;*/
        /*    padding:0;*/
        /*}*/
        .header h2 {
            font-size: 18px;
        }
        .header p {
            font-size: 14px;
        }
        .order-details p {
            margin: 5px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin : 10px auto 0 auto;
        }
        .items-table th, .items-table td {
            /*border: 1px solid #000;*/
            padding: 5px;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
        }
        .header h1 {
            font-size: 27px;
            font-weight: bolder;
            border-bottom: 2px #000 solid;
            padding-bottom: 20px;
        }

    </style>
</head>
<body>
<h1 style="text-align: center; margin-top:10px; font-size: 25px;">7Star</h1>

<table style="direction: rtl" dir="rtl">
    <tr>
        <td>
            اسم العميل
        </td>
        <td>
            {{$order->customer->name ?? 'بدون'}}
        </td>
    </tr>
</table>

<div class="row">
    <table class="items-table">
        <thead>
        <tr>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الإجمالي</th>
            <th>المنتج</th>
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

</div>

<div class="footer">
    <p>المجموع: {{ number_format($order->total_amount, 2) }}</p>
    <p style=""> {{ $setting->address }}</p>
    <p>تشرفنا بتعاملكم معنا!</p>
</div>
</body>
</html>
