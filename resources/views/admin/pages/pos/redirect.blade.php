<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <script type="text/javascript">
        // Open the PDF in a new tab
        window.open('data:application/pdf;base64,{{ $pdfContent }}', '_blank');

        // Redirect the current tab
        window.location.href = '{{ $redirectUrl }}';
    </script>
</head>
<body>
<p>Redirecting...</p>
</body>
</html>
