<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role']; 

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'"); 
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!'; 
        $_SESSION['active_form'] = 'register'; 
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')"); 
    }

    header("Location: index.php"); 
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if account is locked
        if ($user['failed_attempts'] >= 5) {
            $_SESSION['login_error'] = 'Account locked due to multiple failed login attempts.';
            $_SESSION['active_form'] = 'login';
            header("Location: index.php");
            exit();
        }

        // Check password
        if (password_verify($password, $user['password'])) {
            // Reset failed attempts upon successful login
            $conn->query("UPDATE users SET failed_attempts = 0, last_failed_login = NULL WHERE email = '$email'");

            $_SESSION['name'] = $user['name']; 
            $_SESSION['email'] = $user['email']; 

            if ($user['role'] === 'admin') {
                header("Location: admin_page.php"); 
            } else {
                header("Location: user_page.php"); 
            }
            exit(); 
        } else {
            // Increment failed attempts
            $newAttempts = $user['failed_attempts'] + 1;
            $conn->query("UPDATE users SET failed_attempts = $newAttempts, last_failed_login = NOW() WHERE email = '$email'");

            $_SESSION['login_error'] = 'Incorrect Email or Password';
            $_SESSION['active_form'] = 'login';
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Email not found';
        $_SESSION['active_form'] = 'login';
        header("Location: index.php");
        exit();
    }
}
