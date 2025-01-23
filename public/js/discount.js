document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners to all edit icons
    const editButtons = document.querySelectorAll('.edit-expense');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get expense data from the clicked row
            const expenseId = this.getAttribute('data-id');
            const expenseAmount = this.getAttribute('data-amount');
            const expenseDetails = this.getAttribute('data-details');

            // Update the form
            const form = document.getElementById('expenseForm');
            const formTitle = document.getElementById('formTitle');
            const formButton = document.getElementById('formButton');
            const expenseIdInput = document.getElementById('expenseId');
            const expenseAmountInput = document.getElementById('expenseAmount');
            const expenseDetailsInput = document.getElementById('expenseDetails');

            // Change form action to update route
            // form.action = `/expenses/${expenseId}`; // Update the route to your actual update route
            form.action = expenseEditUrl.replace(':id', expenseId) ;

            formTitle.textContent = 'تعديل النفقة';
            formButton.textContent = 'تحديث النفقة';

            // Set expense ID, amount, and details in the form
            expenseIdInput.value = expenseId;
            expenseAmountInput.value = expenseAmount;
            expenseDetailsInput.value = expenseDetails;

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

