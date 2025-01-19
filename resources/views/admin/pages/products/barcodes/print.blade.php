<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
    <title>طباعة الباركود</title>
    <style>
        /** {*/
        /*    margin: 0;*/
        /*    padding: 0;*/
        /*}*/
        /*.barcode {*/
        /*    width: 3in;*/
        /*    height: 1.5in;*/
        /*    margin: 0; !* Remove margin to avoid extra space *!*/
        /*    text-align: center; !* Center the content *!*/
        /*    box-sizing: border-box; !* Ensure padding and border are included in the dimensions *!*/
        /*}*/
        .barcode {
            height: 1.25in;
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

        }
    </style>
</head>
<body>
@foreach ($barcodes as $barcode)
    <div class="barcode">
        <p>{!! $barcode['barcode_image'] !!}</p>
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

{{--<style>--}}
{{--    @media print{--}}
{{--        @page {--}}
{{--            size: 3in 1.5in;--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}
{{--{{$barcode}}--}}
{{--<script>--}}
{{--    window.print();--}}
{{--</script>--}}

{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Generate Barcodes</title>--}}
{{--    <style>--}}
{{--        .barcode-container {--}}
{{--            text-align: center;--}}
{{--            margin-bottom: 10px;--}}
{{--        }--}}
{{--        .barcode {--}}
{{--            transform: scale(0.7);--}}
{{--            transform-origin: center;--}}
{{--        }--}}
{{--        .barcode-text {--}}
{{--            font-size: 10px;--}}
{{--            margin-top: 3px;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<form id="barcodeForm">--}}
{{--    <label for="barcodeAmount">Enter Number of Barcodes:</label>--}}
{{--    <input type="number" id="barcodeAmount" name="barcodeAmount" min="1" required>--}}
{{--    <button type="button" id="generateButton">Generate</button>--}}
{{--    <button type="button" id="printButton">Print</button>--}}
{{--</form>--}}

{{--<div id="barcodes"></div>--}}

{{--<script>--}}
{{--    const generateButton = document.getElementById('generateButton');--}}
{{--    const printButton = document.getElementById('printButton');--}}
{{--    const barcodeContainer = document.getElementById('barcodes');--}}

{{--    generateButton.addEventListener('click', () => {--}}
{{--        const amount = document.getElementById('barcodeAmount').value;--}}
{{--        barcodeContainer.innerHTML = ''; // Clear existing barcodes--}}
{{--        for (let i = 0; i < amount; i++) {--}}
{{--            barcodeContainer.innerHTML += `--}}
{{--                    <div class="barcode-container">--}}
{{--                        <div class="barcode">--}}
{{--                            <!-- Replace with dynamic barcode generation -->--}}
{{--                            {!! $barcodeHtml !!}--}}
{{--            </div>--}}
{{--            <p class="barcode-text">123456789</p>--}}
{{--        </div>`;--}}
{{--        }--}}
{{--    });--}}

{{--    printButton.addEventListener('click', () => {--}}
{{--        window.print();--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
