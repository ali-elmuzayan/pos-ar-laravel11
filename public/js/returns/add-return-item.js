$(document).ready(function () {
    // Event listener for the remove button
    $(document).on("click", ".btnremove", function () {
        var $row = $(this).closest("tr");
        removeOrDecreaseProduct($row);
    });

    // Event listener for the product search input
    $("#barcodeScanner").on("keypress", function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (e.which === 13) {
                var productCode = $(this).val().trim();
                if (productCode) {
                    var $row = findProductRowByCode(productCode);
                    if ($row.length) {
                        removeOrDecreaseProduct($row);
                    } else {
                        alert("Product not found!");
                    }
                    $(this).val(""); // Clear the input after search
                }
            }
        }
    });

    // Function to find a product row by its barcode
    function findProductRowByCode(productCode) {
        var $row = null;
        $("tr").each(function () {
            var rowProductCode = $(this).find(".barcode").val();
            if (rowProductCode === productCode) {
                $row = $(this);
                return false; // Break the loop
            }
        });
        return $row;
    }

    // Function to remove or decrease the product quantity
    function removeOrDecreaseProduct($row) {
        var $qtyInput = $row.find(".qty");
        var currentQty = parseInt($qtyInput.val(), 10);
        var unitPrice = parseFloat($row.find(".price_c").text());
        var orderDetailsId = $row.find("#order-detail_id").val();

        if (currentQty > 1) {
            // Decrease the quantity by 1
            $qtyInput.val(currentQty - 1);
        } else {
            // Remove the entire row
            $row.remove();
        }

        // Update the returned money
        updateReturnedMoney(unitPrice);

        // Update return details and quantities
        updateReturnInputs(orderDetailsId, 1);
    }

    // Function to update the "المبلغ المسترد" (Returned Money) field
    function updateReturnedMoney(amount) {
        var $returnedMoney = $("#returnedMoney");
        var currentReturnedMoney = parseFloat($returnedMoney.val()) || 0;
        var newReturnedMoney = currentReturnedMoney + amount;
        $returnedMoney.val(newReturnedMoney.toFixed(2)); // Format to 2 decimal places
    }

    // Function to update the return_details and return_quantities inputs
    function updateReturnInputs(orderDetailsId, quantity) {
        var $returnDetailsInput = $("#returnDetailsInput");
        var $returnQuantitiesInput = $("#returnQuantities");

        // Retrieve current values
        var returnDetails = $returnDetailsInput.val() ? JSON.parse($returnDetailsInput.val()) : [];
        var returnQuantities = $returnQuantitiesInput.val() ? JSON.parse($returnQuantitiesInput.val()) : {};

        // Update or add return quantity
        if (returnQuantities[orderDetailsId]) {
            returnQuantities[orderDetailsId] += quantity;
        } else {
            returnQuantities[orderDetailsId] = quantity;
            returnDetails.push(orderDetailsId);
        }

        // Update the hidden inputs
        $returnDetailsInput.val(JSON.stringify(returnDetails));
        $returnQuantitiesInput.val(JSON.stringify(returnQuantities));
    }
});
