<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $province = htmlspecialchars($_POST['province']);

    
    echo "<h1>Order Received</h1>";
    echo "<p>Thank you, $name!</p>";
    echo "<p>Your order will be delivered to:</p>";
    echo "<p>$address, $province</p>";
    echo "<p>We will contact you at $phone for confirmation.</p>";
    echo '<a href="order.php">Go Back</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Summary</title>
  <link rel="stylesheet" href="css/cart.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="cart.css">
                <img src="logo-no-background 1.jpg" alt="" style="height: 40px;">
            </a>
            
                        <a class="nav-link" href="#">Category</a>
                        <button>
                        <img src="mingcute_down-fill.jpg" alt="arrow" class="arrow_one" width="20" href/>
            </button>

                        <a class="nav-link" href="order list.css">Contact us</a>
                    
                        <img src="search.jpg" alt="search" class="search" width="180"/> 
                    
                        <img src="Vector.jpg" alt="buy" class="buy" width="25">
                    
                        <a class="nav-link" href="order list.css"><i class="bi bi-cart"></i></a>
                    
                        <a class="nav-link" href="order list.css"><i class="bi bi-person"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


  <div class="container my-5">
    
    <div class="row">
      <div class="col-12">
        <h3 class="mb-4">Your Order List</h3>
      </div>

      
      <div class="row order-list">
        
        <div class="col-md-4">
          <div class="card">
            <img src="sovel.jpg" class="card-img-top" alt="Shovel">
            <div class="card-body">
              <h5>Shovel</h5>
              <p>Category: Gardening Tool</p>
              <p>Price: Rs. 4,500</p>
              <p>Quantity: 1</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card">
            <img src="hammer.jpg" class="card-img-top" alt="Hammer">
            <div class="card-body">
              <h5>Hammer</h5>
              <p>Category: Tools</p>
              <p>Price: Rs. 1,800</p>
              <p>Quantity: 1</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card">
            <img src="cement.jpg" class="card-img-top" alt="Cement">
            <div class="card-body">
              <h5>Cement</h5>
              <p>Category: Construction Materials</p>
              <p>Price: Rs. 5,500</p>
              <p>Quantity: 1</p>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    
    <div class="row mt-5">
      <div class="col-md-6">
        <div class="delivery-info">
          <h4>Delivery Info</h4>
          <form>
            <div class="mb-3">
              <label for="fullName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullName">
            </div>
            <div class="mb-3">
              <label for="contact" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="contact">
            </div>
            <div class="mb-3">
              <label for="province" class="form-label">Province</label>
              <select class="form-select" id="province">
                <option selected>Select Your Province</option>
                <option value="1">Province 1</option>
                <option value="2">Province 2</option>
                <option value="3">Province 3</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Confirm Address</label>
              <input type="text" class="form-control" id="address">
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="order-summary">
          <h4>Order Summary</h4>
          <ul class="list-group">
            <li class="list-group-item">Total Items: 6</li>
            <li class="list-group-item">Total Amount: Rs. 11,800</li>
            <li class="list-group-item">Delivery Fee: Free</li>
            <li class="list-group-item"><strong>Grand Total: Rs. 13,650</strong></li>
          </ul>
          <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-danger">Cancel</button>
            <button class="btn btn-success">Place Order</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
