<?php
    include 'connect.php';

    session_start();

    $userID = $_SESSION['userID'];
    $productID = $_GET['productID'];
    $specification;

    $productQuery = "SELECT * FROM Product WHERE productID = $productID";
    $productResult = $conn->query($productQuery);
    if ($productResult->num_rows==1){
        $product = mysqli_fetch_assoc($productResult);
    }
    

    $specificationQuery = "SELECT * FROM specification WHERE productID = $productID";
    $specificationResult = $conn->query($specificationQuery);
    if ($specificationResult->num_rows==1){
        $specification = mysqli_fetch_assoc($specificationResult);
    } else{
        $specification['specName']='Default';
    }

    $valueQuery = "
        SELECT *
        FROM specificationvalue sv
        JOIN specification s ON sv.specID = s.specID
        WHERE s.productID = $productID
    ";
    $valueResult = $conn->query($valueQuery);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $action = $data['action'];
        $userID = $_SESSION['userID'];
        $productID = $data['productID'];

        if ($action === 'add') {
            $insertWishlist = "INSERT INTO wishlistitem (userID, productID) VALUES (?, ?)";
            $stmt = $conn->prepare($insertWishlist);
            $stmt->bind_param("ii", $userID, $productID);
            $stmt->execute();

            echo json_encode(['success' => $stmt->execute()]);
            exit;
        } elseif ($action === 'remove') {
            $deleteItemsQuery = "DELETE FROM wishlistitem where userID = ? AND productID = ?";
            $stmt = $conn->prepare($deleteItemsQuery);
            $stmt->bind_param("ii", $userID, $productID);
            $stmt->execute();

            echo json_encode(['success' => $stmt->execute()]);
            exit;
        }
    }

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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <script src = "js/owl.carousel.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/index.js"></script>
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
                  <li><a class="dropdown-item" href="#">Construction Materials</a></li>
                  <li><a class="dropdown-item" href="#">Tools</a></li>
                  <li><a class="dropdown-item" href="#">Paints and Finishing</a></li>
                  <li><a class="dropdown-item" href="#">Fasteners and Fittings</a></li>
                  <li><a class="dropdown-item" href="#">Electric Supplies</a></li>
                  <li><a class="dropdown-item" href="#">Plumbing Supplies</a></li>
                  <li><a class="dropdown-item" href="#">Safety Equipments</a></li>
                  <li><a class="dropdown-item" href="#">Gardening Tools</a></li>
                  <li><a class="dropdown-item" href="#">Woodworking Supplies</a></li>
                  <li><a class="dropdown-item" href="#">Miscellaneous</a></li>
                  <li><a class="dropdown-item" href="#">All</a></li>
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

    <div class="vh-90 d-flex justify-content-center align-items-center">
        <div class="itemContainer p-3">
            <img src="files/icons/ic_round-arrow-back.svg" alt="Back Arrow" class="mb-3">
            <div class="content">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <img src="<?php echo $product['picture'] ?>" alt="" class="w-100 rounded productImage">
                    </div>
                    <div class="d-flex justify-content-center align-items-center col-lg-7 col-md-7 col-sm-12">
                        <form id="addToCartForm">
                            <div class="prodContent d-flex flex-column justify-content-center align-items-center p-4 gap-5">
                                <div>
                                        <div class="d-flex justify-content-between w-100">
                                            <span class="ProdName"><?php echo $product['name'] ?></span>
                                            <span id="wishList">
                                            <?php
                                                $wishlistCheckQuery = "SELECT * FROM wishlistitem WHERE userID = ? AND productID = ?";
                                                $stmt = $conn->prepare($wishlistCheckQuery);
                                                $stmt->bind_param("ii", $userID, $productID);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                if ($result->num_rows > 0) {
                                                    echo '<img src="files/icons/wishlist-filled.svg" alt="wishlist icon" onclick="removeWishList(' . $productID . ')">';
                                                } else {
                                                    echo '<img src="files/icons/wishlist.svg" alt="wishlist icon" onclick="addWishList(' . $productID . ')">';
                                                }
                                            ?>
                                            </span>
                                        </div>
                                        <div class="ProdDescription w-100"><?php echo $product['description'] ?></div>
                                        <div class="specification mt-3">
                                            <?php if ($specification['specName'] == 'Default'): ?>
                                                <input type="text" name="specID" value="<?php echo htmlspecialchars($specification['specID']); ?>" class="d-none">
                                                <?php if ($valueResult->num_rows > 0): ?>
                                                    <?php $row = $valueResult->fetch_assoc();?>
                                                    <input type="radio" class="btn-check valueCheck d-none" name="valueID" autocomplete="off" value="Default" checked>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            resetQuantity(<?php echo htmlspecialchars($row['valueID']); ?>, <?php echo htmlspecialchars($row['stock']); ?>);
                                                            printQuantity();
                                                        });
                                                    </script>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <input type="text" name="specID" value="<?php echo htmlspecialchars($specification['specID']); ?>" class="d-none">
                                                <span class="specName"><?php echo htmlspecialchars($specification['specName']); ?></span>
                                                <div class="values">
                                                    <?php if($valueResult->num_rows > 0): ?>
                                                        <?php while($row = $valueResult->fetch_assoc()): ?>
                                                            <input type="radio" class="btn-check valueCheck" name="valueID" id="<?= htmlspecialchars($row['valueID']); ?>" autocomplete="off" 
                                                                onclick="resetQuantity(<?= htmlspecialchars($row['valueID']); ?>, <?= htmlspecialchars($row['stock']); ?>)" 
                                                                value="<?= htmlspecialchars($row['valueID']); ?>" 
                                                                <?php if ($row['stock'] == 0) { echo "disabled"; } ?>>
                                                            <label class="btn btn-outline-secondary" for="<?= htmlspecialchars($row['valueID']); ?>">
                                                                <?= htmlspecialchars($row['specValue']); ?>
                                                            </label>
                                                        <?php endwhile; ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between w-100 cartActions">
                                    <div class="quantity d-inline p-1">
                                        <button class="btn" onclick="increaseCartItem(event)">+</button>
                                        <span id="quantity"></span>
                                        <button class="btn" onclick="decreaseCarItem(event)">-</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-atc">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        const alertMessageElement = document.getElementById('alertModalMessage');
        const alertOkButton = document.getElementById('alertModalOkButton');

        const addToCart = document.getElementById('addToCartForm');

        var quantity = 0;
        var quantitySpan = document.getElementById('quantity');
        var wishlistIcon = document.getElementById('wishList');
        var value;
        var stock;

        printQuantity();
        
        window.showAlert = (message, reload = false) => {
            alertMessageElement.textContent = message;
            alertModal.show();

            alertOkButton.onclick = () => {
                if (reload) location.reload();
            };
        };

        function printQuantity(){
            quantitySpan.innerHTML = quantity;
        }

        printQuantity();
    
        function resetQuantity(value, stock){
            quantity = 0;
            this.value = value;
            this.stock = stock;
        }

        function increaseCartItem(event){
            event.preventDefault();
            if (value){
                if (quantity<stock){
                    quantity++;
                    printQuantity();
                } else {
                    showAlert("Stock limit reached!");
                }
            } else {
                showAlert("Please select a valid specification first!");
            }
        }

        function decreaseCarItem(event){
            event.preventDefault();
            if (quantity > 0) {
                quantity--;
                printQuantity();
            } else {
                showAlert("Cannot decrease below zero!");
            }
        }

        function addWishList(productID) {
            fetch(window.location.href, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'add', productID: productID })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('wishList').innerHTML = 
                        '<img src="files/icons/wishlist-filled.svg" alt="wishlist icon" onclick="removeWishList(' + productID + ')">';
                } else {
                    alert('Error adding to wishlist.');
                }
            })
            .catch(err => console.error('Error:', err));
        }

        function removeWishList(productID) {
            fetch(window.location.href, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'remove', productID: productID })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('wishList').innerHTML = 
                        '<img src="files/icons/wishlist.svg" alt="wishlist icon" onclick="addWishList(' + productID + ')">';
                } else {
                    alert('Error removing from wishlist.');
                }
            })
            .catch(err => console.error('Error:', err));
        }

        function addToCartData(event) {
            event.preventDefault();

            const formData = new FormData(addToCartForm);

            formData.append('userID', <?php echo $userID; ?>);
            formData.append('productID', <?php echo $productID; ?>);
            formData.append('quantity', quantity);

            const data = Object.fromEntries(formData.entries());

            fetch("add_to_cart.php", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert("Item added to cart successfully!");
                    location.reload();
                } else {
                    showAlert("Failed to add item to cart.");
                }
            })
            .catch(err => {
                console.error("Error:", err);
            });
        }

        addToCartForm.addEventListener('submit', addToCartData);
    </script>
</body>
</html>