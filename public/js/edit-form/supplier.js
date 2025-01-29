document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all edit icons
    const editButtons = document.querySelectorAll('.edit-supplier');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get supplier data from the clicked row
            const supplierId = this.getAttribute('data-id');
            const supplierName = this.getAttribute('data-name');
            const supplierPhone = this.getAttribute('data-phone');
            const supplierDescription = this.getAttribute('data-description');
            const supplierAddress = this.getAttribute('data-address');

            // Update the form
            const form = document.getElementById('supplierForm');
            const formTitle = document.getElementById('FormTitle');
            const formButton = document.getElementById('formButton');
            const supplierNameInput = document.getElementById('supplierName');
            const supplierPhoneInput = document.getElementById('supplierPhone');
            const supplierDescriptionInput = document.getElementById('supplierDescription');
            const supplierAddressInput = document.getElementById('supplierAddress');

            // Change form action to update route
            form.action = `/suppliers/${supplierId}`; // Update the route to your actual update route

            formTitle.textContent = 'تعديل الموزع';
            formButton.textContent = 'تحديث الموزع';

            // Set supplier data in the form
            supplierNameInput.value = supplierName;
            supplierPhoneInput.value = supplierPhone;
            supplierDescriptionInput.value = supplierDescription;
            supplierAddressInput.value = supplierAddress;

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
