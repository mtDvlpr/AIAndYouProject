<?php
  session_start();
  if(isset($_POST["search"])) {
    include "connect.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    
    $username = $_POST["search"];
    $usname = $_SESSION["username"];
    
    $result = mysqli_query($mysql,"SELECT username FROM users WHERE username LIKE '$username%' AND active='1' AND NOT (username='admin' OR username='$usname') LIMIT 5") or die("Error: The selection of the search results has failed.");
    
    while(list($username) = mysqli_fetch_row($result)) {
      $usernameLowercase = strtolower($username);
      echo"<a href='/visit?u=$usernameLowercase'>$username</a>";
    }
    mysqli_close($mysql) or die("Error: connection could not be interupted.");
  }
?>