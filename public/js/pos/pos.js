

var product=[];


$(function() {
    $('#txtbarcode_id').on('change', function() {
        var barcode = $('#txtbarcode_id').val();
        var url = productRoute.replace(':code', barcode);

        $.ajax({
            url: url,
            method: "get",
            dataType: "json",
            data: { id: barcode },
            success: function(data) {
                console.log(data); // Debug: Check the response data

                // Check if the product has stock
                if (data['stock'] <= 0) {
                    swal.fire('Out of Stock!', 'This product is out of stock.', 'warning');
                    return; // Exit the function if there's no stock
                }

                // Check if the product already exists in the array
                if (jQuery.inArray(data['id'], product) !== -1) {
                    // Check if adding one more exceeds the stock
                    var actualQty = parseInt($('#qty_id' + data["id"]).val()) + 1;
                    if (actualQty > data['stock']) {
                        swal.fire('Stock Limit Exceeded!', 'You cannot add more than the available stock.', 'warning');
                        return; // Exit the function if stock limit is exceeded
                    }

                    // Update the quantity and price
                    $('#qty_id' + data["id"]).val(actualQty);
                    var sellingPrice = parseInt(actualQty) * data["selling_price"];
                    $('#saleprice_id' + data["id"]).html(sellingPrice);
                    $('#saleprice_idd' + data["id"]).val(sellingPrice);
                    calculate(0, 0);
                } else {
                    // Add a new row for the product
                    addRow(data['id'], data['name'], data['selling_price'], data['stock'], data['barcode']);
                    product.push(data['id']);
                    calculate(0, 0);
                }

                $('#txtbarcode_id').val("");
                calculate(); // Call calculate() after updating the quantity
            },
            error: function(response) {
                // On error result
                swal.fire('Error!', 'Please enter a valid product.', 'warning');
            }
        });
    });


});


//selected2
$(function() {
    $('.select2').on('change', function() {

        var productId = $('.select2').val();
        var url = productRoute.replace(':code', productId);

        $.ajax({
            url:url,
            method: "get",
            dataType: "json",
            data: {id:productId},
            success:function(data){
                // check if the value exist in the array

                if(jQuery.inArray(data['id'], product) !== -1) {

                    // add one to the quantity in case it is the same product
                    var actualQty = parseInt($('#qty_id'+data["id"]).val())+1;
                    $('#qty_id'+data["id"]).val(actualQty);

                    var sellingPrice=parseInt(actualQty)*data["selling_price"];

                    $('#saleprice_id'+data["id"]).html(sellingPrice);
                    $('#saleprice_idd'+data["id"]).val(sellingPrice);
                    calculate();
                }else {
                    addRow(data['id'], data['name'], data['selling_price'],data['stock'], data['barcode']);
                    product.push(data['id']);
                }

                $('#txtbarcode_id').val("");

            },
            error:function(url) {
                // on error result

            }
        })
    })
})


// function that create the row of the product details in the pos system
function addRow(id,name,selling_price,stock,barcode){

    var tr='<tr class="text-center">'+
        '<input type="hidden" class="form-control barcode" name="barcode_arr[]" id="barcode_id'+barcode+'" value="'+barcode+'" >'+

        '<td style=" vertical-align:middle; font-size:17px;"><span class=" badge product_c" name="product_arr[]">'+name+'</span><input type="hidden" class="form-control pid" name="pid_arr[]" value="'+id+'" ><input type="hidden" class="form-control product" name="product_arr[]" value="'+name+'" >  </td>'+

        '<td style=" vertical-align:middle; font-size:17px;"><span class="badge stocklbl" name="stock_arr[]" id="stock_id'+id+'">'+stock+'</span><input type="hidden" class="form-control stock_c" name="stock_c_arr[]" id="stock_idd'+id+'" value="'+stock+'"></td>'+

        '<td style=" vertical-align:middle; font-size:17px;"><span class="badge price" name="price_arr[]" id="price_id'+id+'">'+selling_price +'</span><input type="hidden" class="form-control price_c" name="price_c_arr[]" id="price_idd'+id+'" value="'+selling_price+'"></td>'+

        '<td><input type="number" class="form-control qty the-quantity" readonly name="quantity_arr[]" id="qty_id'+id+'" value="'+1+'" size="1" min="1" max="'+stock+'"></td>'+

        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge totalAmount" name="netamt_arr[]" id="saleprice_id'+id+'">'+selling_price+'</span><input type="hidden" class="form-control saleprice" name="saleprice_arr[]" id="saleprice_idd'+id+'" value="'+selling_price+'"></td>'+

        '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove" data-id="'+id+'"><span class="fas fa-trash"></span></center></td>'+


        '</tr>';


    $('.details').append(tr);
    // calculate(0,0);
calculate()
}


// quantity calculation
$("#itemtable").delegate('.qty', 'keyup change', function() {

    var quantity = $(this);

    var tr = $(this).parent().parent();

    if((quantity.val()-0) > (tr.find('.stock_c').val()-0)) {
        swal.fire('تحذير!', 'نأسف،ولكن لا يوجد المزيد من هذا المنتج', 'warning');
        quantity.val(tr.find('.stock_c').val()-1);
        tr.find(".totalAmount").text(quantity.val() * tr.find('.price').text());
        tr.find(".saleprice").text(quantity.val() * tr.find('.price').text());
    calculate();
    }else {
        tr.find(".totalAmount").text(quantity.val() * tr.find('.price').text());
        tr.find(".saleprice").text(quantity.val() * tr.find('.price').text());
    calculate();
    }
})





// Remove button
// Declare productarr in the global scope
var productarr = []; // Initialize it as an empty array or with your data
// Event listener for the remove bu
$(document).on('click', '.btnremove', function () {
    var $row = $(this).closest('tr'); // Get the closest table row
    var $qtyInput = $row.find(".qty");
    var currentQty = parseInt($qtyInput.val(), 10);

    if (currentQty > 1) {
        // If quantity is greater than 1, decrement it
        // Decrease the quantity by 1
        $qtyInput.val(currentQty - 1);
        console.log("Decrementing quantity, calling calculate()");
        calculate(0,0)
    } else {
        // If quantity is 1, remove the row
        var removedItem = $(this).attr("data-id");

        // Remove the item from the productarr array
        productarr = jQuery.grep(productarr, function (value) {
            return value != removedItem;
        });

        // Remove the closest table row
        $row.remove();
    }

    // Recalculate the total or perform any other necessary calculations
    calculate(0, 0);
});

// $(document).on('click', '.btnremove', function() {
//     var removedItem = $(this).attr("data-id");
//
//     // Remove the item from the productarr array
//     productarr = jQuery.grep(productarr, function(value) {
//         return value != removedItem;
//     });
//
//     // Remove the closest table row
//     $(this).closest('tr').remove();
//
//     // Recalculate the total or perform any other necessary calculations
//     calculate(0, 0);
// });





// $(document).on('change', '#txtdiscount_p', function() {
//     calculate(0,0);
// })

// Event delegation for dynamically added quantity inputs
$(document).on('change', 'input[id^="qty_id"]', function() {
    calculate();
});
