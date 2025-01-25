

document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners to all edit icons
    const editButtons = document.querySelectorAll('.edit-discount');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get expense data from the clicked row
            const discountId = this.getAttribute('data-id');
            const discountPercent = this.getAttribute('data-percent');
            const discountEndDate = this.getAttribute('data-end-date');

            // Update the form
            const form = document.getElementById('discountForm');
            const formTitle = document.getElementById('formTitle');
            const formButton = document.getElementById('formButton');
            const detailsIdInput = document.getElementById('discountId');
            const detailsPercentInput = document.getElementById('discountPercent');
            const detailsEndDateInput = document.getElementById('discountDate');

            // Change form action to update route
            // form.action = `/expenses/${expenseId}`; // Update the route to your actual update route
            form.action = discountEditUrl.replace(':id', discountId) ;

            formTitle.textContent = 'تعديل الخصم';
            formButton.textContent = 'تحديث الخصم';

            // Set expense ID, amount, and details in the form
            detailsIdInput.value = discountId;
            detailsPercentInput.value = discountPercent;
            detailsEndDateInput.value = discountEndDate;

            // Add a hidden input for the PUT method
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                form.appendChild(methodInput);
            } else {
                methodInput.setAttribute('value', 'PUT');
            }
        });
    });
});

