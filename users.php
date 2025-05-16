<?php
include 'config.php'; // siguraduhing dito nakaset ang connection sa users_db

// Query to get all users
$sql = "SELECT id, name, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Users List</title>
  <link rel="stylesheet" href="design/a.css" /> <!-- or your css -->
</head>
<body>

<header>
  <div class="header-container">
    <button id="menu-btn" class="menu-btn">&#9776;</button>
    <h1>Users</h1>
  </div>
</header>

<aside id="sidebar" class="sidebar">
  <nav>
    <ul>
      <li><a href="admin_page.php">Dashboard</a></li>
      <li><a href="ticketstatus.php">Status</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="#">Settings</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</aside>

<main id="main-content">
  <h2>All Users</h2>
  <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead style="background-color: #7494ec; color: white;">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['role']) . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='4' style='text-align:center;'>No users found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</main>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('main-content');

  menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      mainContent.classList.toggle('shifted');
  });
</script>

</body>
</html>

<?php $conn->close(); ?>
