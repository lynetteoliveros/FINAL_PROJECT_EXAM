<?php
include 'config.php';

$sql = "SELECT id, name, email, subject, description, created_at, severity, status, assigned FROM tickets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Ticket Status</title>
    <link rel="stylesheet" href="design/ts.css" />
</head>
<body>

<header>
    <div class="header-container">
        <button id="menu-btn" class="menu-btn">&#9776;</button>
        <h1>Status</h1>
    </div>
</header>

<aside id="sidebar" class="sidebar">
    <nav>
        <ul>
            <li><a href="admin_page.php">Dashboard</a></li>
            <li><a href="ticketstatus.php">Status</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</aside>

<main id="main-content">
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead style="background-color: #7494ec; color: white;">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Description</th><th>Created At</th><th>Severity</th><th>Status</th><th>Assigned</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td><?= htmlspecialchars($row['severity']) ?></td>
                    <td>
                        <select class="status-dropdown" data-id="<?= $row['id'] ?>">
                            <option value="Open" <?= $row['status'] === 'Open' ? 'selected' : '' ?>>Open</option>
                            <option value="In Progress" <?= $row['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="Closed" <?= $row['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="Resolved" <?= $row['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </td>
                    <td>
                        <select class="assigned-dropdown" data-id="<?= $row['id'] ?>">
                            <option value="Admin 1" <?= $row['assigned'] === 'Admin 1' ? 'selected' : '' ?>>Admin 1</option>
                            <option value="Admin 2" <?= $row['assigned'] === 'Admin 2' ? 'selected' : '' ?>>Admin 2</option>
                            <option value="Admin 3" <?= $row['assigned'] === 'Admin 3' ? 'selected' : '' ?>>Admin 3</option>
                        </select>


                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" style="text-align:center;">No tickets found.</td></tr>
            <?php endif; ?>
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

    // Update status
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            const value = this.value;

            fetch('update_ticket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&column=status&value=${encodeURIComponent(value)}`
            });
        });
    });

    // Update assigned
    document.querySelectorAll('.assigned-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function () {
            const id = this.getAttribute('data-id');
            const value = this.value;

            fetch('update_ticket.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&column=assigned&value=${encodeURIComponent(value)}`
            });
        });
    });
</script>   

</body>
</html>

<?php $conn->close(); ?>
