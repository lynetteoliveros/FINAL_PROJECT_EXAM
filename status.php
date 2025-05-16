<?php
session_start();

// 1. Session check
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// 2. Include DB connection
include 'config.php';  // dapat dito nade-define ang $conn

// 3. Fetch tickets for the logged-in user
$email = $_SESSION['email'];
$sql   = "SELECT 
            id, subject, severity, status, created_at 
          FROM tickets 
          WHERE email = ? 
          ORDER BY created_at DESC";
$stmt  = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Your Ticket Status</title>
  <link rel="stylesheet" href="design/user.css" />
</head>
<body style="background: #fff;">

  <!-- Header -->
  <header>
    <div class="header-container">
      <h1 class="logo">HELPDESK</h1>
      <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
      <h2 class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    </div>
  </header>

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar">
    <button class="close-btn" onclick="toggleSidebar()">×</button>
    <ul>
      <li><a href="admin_page.php">Dashboard</a></li>
      <li><a href="ticketstatus.php" class="active">Ticket Status</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="settings.php">Settings</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <main class="ticket-form-container" style="width: 70%; margin: 150px auto 40px auto;">
    <h2>Your Submitted Tickets</h2>

    <?php if ($result->num_rows === 0): ?>
      <p style="text-align:center; color:#555;">You haven't submitted any tickets yet.</p>
    <?php else: ?>
      <table style="width:100%; border-collapse:collapse;">
        <thead>
          <tr style="background-color:#7494ec; color:white;">
            <th style="padding:10px; border:1px solid #ddd;">ID</th>
            <th style="padding:10px; border:1px solid #ddd;">Subject</th>
            <th style="padding:10px; border:1px solid #ddd;">Severity</th>
            <th style="padding:10px; border:1px solid #ddd;">Status</th>
            <th style="padding:10px; border:1px solid #ddd;">Submitted On</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td style="padding:8px; border:1px solid #ddd;"><?= htmlspecialchars($row['id']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= htmlspecialchars($row['subject']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= htmlspecialchars($row['severity']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= htmlspecialchars($row['status']) ?></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= htmlspecialchars($row['created_at']) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
  </script>
</body>
</html>
<?php
// 4. Clean up
$stmt->close();
$conn->close();
?>
