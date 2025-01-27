var product=[];

$(function() {
    $('#txtbarcode_id').on('change', function() {

        var barcode = $('#txtbarcode_id').val();
        var url = productRoute.replace(':code', barcode);

        $.ajax({
            url:url,
            method: "get",
            dataType: "json",
            data: {id:barcode},
            success:function(data){
                // check if the value exist in the array

                if(jQuery.inArray(data['id'], product) !== -1) {

                    // add one to the quantity in case it is the same product
                    var actualQty = parseInt($('#qty_id'+data["id"]).val())+1;
                    $('#qty_id'+data["id"]).val(actualQty);

                    var sellingPrice=parseInt(actualQty)*data["selling_price"];

                    $('#saleprice_id'+data["id"]).html(sellingPrice);
                    $('#saleprice_idd'+data["id"]).val(sellingPrice);
                    calculate(0,0)
                }else {
                    addRow(data['id'], data['name'], data['selling_price'],data['stock'], data['barcode']);
                    product.push(data['id']);
                    calculate(0,0)
                }

                $('#txtbarcode_id').val("");

            },
            error:function(response) {
                // on error result

                swal.fire('حدث خطأ!', 'يرجى ادخال منتج صحيح', 'warning');

            }
        })
    })
})
// $(function() {
//
//
//     $('#txtbarcode_id').on('change', function() {
//         var barcode = $('#txtbarcode_id').val();
//         var url = productRoute.replace(':code', barcode);
//
//         $.ajax({
//             url: url,
//             method: "get",
//             dataType: "json",
//             data: { id: barcode },
//             success: function(data) {
//                 // Check if the value exists in the array
//                 if (jQuery.inArray(data['id'], product) !== -1) {
//                     // Add one to the quantity in case it is the same product
//                     var actualQty = parseInt($('#qty_id' + data["id"]).val()) + 1;
//                     $('#qty_id' + data["id"]).val(actualQty);
//
//                     var sellingPrice = parseInt(actualQty) * data["selling_price"];
//
//                     $('#saleprice_id' + data["id"]).html(sellingPrice);
//                     $('#saleprice_idd' + data["id"]).val(sellingPrice);
//
//                 } else {
//                     addRow(data['id'], data['name'], data['selling_price'], data['stock'], data['barcode']);
//                     product.push(data['id']);
//                 }
//
//                 $('#txtbarcode_id').val("");
//                 calculate(); // Call calculate() after updating the quantity
//             },
//             error: function(response) {
//                 // On error result
//                 swal.fire('حدث خطأ!', 'يرجى ادخال منتج صحيح', 'warning');
//             }
//         });
//     });
// });


//selected
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

        '<td><input type="number" class="form-control qty" readonly name="quantity_arr[]" id="qty_id'+id+'" value="'+1+'" size="1" min="1" max="'+stock+'"></td>'+

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


// calculate
// function calculate() {
//     var subtotal=0;
//     var discount=0;
//     var total = 0;
//     var paidAmount = 0;
//     var due =0;
//
//     $('.saleprice').each(function(){
//         subtotal = subtotal + ($(this).val()*1);
//     });
//     $('#txtsubtotal_id').val(subtotal.toFixed(2))
//     discount = parseInt('#txtdiscount_p').val();
//
//     discount = discount/100 ;
//     console.log(discount);
//     discount = discount * subtotal;
//     console.log(discount);
//     $('#txtdiscount_n').val(discount.toFixed(2));
//
//     total = subtotal - discount;
//
//     due = paidAmount - subtotal;
//     $('#txttotal').val(total.toFixed(2));
// }

function calculate() {
    var subtotal = 0;
    var discount = 0;
    var total = 0;
    var paidAmount = 0;
    var due = 0;

    // Calculate subtotal by summing up all .saleprice inputs
    $('.saleprice').each(function () {
        var price = parseFloat($(this).val()) || 0; // Ensure it's a number, default to 0 if invalid
        subtotal += price;
    });
    $('#txtsubtotal_id').val(subtotal.toFixed(2));

    // Get discount percentage and calculate discount amount
    var discountPercentage = parseFloat($('#txtdiscount_p').val()) || 0; // Ensure it's a number, default to 0 if invalid
    discount = (discountPercentage / 100) * subtotal;
    $('#txtdiscount_n').val(discount.toFixed(2));

    // Calculate total after discount
    total = subtotal - discount;
    $('#txttotal').val(total.toFixed(2));

    // Get paid amount and calculate due
    paidAmount = parseFloat($('#txtpaid').val()) || 0; // Ensure it's a number, default to 0 if invalid
    due = total - paidAmount;
    $('#txtdue').val(due.toFixed(2));
}



// Remove button
// Declare productarr in the global scope
var productarr = []; // Initialize it as an empty array or with your data

$(document).on('click', '.btnremove', function() {
    var removedItem = $(this).attr("data-id");

    // Remove the item from the productarr array
    productarr = jQuery.grep(productarr, function(value) {
        return value != removedItem;
    });

    // Remove the closest table row
    $(this).closest('tr').remove();

    // Recalculate the total or perform any other necessary calculations
    calculate(0, 0);
});


// on change the
$(document).on('change', '#txtdiscount_p', function() {
    calculate(0,0);
})

// $(document).on('change', '#txtdiscount_p', function() {
//     calculate(0,0);
// })

// Event delegation for dynamically added quantity inputs
$(document).on('change', 'input[id^="qty_id"]', function() {
    calculate();
});
