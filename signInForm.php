<?php

include 'connect.php';

if(isset($_POST['submitBtn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username='$username' and password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['account_activation_hash'] = NULL){
            session_start();
            $_SESSION['userID'] = $row["userID"];
            header('Location: index.html');
        }
        else{
            header("Location: signIn.php?message=notVerified");
        }
    } else {
        $sql = "SELECT * FROM admin WHERE username='$username' and password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['adminID'] = $row['adminID'];
            header("Location: adminPanel.php");
        } else {
            header("Location: signIn.php?message=notFound");
        }

    }
}

?>