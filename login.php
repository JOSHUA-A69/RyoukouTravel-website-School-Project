<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
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
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields
    $errors = [];

    if (empty($fullname)) {
        $errors[] = "Full Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email Address is required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($confirm_password)) {
        $errors[] = "Please confirm your password";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists in the database
    $sql_check_email = "SELECT * FROM users WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        $errors[] = "An account with this email already exists";
    }

    // If no errors, proceed with sign-up
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql_insert_user = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
        if ($conn->query($sql_insert_user) === TRUE) {
            // Redirect to main page or dashboard after sign-up
            header("Location: Blog.html");
            exit();
        } else {
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p class='error-message'>$error</p>";
        }
    }
}

// Login Process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_button'])) {
    // Retrieve login form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for errors
    $login_email_error = $login_password_error = '';

    if (empty($email)) {
        $login_email_error = "Email is required";
    }
    if (empty($password)) {
        $login_password_error = "Password is required";
    }

    // Additional validation
    if (empty($login_email_error) && empty($login_password_error)) {
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
}

$conn->close();
?>
