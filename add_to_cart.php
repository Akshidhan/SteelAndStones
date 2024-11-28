<?php
include ('connect.php');
header('Content-Type: application/json');

// Decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (isset($data['userID'], $data['productID'], $data['specID'], $data['valueID'], $data['quantity'])) {
    $userID = $data['userID'];
    $productID = $data['productID'];
    $specID = $data['specID'];
    $valueID = $data['valueID'];
    $quantity = $data['quantity'];

    // Check if the user has an existing cart
    $cartID = null;
    $query = "SELECT cartID FROM cart WHERE userID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the existing cartID
        $row = $result->fetch_assoc();
        $cartID = $row['cartID'];
    } else {
        // If no cart exists, create a new one and get the cartID
        $query = "INSERT INTO cart (userID) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userID);
        if ($stmt->execute()) {
            $cartID = $conn->insert_id; // Get the last inserted ID
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create cart.']);
            exit;
        }
    }

    // Add the item to the cartitem table
    $query = "INSERT INTO cartitem (cartID, productID, specID, valueID, quantity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiii", $cartID, $productID, $specID, $valueID, $quantity);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item added to cart successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add item to cart.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
