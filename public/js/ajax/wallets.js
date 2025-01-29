// get the transaction related to the wallet
$(document).ready(function () {
    $('.balance').click(function () {
        const walletId = $(this).data('wallet-id'); // Get the wallet ID from the clicked element
        const url = walletUrl.replace(':id', walletId); // Replace the placeholder with the wallet ID

        console.log(walletId);
        // Send an AJAX request to fetch the transactions
        $.ajax({
            url: url,
            type: 'GET', // Use GET to fetch data

            success: function (response) {
                if (response.success) {
                    const transactions = response.transactions;

                    // Clear the table body
                    const tableBody = $('table tbody');
                    tableBody.empty();

                    // Populate the table with the fetched transactions
                    transactions.forEach((transaction, index) => {
                        const transactionRow = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${transaction.amount}</td>
                                <td>${transaction.wallet_name}</td>
                                <td>
                                    <span class="badge ${transaction.type === 'deposit' ? 'badge-success' : 'badge-danger'}">
                                        ${transaction.type === 'deposit' ? 'إيداع' : 'سحب'}
                                    </span>
                                </td>
                                <td>${transaction.description || 'بدون وصف'}</td>
                            </tr>
                        `;
                        tableBody.append(transactionRow);


                    });
                    $('.balance').removeClass('selected-wallet');
                    $(this).addClass('selected-wallet');
                } else {
                    Swal.fire('خطأ!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('خطأ!', 'حدث خطأ أثناء جلب البيانات.', 'error');
            }
        });
    });
});
