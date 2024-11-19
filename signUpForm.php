<?php
    include 'connect.php';
     
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkUsername = "SELECT * FROM users WHERE username=? and googleLogin=0";
    $stmt = $conn->prepare($checkUsername);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        $checkGoogle = "SELECT * FROM users WHERE username=? AND googleLogin=1";
        $stmt = $conn->prepare($checkGoogle);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Delete the matching record
            $deleteQuery = "DELETE FROM users WHERE username=? AND googleLogin=1";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param('s', $username);

            if ($deleteStmt->execute()) {
                
            } else {
                echo "Cannot migrate the user to google" . $conn->error;
                die();
            }
        } else {
            echo "No matching record found.";
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $googleLogin = 0;

        $activation_token = bin2hex(random_bytes(16));
        $activation_token_hash = hash("sha256", $activation_token);

        $sql = "INSERT INTO users (username, email, password, account_activation_hash, googleLogin)
        VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL error: " . $conn->error);
        }

        $stmt->bind_param(
            "ssssi",
            $username,
            $email,
            $password_hash,
            $activation_token_hash,
            $googleLogin
        );
                        
        if ($stmt->execute()) {

            $mail = require __DIR__ . "/mailer.php";

            $mail->setFrom("info.steelandstones@gmail.com");
            $mail->addAddress($email);
            $mail->Subject = "Account Activation";
            $mail->Body = <<<END

            <h1>Steel And Stones</h1><br>
            <h3>Account activation</h3>
            Click <a href="http://localhost/SteelAndStones/activate-account.php?token=$activation_token">here</a> 
            to activate your account.

            END;

            try {
                $mail->send();
                header("Location: signUp.php?message=verifyMail");
                exit;
            } catch (Exception $e) {

                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                exit;
            }
            
        } else {
            if ($mysqli->errno === 1062) {
                die("email already taken");
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }
    }