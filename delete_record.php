<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type']) && isset($_POST['id'])) {
    $type = $_POST['type']; // 'user' or 'admin'
    $id = intval($_POST['id']);

    if ($type === 'user') {
        $table = 'users';
        $column = 'userID';
    } elseif ($type === 'admin') {
        $table = 'admin';
        $column = 'adminID';
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid type specified']);
        exit;
    }

    $sql = "DELETE FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => ucfirst($type) . ' deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting ' . $type]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
