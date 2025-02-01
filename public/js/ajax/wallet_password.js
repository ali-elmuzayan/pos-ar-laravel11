$(document).ready(function() {
    $('.withdrawBtn').click(function() {
        var tdh = $(this);
        var id = this.getAttribute('data-id');

        Swal.fire({
            title: 'ادخل كلمة المرور',
            input: 'password',
            inputLabel: 'أدخل كلمة المرور',
            inputPlaceholder: 'كملة المرور',
            showCancelButton: true,
            confirmButtonText: 'تفريغ الخزنة',
            cancelButtonText: 'إلغاء',
            inputValidator: (value) => {
                if (!value) {
                    return 'يجب ادخال كلمة المرور!';
                }
            }
        }).then((result) => {
            if (result.value) {
                const password = result.value;
                $.ajax({
                    url: walletEmptyingURL,
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        password: password // Send the password to the server
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('تم تفريغ الخزنة!', response.message, 'success');
                            $(`.balance`).text(`المبلغ في الخزنة 00.`+ response.balance );

                        } else {
                            Swal.fire('خطأ!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('خطأ!', 'حدث خطأ أثناء الإضافة.', 'error');
                    }
                });
            }
        });
    });
});
