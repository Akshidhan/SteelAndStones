<?php
include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = intval($_POST['category']);
    $price = floatval($_POST['price']);
    $discountedPrice = floatval($_POST['discountedPrice']);
    $specifications = json_decode($_POST['specifications'], true);

    $targetDir = "files/products/";
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
        die("Error uploading file.");
    }

    $imagePath = $targetFile;

    $productQuery = "
        INSERT INTO product (name, description, categoryID, price, discountedPrice, picture)
        VALUES ('$name', '$description', $category, $price, $discountedPrice, '$imagePath')
    ";

    if (!$conn->query($productQuery)) {
        echo json_encode(['error' => 'Failed to insert product: ' . $conn->error]);
        exit;
    }

    $productID = $conn->insert_id;

    foreach ($specifications as $spec) {
        $specName = $conn->real_escape_string($spec['specName']);
        $specQuery = "
            INSERT INTO specification (productID, specName)
            VALUES ($productID, '$specName')
        ";

        if (!$conn->query($specQuery)) {
            echo json_encode(['error' => 'Failed to insert specification: ' . $conn->error]);
            exit;
        }

        $specID = $conn->insert_id;

        foreach ($spec['value'] as $value) {
            $specValue = $conn->real_escape_string($value['valueName']);
            $stock = intval($value['stock']);

            $valueQuery = "
                INSERT INTO specificationvalue (specID, specValue, stock)
                VALUES ($specID, '$specValue', $stock)
            ";

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['error' => 'JSON encoding error: ' . json_last_error_msg()]);
                exit;
            }

            if (!$conn->query($valueQuery)) {
                echo json_encode(['error' => 'Failed to insert specification value: ' . $conn->error]);
                exit;
            }
        }
    }

    echo json_encode(['success' => 'Product and specifications added successfully!']);
}
?>