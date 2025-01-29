<?php

namespace App\Http\Traits;

use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use TCPDF;

trait HandleBill
{
    public function createBill($order) {

        // Initialize TCPDF
//        $pdf = new TCPDF('', 'mm', 'A6', true, 'UTF-8', false);
        $pdf = new TCPDF('', 'mm', array(80, 200), true, 'UTF-8', false); // 80 mm width, 200 mm height (adjust height as needed)


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

        $content = $this->createBillView($order);


// Write HTML content to the PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Add JavaScript for auto-printing
//        $js = 'print(true);';
//        $js = <<<EOD
//    print(true); // Open the print dialog when the PDF is loaded
//    EOD;
        $js = 'window.onload = function() {
        window.print();
    };';

        $pdf->IncludeJS($js);
//        $pdf->IncludeJS($js);

        // Output the PDF (stream to browser)
        $pdf->Output('order_bill.pdf', 'I'); // 'I' streams it to the browser
    }


    public function createBillView($order) {
        // Start building the content
        $content = '';
        $view = view('admin.pages.orders.bill2', compact('order'))->render();
$content .= $view;
//        // Add order information
////        $content .= '<h1 style="text-align: center; margin-top:10px; font-size: 25px;">7Star</h1>';
//        $content .= '<p style="text-align: right;"><span style="font-weight: bolder">رقم الطلب:</span> ' . $order->id . '</p>';
//        $content .= '<p><strong>تاريخ الطلب:</strong> ' . $order->created_at->format('Y-m-d H:i:s') . '</p>';
//        $content .= '<p><strong>العميل:</strong> ' . $order->customer_name . '</p>';
//
//        // Add order details
//        $content .= '<h2>تفاصيل الطلب</h2>';
//        $content .= '<table cellpadding="5" style="text-align: center; border-collapse:collapse;">';
//        $content .= '<tr>
//                        <th>المجموع</th>
//                        <th>السعر</th>
//                        <th>الكمية</th>
//                        <th >المنتج</th>
//                        </tr>';
//
//        foreach ($order->orderDetails as $detail) {
//            $content .= '<tr>';
//            $content .= '<td>' . $detail->product_name . '</td>';
//            $content .= '<td>' . $detail->quantity . '</td>';
//            $content .= '<td>' . $detail->price . '</td>';
//            $content .= '<td>' . ($detail->quantity * $detail->price) . '</td>';
//            $content .= '</tr>';
//        }
//
//        $content .= '</table>';
//
//        // Add total amount
//        $content .= '<p><strong>المجموع الكلي:</strong> ' . $order->total_amount . '</p>';

        return $content;

    }
}
