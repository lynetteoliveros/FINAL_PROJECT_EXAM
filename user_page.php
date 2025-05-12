<?php
session_start(); 
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit(); 
}

// Assuming the user's name is stored in the session, or you can fetch it from the database
$name = $_SESSION['name']; // Replace with actual session variable or database fetch
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="design/user.css">
</head>
<body style="background: #fff;">
    
    <!-- Full-Width Header Section -->
    <header>
        <div class="header-container">
            <h1 class="logo">HELPDESK</h1>
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button> <!-- Sidebar Toggle Button -->
            <h2 class="welcome-message">Welcome, <?php echo $name; ?>!</h2> <!-- Welcome message on the right -->
        </div>
    </header>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <button class="close-btn" onclick="toggleSidebar()">×</button>
        <ul>
            <li><a href="user_page.php">Dashboard</a></li>
            <li><a href="status.php">Ticket Status</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li> <!-- Logout moved here -->
        </ul>
    </div>

    <!-- Main Content: Helpdesk Ticket Form -->
    <main class="ticket-form-container">
        <h2>Submit a Helpdesk Ticket</h2>
        <form class="ticket-form" method="post" action="#">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter the subject of your issue" required>

            <label for="severity">Severity Level:</label>
            <select id="severity" name="severity" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Describe your issue in detail" required></textarea>

            <button type="submit">Submit Ticket</button>
        </form>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>
