<?php

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username='$username' and password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: adminPanel.php?message=userFound");
    } else {
        $sql = "INSERT INTO users (username, email, password)
        VALUES (?, ?, ?)";

        $stmt = $conn->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL error: " . $conn->error);
        }

        $stmt->bind_param(
            "ssssi",
            $username,
            $email,
            $password_hash,
        );
                        
        if ($stmt->execute()) {
            header("Location:adminPanel?message=userAdded");
        } else {
            if ($mysqli->errno === 1062) {
                die("User Already Exists!");
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }
    }