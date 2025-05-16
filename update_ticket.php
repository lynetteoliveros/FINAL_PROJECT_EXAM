<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $column = $_POST['column'];
    $value = trim($_POST['value']);

    // Limit to only updating allowed columns
    if (!in_array($column, ['status', 'assigned'])) {
        http_response_code(400);
        exit('Invalid column');
    }

    $stmt = $conn->prepare("UPDATE tickets SET $column = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $id);

    if ($stmt->execute()) {
        echo "Updated";
    } else {
        http_response_code(500);
        echo "Failed to update";
    }

    $stmt->close();
    $conn->close();
}
?>
