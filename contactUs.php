<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    
    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            $to = "support@steelandstones.com"; 
            $subject = "New Contact Form Submission from $name";
            $body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                echo "Message sent successfully!";
            } else {
                echo "Failed to send the message. Please try again.";
            }
        } else {
            echo "Invalid email format.";
        }
    } else {
        echo "All fields except phone number are required.";
    }
} else {
    echo "Invalid request method.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
    <link rel="stylesheet" href="contactUs.css">
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

    <div class="container-fluid">

        <main class="contact-section">
            <center</center>
            <img src="contect.jpg" alt="contect" width="1100">
        
            <div class="row g-0">
                <div class="col-md-6 p-5">
                    <h2>Contact Us</h2>
                    <p>Let’s talk with us</p>
                    <p>
                        Questions, comments, or suggestions? Simply fill in the form and we’ll be in touch shortly.
                    </p>
                    <ul class="list-unstyled">
                        <li><strong>Address:</strong> No.456, Galle Main Road, Colombo - 06</li>
                        <li><strong>Phone:</strong> (123) 456-7890</li>
                        <li><strong>Email:</strong> support@steelandstones.com</li>
                    </ul>
                </div>
                <div class="col-md-6 bg-light p-5">
                    <form ac>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Write your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
