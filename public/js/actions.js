document.addEventListener("keydown", function (event) {
    // Check if the key pressed is the specific one you want
    if (event.key === "F3") { // Change "Enter" to your desired key
        event.preventDefault();
        window.location.href = orderRoute
    }
    if (event.key === "F2") {
        event.preventDefault(); // Prevent default F2 action (e.g., opening developer tools)
        window.location.href = posRoute; // Redirect to the POS page
    }
    if (event.key === "F4") {
        event.preventDefault(); // Prevent default F2 action (e.g., opening developer tools)
        window.location.href = categoryRoute;

    }
});

// Define the action
function performAction() {

    alert("Action triggered by pressing Enter!");
    // Add your custom logic here
}
