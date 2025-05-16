<?php
session_start(); 
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit(); 
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="design/user.css" />
</head>
<body style="background: #fff;">
    
    <!-- Header -->
    <header>
        <div class="header-container">
            <h1 class="logo">HELPDESK</h1>
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
            <h2 class="welcome-message">Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        </div>
    </header>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <button class="close-btn" onclick="toggleSidebar()">×</button>
        <ul>
            <li><a href="user_page.php">Dashboard</a></li>
            <li><a href="status.php">Ticket Status</a></li>
            <li><a href="settings.php">Settings</a></li> <!-- Corrected here -->
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="ticket-form-container">
        <h2>Submit a Helpdesk Ticket</h2>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
            <p style="color: green; text-align: center;">Your ticket has been submitted successfully!</p>
        <?php endif; ?>

        <form class="ticket-form" method="post" action="submit_ticket.php">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter the subject of your issue" required />

            <label for="severity">Severity Level:</label>
            <select id="severity" name="severity" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Describe your issue in detail" required></textarea>

            <!-- Hidden inputs to send name and email -->
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>" />
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />

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
