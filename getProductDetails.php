<?php
include 'connect.php';

$productID = $_GET['productID'];
$productQuery = "SELECT * FROM product WHERE productID = '$productID'";
$productResult = mysqli_query($conn, $productQuery);

if ($productResult && mysqli_num_rows($productResult) > 0) {
    $product = mysqli_fetch_assoc($productResult);

    $categoryQuery = "SELECT * FROM productcategories";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

    $specQuery = "SELECT * FROM specification WHERE productID = '$productID'";
    $specResult = mysqli_query($conn, $specQuery);
    $specifications = [];
    while ($spec = mysqli_fetch_assoc($specResult)) {
        $specID = $spec['specID'];
        $valueQuery = "SELECT * FROM specificationValue WHERE specID = '$specID'";
        $valueResult = mysqli_query($conn, $valueQuery);
        $values = mysqli_fetch_all($valueResult, MYSQLI_ASSOC);
        $specifications[] = array_merge($spec, ['values' => $values]);
    }

    echo json_encode([
        'productID' => $product['productID'],
        'name' => $product['name'],
        'description' => $product['description'],
        'categoryID' => $product['categoryID'],
        'categories' => $categories,
        'price' => $product['price'],
        'discountedPrice' => $product['discountedPrice'],
        'specifications' => $specifications
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
}
?>