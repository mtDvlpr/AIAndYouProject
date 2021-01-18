<?php
  include "connect.php";

  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  $usname = mysqli_real_escape_string($mysql,$_POST["usname"]);$usname = lcfirst($usname);
  $pass = mysqli_real_escape_string($mysql,$_POST["pass"]);$pass = crypt($pass,'$6$aiandyou$');

  $result = mysqli_query($mysql,"SELECT * FROM users WHERE username= BINARY'".$usname."' AND password= BINARY'".$pass."'") or die("Error: Selecting the users has failed.");
  $countUser = mysqli_fetch_assoc($result);
 
  if($countUser > 0) {
    mysqli_query($mysql,"DELETE FROM users WHERE username = '".$usname."'") or die("Error: The removal of your account has failed.");
    mysqli_query($mysql,"DELETE FROM usersBackup WHERE username = '".$usname."'") or die("Error: The removal of your account has failed.");
    include "logout.php";
  }
  else { 
    echo'<p class="error"><i class="fa fa-times-circle"></i> Your given username and password do not match.</p>';
  } 
  mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
?>