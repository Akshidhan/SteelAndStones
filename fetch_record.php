<?php
include 'connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type']) && isset($_POST['id'])) {
    $type = $_POST['type']; // 'user' or 'admin'
    $id = intval($_POST['id']);

    // Determine the table and column based on the type
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

    // Prepare the SQL statement
    $sql = "SELECT * FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Execute and return the result
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $record = $result->fetch_assoc();
            echo json_encode(['success' => true, 'data' => $record]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No record found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching record']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
