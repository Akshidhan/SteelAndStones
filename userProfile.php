<?php
  session_start();

  require_once 'connect.php';

  if (!isset($_SESSION['userID'])) {
      header('Location: login.php');
      exit();
  }

  $userID = $_SESSION['userID'];
  $sql = "SELECT * FROM users WHERE userID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $userID);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if (!$user) {
      session_destroy();
      header('Location: signIn.php');
      exit();
  }

  $profilePic = !empty($user['profilePic']) ? $user['profilePic'] : 'path/to/default/profile-pic.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steel And Stones - Account Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
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
                </ul>
              </li>
            </ul>
            <form class="d-flex justify-content-between" role="search" style="width: 40%;max-width: 350px;">
              <div class="search">
                <button class="btn" type="submit"><img src="files/icons/search.svg" alt=""></button>
                <input class="searchInput" type="search" placeholder="Search" aria-label="Search">
              </div>
              <button class="navIcon"><img src="files/icons/cart.svg" alt="cart"></button>
              <button class="navIcon"><img src="files/icons/user.svg" alt="cart"></button>
            </form>
          </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1>Account Settings</h1>
        <div class="accountContainer p-4 gap-4">
            <h2>Edit Profile</h2>
            <div class="profileSection d-flex justify-content-between align-items-center sections p-2">
                <div id="userDetails" class="d-flex flex-row align-items-center gap-3">
                    <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profilePic">
                    <span id="username"><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <div class="Editbutton flex-end">
                    <button class="btn btn-edit">Edit <img src="files/icons/edit.svg" alt="editIcon"></button>
                </div>
            </div>
            <div class="sections p-4 my-3 position-relative">
                <h5>Personal Information</h5>
                <div class="Editbutton position-absolute editPosition">
                    <button class="btn btn-edit">Edit <img src="files/icons/edit.svg" alt="editIcon"></button>
                </div>
                <div class="details row">
                    <div class="col-lg-4 p-3 col-mg-4 col-sm-6 d-flex flex-column">
                        <span class="info">Username</span>
                        <span class="data"><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <div class="col-lg-4 p-3 col-mg-4 col-sm-6 d-flex flex-column">
                        <span class="info">Email Address</span>
                        <span class="data"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button class="btn btn-option">Address Book</button>
                <button class="btn btn-option">Order History</button>
                <button class="btn btn-option">Quotation Requests</button>
            </div>
        </div>
    </div>
</body>
</html>
