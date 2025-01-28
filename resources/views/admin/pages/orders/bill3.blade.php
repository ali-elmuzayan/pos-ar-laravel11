<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة</title>
    <style>
        body {
            font-family: 'amiri', sans-serif;
            margin: 0;
            padding: 10px;
            line-height: 1.6;
            direction: rtl;
            width: 105mm; /* A6 width */
            height: 148mm; /* A6 height */
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
        }
        .payment-info {
            margin-top: 20px;
        }
        .payment-info p {
            margin: 5px 0;
        }
        .thank-you {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>فاتورة</h1>

<div class="invoice-details">
    <p><strong>العميل:</strong></p>
    <p>إيماني أولوي</p>
    <p>+123-456-7890</p>
    <p>63 شارع آيفي، هوكفيل، جورجيا، الولايات المتحدة 31036</p>
    <p><strong>رقم الفاتورة:</strong> 12345</p>
    <p><strong>التاريخ:</strong> 16 يونيو 2025</p>
</div>

<table>
    <thead>
    <tr>
        <th>الصنف</th>
        <th>الكمية</th>
        <th>سعر الوحدة</th>
        <th>الإجمالي</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>بلوزة بيضاء</td>
        <td>1</td>
        <td>$123</td>
        <td>$123</td>
    </tr>
    <tr>
        <td>قميص كوبي</td>
        <td>2</td>
        <td>$127</td>
        <td>$254</td>
    </tr>
    <tr>
        <td>فستان قطني مزهر</td>
        <td>1</td>
        <td>$123</td>
        <td>$123</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="total">المجموع الفرعي</td>
        <td class="total">$500</td>
    </tr>
    <tr>
        <td colspan="3" class="total">الضريبة (0%)</td>
        <td class="total">$0</td>
    </tr>
    </tfoot>
</table>

<div class="thank-you">شكرًا لكم!</div>

<div class="payment-info">
    <p><strong>معلومات الدفع:</strong></p>
    <p>بنك بريارد</p>
    <p>اسم الحساب: سميرة حديد</p>
    <p>رقم الحساب: 123-456-7890</p>
    <p>تاريخ الاستحقاق: 5 يوليو 2025</p>
    <p>سميرة حديد</p>
    <p>123 أي شارع، أي مدينة، الولاية 12345</p>
</div>
</body>
</html>
