<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        $pdf = new TCPDF('P', 'mm', 'A6', true, 'UTF-8', false);

        // Remove default header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set document metadata
        $pdf->SetCreator('7star');
        $pdf->SetTitle('فاتورة شراء');

        // Set margins
//        $pdf->SetMargins(, 2, 2);
        $pdf->SetMargins(5, 5, 5); // Adjust these values as needed (left, top, right)

        // Set font for Arabic support
        $pdf->SetFont('amiri', '', 12); // Use DejaVu Sans for Arabic text
//        $pdf->SetFont('dejavusans', '', 10); // Use DejaVu Sans for Arabic text

        // Add a page
        $pdf->AddPage();

        // Generate the HTML for the bill
        $html = view('admin.pages.orders.bill2', compact('order'))->render();

        // Write HTML to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Add JavaScript for auto-printing
        $js = 'print();';
        $pdf->IncludeJS($js);

        // Output the PDF (stream to browser)
        $pdf->Output('order_bill.pdf', 'I'); // 'I' streams it to the browser
    }


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
