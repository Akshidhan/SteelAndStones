<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "steelandstones";

$conn = mysqli_connect($hostname, $username, $password, $database);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}