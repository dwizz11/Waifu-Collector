<?php 

  //MySQLi or PDO

   //MySQLi
  //connect to database

  $conn = mysqli_connect('localhost', 'deathwizz11', 'deathwizz11', 'waifus');
  // (nama host, nama user, password user, nama database)

  // check connection

  if(!$conn){
    echo 'connection error :' . mysqli_connect_error(); // ini buat nge check apakah ada error tertentu, jadi misal kita salah masukin password, nama user, nama database. Nanti errornya bakal di generate sendiri sama function mysqli_connect_error()
  }

?>