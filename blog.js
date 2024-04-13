// scroll button
let mybutton = document.getElementById("upbtn");

window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// Function to prompt logout confirmation
function confirmLogout() {
    // Prompt user with a confirmation dialog
    let logoutConfirmed = confirm("Are you sure you want to log out?");

    // If user confirms logout, redirect to logout page
    if (logoutConfirmed) {
        window.location.href = "LogInPage.html"; 
    }
}

// Add event listener to the "Log Out" link
let logoutLink = document.querySelector("nav .nav-links li:last-child a"); 
logoutLink.addEventListener("click", confirmLogout);



