<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use mPDF;
use TCPDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Order::latest()->paginate(50);



        return view('admin.pages.orders.index', compact('data'));
    }

    public function generateBill(Order $order)
    {
        // Load order with details
        $order = Order::with('orderDetails')->findOrFail($order->id);

        // Initialize TCPDF
        $pdf = new TCPDF('', 'mm', 'A6', true, 'UTF-8', false);

        // Remove default header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set document metadata
        $pdf->SetCreator('7star');
        $pdf->SetTitle('فاتورة شراء');

        // Set margins
        $pdf->SetMargins(5, 5, 5); // Adjust these values as needed (left, top, right)

        // Set font for Arabic support
        $pdf->SetFont('amiri', '', '11'); // Use a font that supports Arabic text

        // Add a page
        $pdf->AddPage();

        // Start building the content
        $content = '';

        // Add order information
        $content .= '<h1 style="text-align: center; margin-top:10px; font-size: 25px;">7Star</h1>';
        $content .= '<p style="text-align: right;"><span style="font-weight: bolder">رقم الطلب:</span> ' . $order->id . '</p>';
        $content .= '<p><strong>تاريخ الطلب:</strong> ' . $order->created_at->format('Y-m-d H:i:s') . '</p>';
        $content .= '<p><strong>العميل:</strong> ' . $order->customer_name . '</p>';

        // Add order details
        $content .= '<h2>تفاصيل الطلب</h2>';
        $content .= '<table cellpadding="5" style="text-align: center; border-collapse:collapse;">';
        $content .= '<tr>
                        <th>المجموع</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th >المنتج</th>
                        </tr>';

        foreach ($order->orderDetails as $detail) {
            $content .= '<tr>';
            $content .= '<td>' . $detail->product_name . '</td>';
            $content .= '<td>' . $detail->quantity . '</td>';
            $content .= '<td>' . $detail->price . '</td>';
            $content .= '<td>' . ($detail->quantity * $detail->price) . '</td>';
            $content .= '</tr>';
        }

        $content .= '</table>';

        // Add total amount
        $content .= '<p><strong>المجموع الكلي:</strong> ' . $order->total_amount . '</p>';

        // Write HTML content to the PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Add JavaScript for auto-printing
        $js = 'print();';
        $pdf->IncludeJS($js);

        // Output the PDF (stream to browser)
        $pdf->Output('order_bill.pdf', 'I'); // 'I' streams it to the browser
    }

//    public function generateBill(Order $order)
//    {
//        // Load order with details
//        $order = Order::with('orderDetails')->findOrFail($order->id);
//
//        // Initialize TCPDF
//        $pdf = new TCPDF('', 'mm', 'A6', true, 'UTF-8', false);
//
//        // Remove default header and footer
//        $pdf->setPrintHeader(false);
//        $pdf->setPrintFooter(false);
//
//        // Set document metadata
//        $pdf->SetCreator('7star');
//        $pdf->SetTitle('فاتورة شراء');
//
//        // Set margins
////        $pdf->SetMargins(, 2, 2);
//        $pdf->SetMargins(5, 5, 5); // Adjust these values as needed (left, top, right)
//
//        // Set font for Arabic support
//        $pdf->SetFont('amiri', '', '11'); // Use DejaVu Sans for Arabic text
////        $pdf->SetFont('dejavusans', '', 10); // Use DejaVu Sans for Arabic text
//
//        // Add a page
//        $pdf->AddPage();
//
//        // Generate the HTML for the bill
//        $html = view('admin.pages.orders.bill3', compact('order'))->rnder();
//
//        // Write HTML to the PDF
//        $pdf->writeHTML($html, true, false, true, false, '');
//
//        // Add JavaScript for auto-printing
//        $js = 'print();';
//        $pdf->IncludeJS($js);
//
//        // Output the PDF (stream to browser)
//        $pdf->Output('order_bill.pdf', 'I'); // 'I' streams it to the browser
//    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
