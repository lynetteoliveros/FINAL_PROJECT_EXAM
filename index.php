<?php
session_start();

// Collect messages from session
$errors = [
    'login' => $_SESSION['login_error'] ?? '', 
    'register' => $_SESSION['register_error'] ?? ''
];
$successMessage = $_SESSION['success_message'] ?? '';
$activeForm = $_SESSION['active_form'] ?? 'login'; 

// Clear session messages after loading
session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'> $error</p>" : ''; 
}

function showSuccess($message) {
    return !empty($message) ? "<p class='success-message'> $message</p>" : ''; 
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : ''; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login & Register</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">

        <!-- Display success message if any -->
        <?= showSuccess($successMessage); ?>

        <!-- LOGIN FORM -->
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <p><a href="forgot_password.php">Forgot Password?</a></p>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <h2>Register</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <select name="role" required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script>
        function showForm(formId) {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');
            document.getElementById(formId).classList.add('active');
        }
    </script>
</body>
</html>
