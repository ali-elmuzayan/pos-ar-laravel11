$(document).ready(function() {
    $('#customer_phone').on('input', function() {
        var phone = $(this).val();

        if (phone.length >= 10) { // Assuming phone numbers are at least 10 digits
            $.ajax({
                url: customerURL,
                type: "GET",
                data: { phone: phone },
                success: function(response) {
                    if (response.exists) {
                        $('#customer_name_container').html('<div class="input-group mb-3">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text"><i class="fa fa-user"></i></span>' +
                            '</div>' +
                            '<input type="text" class="form-control" id="customer_name" name="customer_name" value="' + response.name + '" readonly>' +
                            '</div>');
                    } else {
                        $('#customer_name_container').html('<div class="input-group mb-3">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" style="width:160px"><i class="fa fa-user"></i></span>' +
                            '</div>' +
                            '<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="ادخل اسم العميل">' +
                            '</div>');
                    }
                },
                error: function(xhr) {
                }
            });
        }
    });
});
