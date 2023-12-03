<?php
include 'db_config.php';

session_start();

if (isset($_POST['signup'])) {
    // Registration logic with error handling
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($name) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required'); window.location='index.html';</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location='index.html';</script>";
    } elseif (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long'); window.location='index.html';</script>";
    } else {
        // Check if email is already taken
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $checkEmailResult = $conn->query($checkEmailQuery);

        if ($checkEmailResult->num_rows > 0) {
            echo "<script>alert('Email is already taken'); window.location='index.html';</script>";
        } else {
            // Hash the password and insert into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

            if ($conn->query($insertQuery) === TRUE) {
                echo "<script>alert('Registration successful'); window.location='index.html';</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "'); window.location='index.html';</script>";
            }
        }
    }
} elseif (isset($_POST['login'])) {
    // Login logic with error handling
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        echo "<script>alert('All fields are required'); window.location='index.html';</script>";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id']; // Set user_id in the session
                header("Location: dashboard.php"); // Redirect to the dashboard
            } else {
                echo "<script>alert('Wrong Password'); window.location='index.html';</script>";
            }
        } else {
            echo "<script>alert('Email does not exist'); window.location='index.html';</script>";
        }
    }
}

$conn->close();
