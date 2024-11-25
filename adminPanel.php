<?php
    include 'connect.php';

    $userQuery = "SELECT * FROM users ORDER BY username ASC";
    $users = $conn->query($userQuery);

    $adminQuery = "SELECT * FROM admin ORDER BY username ASC";
    $admins = $conn->query($adminQuery);

    $productQuery = "SELECT * FROM product";
    $products = $conn->query($productQuery);

    $specQuery = "SELECT * FROM specification";
    $specifications = $conn->query($specQuery);

    $valueQuery = "SELECT * FROM specificationvalue";
    $values = $conn->query($valueQuery);

    $categoryQuery = "SELECT * FROM productcategories";
    $categories = $conn->query($categoryQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steel And Stones</title>
    <link rel="stylesheet" href="css/owl.carousel.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/adminPage.js"></script>
</head>
<body>
    <div class="header position-relative p-5">
        <h1 class="center">Admin Panel</h1>
        <button class="btn btn-primary position-absolute top-50 end-10 translate-middle-y"><a href="logout.php" onclick="clearSessionStorage()">Logout</a></button>
    </div>
    <ul class="nav nav-tabs nav-fill">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" data-bs-toggle="tab" href="#users">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#paints">Paints</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#quotations">Quotations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#orders">Orders</a>
        </li>
    </ul>
      
      <div class="tab-content mt-3 section">
        <div class="tab-pane fade active show" id="users">
            <!-- Modify Modal -->
            <div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifyModalLabel">Modify Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="modifyForm">
                                <input type="hidden" id="recordType" name="type">
                                <input type="hidden" id="recordId" name="id">
                                <div class="mb-3">
                                    <label for="modalUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="modalUsername" name="username">
                                </div>
                                <div class="mb-3" id="emailField">
                                    <label for="modalEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="modalEmail" name="email">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="submitModifyForm()">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="customers">
                    <h2 class="my-5">Customer Accounts</h2>
                    <div class="addUser my-5">
                        <form action="add_user.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Email address</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Password</label>
                              <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                Username 
                                <span class="sort-alpha-down" onclick="sortTable('users', 'username')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                                    </svg>
                                </span>
                            </t>
                            <th scope="col">Email</th>
                            <th scope="col">Logged By Google</t>
                            <th scope="col">Verified</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($users->num_rows > 0): ?>
                            <?php while ($row = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= $row['googleLogin'] ? 'Yes' : 'No' ?></td>
                                    <td><?= $row['account_activation_hash'] ? 'No' : 'Yes' ?></t>
                                    <td>
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="btn btn-danger btn-sm" onclick="deleteRecord('user', <?= $row['userID'] ?>)">Delete</button></li>
                                            <li>
                                                <button class="btn btn-primary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modifyModal" 
                                                        data-type="user"
                                                        data-id="<?= $row['userID'] ?>" 
                                                        data-username="<?= $row['username'] ?>" 
                                                        data-email="<?= $row['email'] ?>">
                                                    Modify
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No Users Found!</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
    
                <div class="admins my-5">
                    <h2 class="my-4">Admin Accounts</h2>
                    <div class="addUser my-5">
                        <form action="add_admin.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                        <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                Username 
                                <span class="sort-icon" onclick="sortTable('admins', 'username')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                                    </svg>
                                </span>
                            </th>
                            <th scope="col">Password</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($admins->num_rows > 0): ?>
                            <?php while ($row = $admins->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['password']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><button class="btn btn-danger btn-sm" onclick="deleteRecord('admin', <?= $row['adminID'] ?>)">Delete</button></li>
                                                <li>
                                                    <button class="btn btn-primary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modifyModal" 
                                                            data-type="admin"
                                                            data-id="<?= $row['adminID'] ?>" 
                                                            data-username="<?= $row['username'] ?>" 
                                                            data-email="<?= $row['email'] ?>" >
                                                        Modify
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No Users Found!</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="products">
            <!--Add Specification Modal-->
            <div class="modal fade" id="addSpecModal" tabindex="-1" aria-labelledby="addSpecModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addSpecModalLabel">Add Specification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="addSpecForm">
                        <div class="mb-3">
                        <label for="specName" class="form-label">Specification Name</label>
                        <input type="text" class="form-control" id="specName" required>
                        </div>
                        <button type="submit" id="saveSpecButton" class="btn btn-primary">Add Specifiaction</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            
            <!--Add Value Modal-->
            <div class="modal fade" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addValueModalLabel">Add Value</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="addSpecForm">
                        <div class="mb-3">
                        <label for="valueName" class="form-label">Value Name</label>
                        <input type="text" class="form-control" id="valueName" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="text" class="form-control" id="stock" required>
                        </div>
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="specificationName" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveValueBtn">Add Value</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>

            <!--Edit Modal-->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" id="editProductForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="productID" id="editProductID">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="editProductName" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editDescription" rows="3" name="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editCategory" class="form-label">Category</label>
                                    <select class="form-select" id="editCategory" name="category"></select>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductImage" class="form-label">Product Image</label>
                                    <input class="form-control" type="file" id="editProductImage" name="productImage">
                                </div>
                                <div class="mb-2">
                                    <label for="editPrice" class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="text" class="form-control" id="editPrice" name="price">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="editDiscountedPrice" class="form-label">Discounted Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="text" class="form-control" id="editDiscountedPrice" name="discountedPrice">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Specifications</label>
                                    <div id="editSpecList" class="row gap-3"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="saveProductChanges(event)">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <h2 class="my-5">Product Management</h2>
                <form method="POST" class="container" id="addProdForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" aria-label="Default select example" name="category">
                            
                        <?php
                            if (!$categories) {
                                error_log("Query Error: " . mysqli_error($conn));
                                echo "<option value=''>No categories available</option>";
                            } else if (mysqli_num_rows($categories) > 0) {
                                while ($row = mysqli_fetch_assoc($categories)) {
                                    $categoryID = htmlspecialchars($row['categoryID'], ENT_QUOTES, 'UTF-8');
                                    $categoryName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                    echo "<option value='{$categoryID}'>{$categoryName}</option>";
                                }
                            } else {
                                echo "<option value=''>No categories available</option>";
                            }                             
                        ?>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="formFile" name="productImage">
                    </div>
                    <div class="mb-2">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">0.00</span>
                            <span class="input-group-text">Rs.</span>
                            <input type="text" class="form-control" name="price" aria-label="Dollar amount (with dot and two decimal places)">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="discountedPrice" class="form-label">Discount Price</label>
                        <div class="input-group">
                            <span class="input-group-text">0.00</span>
                            <span class="input-group-text">Rs.</span>
                            <input type="text" class="form-control" name="discountedPrice" aria-label="Dollar amount (with dot and two decimal places)">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">Specification</label>
                        <button class="btn" id="addSpecBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </button>
                        <div class="mb-2 specificationsForm row gap-3" id="specList">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>

                <div class="container my-5">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div class="row my-5">
                        <?php
                            if (!$products) {
                                error_log("Query Error: " . mysqli_error($conn));
                                echo "<span>No Products Founnd!</span>";
                            } else if (mysqli_num_rows($products) > 0) {
                                while ($row = mysqli_fetch_assoc($products)) {
                                    $productID = htmlspecialchars($row['productID'], ENT_QUOTES, 'UTF-8');
                                    $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                    $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
                                    $categoryID = htmlspecialchars($row['categoryID'], ENT_QUOTES, 'UTF-8');

                                    $categoryQuery = "SELECT * FROM productcategories WHERE categoryID = '$categoryID'";
                                    $categoryResult = mysqli_query($conn, $categoryQuery);

                                    if (!$categoryResult) {
                                        error_log("Category Query Error: " . mysqli_error($conn));
                                        $categoryName = "Unknown Category";
                                    } else if (mysqli_num_rows($categoryResult) > 0) {
                                        $categoryRow = mysqli_fetch_assoc($categoryResult);
                                        $categoryID = htmlspecialchars($categoryRow['categoryID'], ENT_QUOTES, 'UTF-8');
                                        $categoryName = htmlspecialchars($categoryRow['name'], ENT_QUOTES, 'UTF-8');
                                    } else {
                                        $categoryName = "Unknown Category";
                                    }

                                    $specificationQuery = "SELECT * FROM specification WHERE productID = '$productID'";
                                    $specificationResult = mysqli_query($conn, $specificationQuery);

                                    if (!$specificationResult) {
                                        error_log("Specification Query Error: " . mysqli_error($conn));
                                        $specifications = [];
                                    } else {
                                        $specifications = [];
                                        while ($specRow = mysqli_fetch_assoc($specificationResult)) {
                                            $specID = $specRow['specID'];
                                            $specName = htmlspecialchars($specRow['specName'], ENT_QUOTES, 'UTF-8');

                                            $valueQuery = "SELECT * FROM specificationValue WHERE specID = '$specID'";
                                            $valueResult = mysqli_query($conn, $valueQuery);

                                            $values = [];
                                            if ($valueResult && mysqli_num_rows($valueResult) > 0) {
                                                while ($valueRow = mysqli_fetch_assoc($valueResult)) {
                                                    $values[] = [
                                                        'valueID' => $valueRow['valueID'],
                                                        'specValue' => htmlspecialchars($valueRow['specValue'], ENT_QUOTES, 'UTF-8'),
                                                        'stock' => intval($valueRow['stock']),
                                                    ];
                                                }
                                            }

                                            $specifications[] = [
                                                'specID' => $specID,
                                                'specName' => $specName,
                                                'values' => $values,
                                            ];
                                        }
                                    }

                                    $picture = htmlspecialchars($row['picture'], ENT_QUOTES, 'UTF-8');
                                    $price = htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8');
                                    $discountedPrice = htmlspecialchars($row['discountedPrice'], ENT_QUOTES, 'UTF-8');
                                    echo "
                                        <div class='productCard col-lg-3 col-md-4 col-sm-6'>
                                            <div class='adminCard'>
                                                <img src='" . htmlspecialchars($picture, ENT_QUOTES, 'UTF-8') . "' class='card-img-top' alt='Working boot' id='productImage'>
                                                <div class='card-body'>
                                                    <h5 class='card-title name'>" . htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') . "</h5>
                                                    <p class='card-text description'>" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "</p>
                                                    <p class='card-text price'>Rs. " . htmlspecialchars($price, ENT_QUOTES, 'UTF-8') . "</p>
                                                    <p class='card-text discountedPrice'>Rs. " . htmlspecialchars($discountedPrice, ENT_QUOTES, 'UTF-8') . "</p>
                                                    <p class='card-text category'>" . htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') . "</p>
                                    ";

                                    if (!empty($specifications)) {
                                        foreach ($specifications as $spec) {
                                            echo "<p class='card-text specification'>" . htmlspecialchars($spec['specName'], ENT_QUOTES, 'UTF-8') . "</p>";
                                            
                                            if (!empty($spec['values'])) {
                                                foreach ($spec['values'] as $value) {
                                                    echo "<p class='card-text mx-2 my-0 py-0 value'>" . htmlspecialchars($value['specValue'], ENT_QUOTES, 'UTF-8') . "</p>";
                                                }
                                            } else {
                                                echo "<p class='card-text mx-2 my-0 py-0 value'>No values available</p>";
                                            }
                                        }
                                    } else {
                                        echo "<p class='card-text mx-2 my-0 py-0 value'>No specifications available</p>";
                                    }

                                    echo "
                                            </div>
                                            <ul class='list-group list-group-flush'>
                                                <li class='list-group-item center'><button class='btn' onclick='editProduct({$productID})'>Edit</button></li>
                                                <li class='list-group-item center'><button class='btn' onclick='deleteProduct({$productID})'>Delete</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                    ";

                                }
                            } else {
                                echo "<option value=''>No categories available</option>";
                            }
                                        
                        ?>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>

        <div class="tab-pane fade" id="paints">
            <div>
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="tab" href="#paintCategories">Paint Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-bs-toggle="tab" href="#paintList">Paint List</a>
                    </li>
                </ul>

                <div class="tab-content mt-3 section container">
                    <div class="tab-pane fade" id="paintCategories">
                        <h2 class="my-3">Add Category</h2>
                        <form action="add_user.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</th>
                                <td>Name</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>

                    <div class="tab-pane fade active show" id="paintList">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Color Name</th>
                                <th scope="col">Color Code</th>
                                <th scope="col">Category</th>
                                <th scope="col">Details</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Wine Red</th>
                                <td>1238sd8</td>
                                <td>Wall Paint</td>
                                <td>
                                    <ul>
                                        <li>Nippon Paint - 5 litres - available</li>
                                        <li>Nippon Paint - 1 litres - available</li>
                                    </ul>
                                </td>
                                <td class="gap-1">
                                    <button class="btn btn-primary my-2">Edit details</button><br>
                                    <button class="btn btn-primary my-2">Delete</button>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="quotations">
            <div class="container my-5">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">orderID</th>
                        <th scope="col">UserID</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Products</th>
                        <th scope="col">Grand Total</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>2024-06-26</td>
                        <td>
                            <ul>
                                <li>Working Boots - x2 - Rs.8000</li>
                                <li>Working Boots - x2 - Rs.8000</li>
                                <li>Working Boots - x2 - Rs.8000</li>
                            </ul>
                        </td>
                        <td>Rs. 24000</td>
                        <td class="gap-1">
                            <button class="btn btn-primary my-2">Make Quotation</button><br>
                            <button class="btn btn-primary my-2">View All Details</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>

        <div class="tab-pane fade" id="orders">
            <div class="container my-5">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">OrderID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Change Status</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Normal</td>
                        <td>pending</td>
                        <td class="row gap-2 p-4">
                            <button class="btn btn-primary col-lg-6 col-md-6 col-sm-12" style="max-width: 125px;">Pending</button>
                            <button class="btn btn-primary col-lg-6 col-md-6 col-sm-12" style="max-width: 125px;">Accepted</button>
                            <button class="btn btn-primary col-lg-6 col-md-6 col-sm-12" style="max-width: 125px;">Shipped</button>
                            <button class="btn btn-primary col-lg-6 col-md-6 col-sm-12" style="max-width: 125px;">Finished</button>
                            <button class="btn btn-primary col-lg-6 col-md-6 col-sm-12" style="max-width: 125px;">Cancelled</button>
                        </td>
                        <td>
                            <button class="btn btn-primary">View All Details</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
      </div>

      <!-- Alert Modal -->
      <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alertModalMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="alertModalOkButton" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
      </div>

      
</body>
</html>