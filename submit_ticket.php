<?php
session_start();

// 1. Session check
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// 2. Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "users_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// 3. Sanitize POST input
$subject     = $conn->real_escape_string($_POST['subject']);
$severity    = $conn->real_escape_string($_POST['severity']);
$description = $conn->real_escape_string($_POST['description']);
$name        = $conn->real_escape_string($_SESSION['name']);
$email       = $conn->real_escape_string($_SESSION['email']);

// 4. Prepare and execute INSERT into tickets
//    Nag-iinsert lang sa subject, severity, description, name, email, status
$stmt = $conn->prepare(
    "INSERT INTO tickets 
        (subject, severity, description, name, email, status)
     VALUES (?, ?, ?, ?, ?, 'open')"
);
$stmt->bind_param(
    "sssss",
    $subject,
    $severity,
    $description,
    $name,
    $email
);

if ($stmt->execute()) {
    // 5. Redirect back to user page with success message
    header("Location: user_page.php?msg=success");
    exit();
} else {
    // 6. Show error if insert fails
    echo "Error submitting ticket: " . htmlspecialchars($stmt->error);
}

// 7. Clean up
$stmt->close();
$conn->close();
?>
