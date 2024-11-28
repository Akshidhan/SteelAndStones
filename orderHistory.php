<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="orderHistory.css">
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

    
    <div class="container mt-4">
        
        <h1 class="mb-4">Order History</h1>
        
        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">All Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Summary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Cancelled</a>
            </li>
        </ul>

        
        <div class="order-history mt-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Payment</th>
                        <th>Time remaining</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#7801</td>
                        <td>Mario</td>
                        <td>Cash</td>
                        <td><i class="bi bi-clock"></i> 35 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 18,967</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    
                    <tr>
                        <td>#5010</td>
                        <td>madhushan</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 21,540</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#1021</td>
                        <td>Saranika</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 48,240</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#5487</td>
                        <td>akshidhan</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 147.47</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#5623</td>
                        <td>brundha</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 17,</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#4566</td>
                        <td>charushan</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 19,890</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#1564</td>
                        <td>sowmeya</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 35,542</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    <tr>
                        <td>#8632</td>
                        <td>kavinas</td>
                        <td>Paid</td>
                        <td><i class="bi bi-clock"></i> 45 Min</td>
                        <td class="type-delivery">Delivery</td>
                        <td class="status-delivered">Delivered</td>
                        <td>Rs. 24,960</td>
                        <td><i class="bi bi-three-dots action-icon"></i></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
