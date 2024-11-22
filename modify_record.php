<?php
include 'connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $username = $_POST['username'];
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    if ($type === 'user') {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE userID = ?");
        $stmt->bind_param("ssi", $username, $email, $id);
    } elseif ($type === 'admin') {
        $stmt = $conn->prepare("UPDATE admin SET username = ? WHERE adminID = ?");
        $stmt->bind_param("si", $username, $id);
    } else {
        $response['message'] = 'Invalid record type.';
        echo json_encode($response);
        exit;
    }

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Failed to update record.';
    }

    $stmt->close();
}

echo json_encode($response);
?>
