<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Page</title>
    <link rel="stylesheet" href="design/a.css" />
</head>
<body>

    <header>
        <div class="header-container">
            <button id="menu-btn" class="menu-btn">&#9776;</button>
            <h1>Admin Dashboard</h1>
        </div>
    </header>

    <aside id="sidebar" class="sidebar">
        <nav>
            <ul>
                <li><a href="admin_page.php">Dashboard</a></li>
                <li><a href="ticketstatus.php">Ticket Status</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main id="main-content">
        <!-- Filters and Search -->
        <div class="filter-container">
            <input type="text" id="searchInput" placeholder="Search tickets..." />

            <select id="statusFilter">
                <option value="">All Status</option>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
                <option value="Closed">Closed</option>
            </select>

            <select id="severityFilter">
                <option value="">All Severity</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                <option value="Critical">Critical</option>
            </select>

            <!-- Changed values here to exactly match the displayed text in the table -->
            <select id="assignedFilter">
                <option value="">All Assigned</option>
                <option value="Admin 1">Admin 1</option>
                <option value="Admin 2">Admin 2</option>
                <option value="Admin 3">Admin 3</option>
            </select>

        </div>

        <!-- Ticket Table -->
        <div class="ticket-table">
            <h2>All Tickets</h2>
            <table id="ticketsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Severity</th>
                        <th>Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tickets ORDER BY created_at ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars(trim($row['name'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['email'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['id'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['subject'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['description'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['status'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['created_at'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['severity'])) . "</td>";
                            echo "<td>" . htmlspecialchars(trim($row['assigned'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No tickets found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('shifted');
        });

        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const severityFilter = document.getElementById('severityFilter');
        const assignedFilter = document.getElementById('assignedFilter');
        const table = document.getElementById('ticketsTable');
        const tbody = table.tBodies[0];

        function filterTickets() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusTerm = statusFilter.value.toLowerCase().trim();
            const severityTerm = severityFilter.value.toLowerCase().trim();
            const assignedTerm = assignedFilter.value.toLowerCase().trim();

            for (let row of tbody.rows) {
                const name = row.cells[0].textContent.toLowerCase().trim();
                const email = row.cells[1].textContent.toLowerCase().trim();
                const id = row.cells[2].textContent.toLowerCase().trim();
                const subject = row.cells[3].textContent.toLowerCase().trim();
                const description = row.cells[4].textContent.toLowerCase().trim();
                const status = row.cells[5].textContent.toLowerCase().trim();
                const severity = row.cells[7].textContent.toLowerCase().trim();
                const assigned = row.cells[8].textContent.toLowerCase().trim();

                const matchesSearch =
                    name.includes(searchTerm) ||
                    email.includes(searchTerm) ||
                    id.includes(searchTerm) ||
                    subject.includes(searchTerm) ||
                    description.includes(searchTerm);

                const matchesStatus = statusTerm === "" || status === statusTerm;
                const matchesSeverity = severityTerm === "" || severity === severityTerm;
                const matchesAssigned = assignedTerm === "" || assigned === assignedTerm;

                if (matchesSearch && matchesStatus && matchesSeverity && matchesAssigned) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        searchInput.addEventListener('input', filterTickets);
        statusFilter.addEventListener('change', filterTickets);
        severityFilter.addEventListener('change', filterTickets);
        assignedFilter.addEventListener('change', filterTickets);
    </script>

</body>
</html>
