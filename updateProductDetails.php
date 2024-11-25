<?php
header('Content-Type: application/json');
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $productID = $input['productID'];
    $name = $input['name'];
    $description = $input['description'];
    $categoryID = $input['categoryID'];
    $price = $input['price'];
    $discountedPrice = $input['discountedPrice'];

    $updateProduct = $conn->prepare("UPDATE product SET name = ?, description = ?, categoryID = ?, price = ?, discountedPrice = ? WHERE productID = ?");
    $updateProduct->bind_param('ssisdi', $name, $description, $categoryID, $price, $discountedPrice, $productID);

    if ($updateProduct->execute()) {
        $conn->query("DELETE FROM specification WHERE productID = $productID");
        $conn->query("DELETE sv FROM specificationvalue sv
              JOIN specification s ON sv.specID = s.specID
              WHERE s.productID = $productID");

        foreach ($input['specifications'] as $spec) {
            $insertSpec = $conn->prepare("INSERT INTO specification (productID, specName) VALUES (?, ?)");
            $insertSpec->bind_param('is', $productID, $spec['specName']);
            $insertSpec->execute();

            $specID = $conn->insert_id;

            foreach ($spec['values'] as $value) {
                $valueName = $value['valueName'];
                $stock = $value['stock'];

                $insertValue = $conn->prepare("INSERT INTO specificationvalue (specID, valueName, stock) VALUES (?, ?, ?)");
                $insertValue->bind_param('isi', $specID, $valueName, $stock);
                $insertValue->execute();
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
