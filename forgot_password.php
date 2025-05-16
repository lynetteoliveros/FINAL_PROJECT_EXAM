<?php
session_start();
require_once 'config.php';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $newpass = $_POST['new_password'];
    $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {
        $conn->query("UPDATE users SET password='$hashed_pass', failed_attempts=0 WHERE email='$email'");

        $_SESSION['success_message'] = "New password successfully changed! Please log in.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Email not found.";
        header("Location: forgot_password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box active">
            <?php
            if (!empty($_SESSION['error_message'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
            <form method="post">
                <h2>Reset Password</h2>
                <input type="email" name="email" placeholder="Enter your registered email" required>
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <button type="submit" name="reset">Change Password</button>
                <p><a href="index.php">Back to Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
