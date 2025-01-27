$(function () {
    // Event listener for barcode input change
    $('#txtbarcode_id').on('change', function () {
        fetchProductDetails($(this).val(), '#txtbarcode_id');
    });

    // Event listener for select2 change
    $('.select2').on('change', function () {
        fetchProductDetails($(this).val(), '.select2');
    });

    // Event delegation for quantity input changes
    $("#itemtable").delegate('.qty', 'keyup change', function () {
        updateQuantity($(this));
    });

    // Event listener for paid amount input change
    $('#txtpaid').on('input', function () {
        calculateDueAmount();
    });
});

// Function to calculate the due amount
function calculateDueAmount() {
    var total = parseFloat($('#txttotal').val()) || 0; // Get the total amount
    var paidAmount = parseFloat($('#txtpaid').val()) || 0; // Get the paid amount

    var dueAmount = paidAmount - total; // Calculate the due amount
    $('#txtdue').val(dueAmount.toFixed(2)); // Update the due amount field
}

// Function to calculate subtotal, discount, total, and due
function calculateTotals() {
    var subtotal = 0;
    var discountPercentage = parseFloat($('#txtdiscount_p').val()) || 0;
    var paidAmount = parseFloat($('#txtpaid').val()) || 0;

    $('.saleprice').each(function () {
        subtotal += parseFloat($(this).val()) || 0;
    });

    var discount = (discountPercentage / 100) * subtotal;
    var total = subtotal - discount;
    var due = total - paidAmount;

    $('#txtsubtotal_id').val(subtotal.toFixed(2));
    $('#txtdiscount_n').val(discount.toFixed(2));
    $('#txttotal').val(total.toFixed(2));
    $('#txtdue').val(due.toFixed(2));
}
