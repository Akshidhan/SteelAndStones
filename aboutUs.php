<?php

include 'connect.php';


$sql = "SELECT * FROM about_us LIMIT 1";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $mission = $row['mission'];
    $commitment = $row['commitment'];
    $description = $row['description'];
    $image1 = $row['image1'];
    $image2 = $row['image2'];
    $image3 = $row['image3'];
} else {
    echo "No content available.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
    <link rel="stylesheet" href="css/aboutUs.css">
</head>
<body>
    <div class="container-fluid">
        <header class="bg-light py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h1 class="h5">Steel and Stones</h1>
                </div>
                <nav>
                    <ul class="list-unstyled d-flex gap-3 mb-0">
                        <li><a href="#" class="text-decoration-none">Category</a></li>
                        <li><a href="#" class="text-decoration-none">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="about-section py-5">
            <div class="row align-items-center g-5">
                
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>
                        Welcome to Steel and Stones, your trusted partner for all your hardware needs. Established in 2024, we are proud to serve our community with a wide selection of top-quality tools, materials, and expert advice for projects big and small.
                    </p>
                    <h4>Our Mission</h4>
                    <p>
                        At Steel and Stones, our mission is to empower professionals, DIY enthusiasts, and homeowners with the best products and services to achieve their goals.
                    </p>
                    <h4>Our Commitment</h4>
                    <p>
                        We believe in building lasting relationships with our customers by offering exceptional service, fair pricing, and expertise you can count on.
                    </p>
                    <center>
                    <p class="mt-4">
                        Thank you for choosing Steel and Stones. Let’s build something great together!
                    </p>
                    </center>
                    <button type="submit" class="btn btn-success w-50">learn more</button>
                
                </div>
                
                
                <div class="col-md-6 text-center">
                    <div class="row g-3">
                        <div class="col-6">
                            <img src="about us 1.jpg" alt="about us 1" width="240" >
                        </div>
                        <div class="col-6 py-3 px-4" >
                            <img src="about us 2.jpg" alt="about us 2" width="250" >
                        </div>
                        <div class="col-12 mt-3">
                            <img src="about us 3.jpg" alt="about us 3" width="250" >
                        
                           
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
