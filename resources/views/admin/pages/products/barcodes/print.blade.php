<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
    <title>طباعة الباركود</title>
    <style>
        .barcode {
            /*height: 1.25in;*/
            margin: 0;
             text-align: center;
            box-sizing: border-box;
            }

            /* Ensure the body has no margin or padding */
        body {
            margin: 0;
            padding: 0;
        }

        /* Optional: Add a print-specific style to remove unnecessary elements */
        @media print {
            @page{
            size: 105mm 148mm

            }
            /*@page{*/
            /*    size: 3in 1.5in*/

            /*}*/
        }
    </style>
</head>
<body>
@foreach ($barcodes as $barcode)
    <div class="barcode">
        <p style="font-size: 15px" >{{ $barcode['name'] }}</p>
        <p style="margin-top: -15px">{!! $barcode['barcode_image'] !!}</p>
        <p style="margin-top: -15px">{{ $barcode['price'] }}</p>
    </div>
@endforeach

<script>
    // Automatically print the page when loaded
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
