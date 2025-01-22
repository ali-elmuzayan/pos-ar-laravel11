//delete the product
$(document).ready(function() {
    $('.btndelete').click(function() {
        var tdh = $(this);
        var id = $(this).attr("id");


        Swal.fire({
            title: 'هل تريد الحذف؟',
            text: "لن يمكنك التراجع عن هذا الإجراء",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم! احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.value) {
                // Construct the URL dynamically with the ID

                $.ajax({
                    url: url, // Use the dynamically constructed URL
                    // url: '/test/1',
                    type: 'post', // Use DELETE method
                    data: {
                        _token: csrf, // Add CSRF token
                        _method: 'DELETE', // Spoof the DELETE method
                        id: id,
                    },
                    success: function(response) {
                        if (response.success) {
                            tdh.parents('tr').fadeOut('fast');
                            Swal.fire('تم الحذف!', response.message, 'success');
                        } else {
                            Swal.fire('خطأ!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                    }
                });

            }
        });
    });
});

