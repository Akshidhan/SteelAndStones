<?php

include 'connect.php';

if(isset($_POST['submitBtn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username='$username' and password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if($user['account_activation_hash'] = NULL){
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION['userID'] = $row["userID"];
            header('Location: index.html');
        }
        else{
            header("Location: signIn.php?message=notVerified");
        }
    } else {
        header('Location: login.html');
        exit();
    }
}

?>