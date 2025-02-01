// Get the form element
const form = document.getElementById('pos-form');
const barcode = document.getElementById('txtbarcode_id');
const submitButton = document.getElementById('submit-button'); // Assuming your button has this ID

// Prevent the form from submitting on a regular Enter key press
form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
    // Add your custom form handling logic here
});

//Handle form submission when Ctrl + Enter is pressed
document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && event.ctrlKey) {
        // Simulate form submission
        form.submit();
    }
});


submitButton.addEventListener('click', function (e){
    e.preventDefault();
    if (e.pointerType === 'mouse') {
        form.submit();
    }
})
