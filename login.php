<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "ryokoutravel_logincredentials"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sign-Up Process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_button'])) {
    // Retrieve sign-up form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert user data into the database
    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // Redirect to main page or dashboard after sign-up
        header("Location: Blog.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Login Process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_button'])) {
    // Retrieve login form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to find user by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, redirect to main page or dashboard
            header("Location: main_page.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // User not found
        echo "User not found";
    }
}

$conn->close();
?>
