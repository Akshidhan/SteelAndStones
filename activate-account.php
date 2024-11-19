<?php
    include 'connect.php';

    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    $sql = "SELECT * FROM users
            WHERE account_activation_hash = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    $sql = "UPDATE users
            SET account_activation_hash = NULL
            WHERE userID = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $user["userID"]);

    $stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Activated</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <meta http-equiv="refresh" content="3;url=signIn.php">

</head>
<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="wrapper gap-3 d-flex justify-content-center align-items-center flex-column">
            <h1>Account Activated!</h1>
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h4>Redirecting to Login Page...</h4>
        </div>
    </div>

</body>
</html>