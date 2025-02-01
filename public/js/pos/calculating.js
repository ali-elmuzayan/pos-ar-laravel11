function calculate() {
    var subtotal = 0;
    var discount = 0;
    var cashDiscount = 0;
    var total = 0;
    var paidAmount = 0;
    var due = 0;

    // Calculate subtotal by summing up (quantity * sale price) for each row
    $('tr').each(function () {
        var $row = $(this);
        var qty = parseFloat($row.find('.qty').val()) || 0; // Get quantity
        var salePrice = parseFloat($row.find('.price_c').val()) || 0; // Get sale price

        // Ensure values are non-negative
        qty = Math.max(0, qty);
        salePrice = Math.max(0, salePrice);

        subtotal += qty * salePrice; // Multiply quantity by sale price
    });

    $('#txtsubtotal_id').val(subtotal.toFixed(2));

    // Get discount percentage and calculate discount amount
    var discountPercentage = parseFloat($('#txtdiscount_p').val()) || 0;
    discountPercentage = Math.max(0, discountPercentage); // Ensure discount is not negative
    discount = (discountPercentage / 100) * subtotal;
    $('#txtdiscount_n').val(discount.toFixed(2));

    // Get cash discount and ensure it does not exceed 20% of subtotal
    cashDiscount = parseFloat($('#cash_discount').val()) || 0;
    cashDiscount = Math.max(0, cashDiscount); // Prevent negative cash discount
    var maxCashDiscount = subtotal * 0.20;

    if (cashDiscount > maxCashDiscount) {
        alert(`الخصم النقدي يجب ألا يتجاوز ${maxCashDiscount.toFixed(2)} (20% من الإجمالي)`);
        cashDiscount = maxCashDiscount;
        $('#cash_discount').val(cashDiscount.toFixed(2));
    }

    // Calculate total after percentage discount and cash discount
    total = subtotal - discount - cashDiscount;
    $('#txttotal').val(total.toFixed(2));

    // Get paid amount and calculate due
    paidAmount = parseFloat($('#txtpaid').val()) || 0;
    paidAmount = Math.max(0, paidAmount); // Ensure paid amount is not negative
    due = total - paidAmount;
    $('#txtdue').val(due.toFixed(2));
}

// Attach event listeners to update calculation when relevant inputs change
$(document).on('input', '.qty, .saleprice, #txtdiscount_p, #cash_discount, #txtpaid', function () {
    calculate();
});

// Run calculation once on page load in case values are pre-filled
$(document).ready(function () {
    calculate();
});


// function calculate() {
//     var subtotal = 0;
//     var discount = 0;
//     var cashDiscount = 0;
//     var total = 0;
//     var paidAmount = 0;
//     var due = 0;
//
//
//     // Calculate subtotal by summing up all .saleprice inputs
//     $('.saleprice').each(function () {
//         var price = parseFloat($(this).val()) || 0; // Ensure it's a number, default to 0 if invalid
//         subtotal += price;
//     });
//     $('#txtsubtotal_id').val(subtotal.toFixed(2));
//
//     // Get discount percentage and calculate discount amount
//     var discountPercentage = parseFloat($('#txtdiscount_p').val()) || 0; // Ensure it's a number, default to 0 if invalid
//     discount = (discountPercentage / 100) * subtotal;
//     $('#txtdiscount_n').val(discount.toFixed(2));
//
//     // Get cash discount and ensure it does not exceed 20% of subtotal
//     cashDiscount = parseFloat($('#cash_discount').val()) || 0; // Ensure it's a number, default to 0 if invalid
//     var maxCashDiscount = subtotal * 0.20; // 20% of subtotal
//
//     if (cashDiscount > maxCashDiscount) {
//         alert(`الخصم النقدي يجب ألا يتجاوز ${maxCashDiscount.toFixed(2)} (20% من الإجمالي)`);
//         cashDiscount = maxCashDiscount; // Reset to max allowed cash discount
//         $('#cash_discount').val(cashDiscount.toFixed(2)); // Update the input field
//     }
//
//     // Calculate total after percentage discount and cash discount
//     total = subtotal - discount - cashDiscount;
//     $('#txttotal').val(total.toFixed(2));
//
//     // Get paid amount and calculate due
//     paidAmount = parseFloat($('#txtpaid').val()) || 0; // Ensure it's a number, default to 0 if invalid
//     due = total - paidAmount;
//     $('#txtdue').val(due.toFixed(2));
// }

document.addEventListener('DOMContentLoaded', function () {
    const cashDiscountInput = document.getElementById('cash_discount');
    const subtotalInput = document.getElementById('txtsubtotal_id');

    // Function to calculate the maximum allowed discount (20% of subtotal)
    function calculateMaxDiscount() {
        const subtotal = parseFloat(subtotalInput.value) || 0;
        return subtotal * 0.20; // 20% of subtotal
    }
    // Function to validate the discount input
    function validateDiscount() {
        const maxDiscount = calculateMaxDiscount();
        const discountValue = parseFloat(cashDiscountInput.value) || 0;

        if (discountValue > maxDiscount) {
            alert(`الخصم يجب ألا يتجاوز ${maxDiscount.toFixed(2)} (20% من الإجمالي)`);
            cashDiscountInput.value = maxDiscount.toFixed(2); // Reset to max allowed discount
        }
    }

    // Attach event listeners
    cashDiscountInput.addEventListener('input', validateDiscount);

    // If subtotal changes dynamically (e.g., when adding products), revalidate discount
    subtotalInput.addEventListener('change', function () {
        validateDiscount();
    });
});



/*
 * ON change the text discount calculate everything
 */
$(document).on('change', '#txtdiscount_p', function() {
    calculate(0,0);
})

$(document).on('change', '#cash_discount', function() {
    calculate(0,0);
})
