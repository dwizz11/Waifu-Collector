<?php

$email = $_SESSION['email'];
$password = $_SESSION['password'];

$sql_name = "SELECT UserName FROM user WHERE UserEmail = '$email' AND UserPassword = '$password' ";

$result = mysqli_query($conn, $sql_name);

$temp = mysqli_fetch_assoc($result);

// print_r($temp);

// echo $temp['UserName'];

$username = $temp;

if($result->num_rows == 1){
  
  $username = $temp['UserName'];
}

?>