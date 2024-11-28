<?php
session_start();
include ('connect.php');

$categoryID = $_GET['categoryID'];

if ($categoryID == 'All') {
  $productsQuery = 'SELECT * FROM product';
  $stmt = $conn->prepare($productsQuery);
  $categoryName = "All";
} else {
  $productsQuery = 'SELECT * FROM product WHERE categoryID = ?';
  $stmt = $conn->prepare($productsQuery);
  $stmt->bind_param('i', $categoryID);

  $categoryQuery = 'SELECT name FROM productcategories WHERE categoryID = ?';
  $categoryStmt = $conn->prepare($categoryQuery);
  $categoryStmt->bind_param('i', $categoryID);
  $categoryStmt->execute();
  $categoryResult = $categoryStmt->get_result();

  if ($row = $categoryResult->fetch_assoc()) {
    $categoryName = $row['name'];
  } else {
    $categoryName = "Unknown";
  }

  $categoryStmt->close();
}

$stmt->execute();
$results = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/productList.css">
  <link rel="stylesheet" href="css/styles.css">
  <title>Steel and Stones - Products</title> 

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>

  
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navcolor">
        <div class="container-fluid mx-3">
          <a class="navbar-brand" href="index.php"><img src="files/logo-no-background 1.png" alt="logo" style="width: 90.36px; height: 46px;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle bcolor" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Categories
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="productList.php?categoryID=1">Construction Materials</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=2">Tools</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=3">Paints and Finishing</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=4">Fasteners and Fittings</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=5">Electric Supplies</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=6">Plumbing Supplies</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=7">Safety Equipments</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=8">Gardening Tools</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=9">Woodworking Supplies</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=10">Miscellaneous</a></li>
                  <li><a class="dropdown-item" href="productList.php?categoryID=All">All</a></li>
                </ul>
              </li>
            </ul>
            <form class="d-flex justify-content-between" role="search" style="width: 40%;max-width: 350px;">
              <div class="search">
                <button class="btn" type="submit"><img src="files/icons/search.svg" alt=""></button>
                <input class="searchInput" type="search" placeholder="Search" aria-label="Search">
              </div>
              <a href="cart.php" class="navIcon"><img src="files/icons/cart.svg" alt="cart"></a>
              <a href="userProfile.php" class="navIcon"><img src="files/icons/user.svg" alt="user"></a>
            </form>
          </div>
        </div>
    </nav>
    
  <div class="container my-5">
    <h2 class=" mb-4"><?php htmlspecialchars($categoryName) ?></h2>
    <div class="row d-flex justify-content-center align-items-center gy-4">

    <?php while ($product = $results->fetch_assoc()): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center align-items-center">
            <div class="card product-card">
                <img src="<?= htmlspecialchars($product['picture']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                    <p class="price">Rs. <?= number_format($product['price'], 2); ?></p>
                    <a href="viewProduct.php?productID=<?= htmlspecialchars($product['productID']); ?>" class="btn btn-addToCart">View Product</a>
                </div>
            </div>
        </div>
    <?php endwhile;?>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
