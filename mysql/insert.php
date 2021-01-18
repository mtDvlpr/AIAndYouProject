<?php
  include "connect.php";

  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  $usname = mysqli_real_escape_string($mysql,$_POST["usname"]);$usname = ucfirst($usname);
  $pass = mysqli_real_escape_string($mysql,$_POST["pass"]);$cryptpass = crypt($pass,'$6$aiandyou$');
  $fname = mysqli_real_escape_string($mysql,$_POST["fname"]);$fname = ucfirst($fname);
  $prep = mysqli_real_escape_string($mysql,$_POST["prep"]);$prep = lcfirst($prep);
  $lname = mysqli_real_escape_string($mysql,$_POST["lname"]);$lname = ucfirst($lname);
  $email = mysqli_real_escape_string($mysql,$_POST["email"]);

  $result = mysqli_query($mysql,"SELECT * FROM users WHERE username='".$usname."'") or die("Error: Selecting the users has failed.");
  $countUser = mysqli_fetch_assoc($result);

  $result = mysqli_query($mysql,"SELECT * FROM users WHERE email='".$email."'") or die("Error: Selecting the users has failed.");
  $countEmail = mysqli_fetch_assoc($result);
 
  if($countUser > 0) {
    echo'<p class="error"><i class="fa fa-times-circle"></i> Your username is already taken.</p>';
  }
  elseif($countEmail > 0) {
    echo'<p class="error"><i class="fa fa-times-circle"></i> Your email address is already taken.</p>';
  }
  else { 
    mysqli_query($mysql,"INSERT INTO usersBackup (username,password,email) VALUES('".$usname."','".$pass."','".$email."')") or die("Error: Inserting the backup user has failed.");	
    $hash = md5(rand(0,1000));$about = "This person has not provided an about me yet.";
    mysqli_query($mysql,"INSERT INTO users (username,password,firstName,preposition,lastName,email,about,hash) VALUES('".$usname."','".$cryptpass."','".$fname."','".$prep."','".$lname."','".$email."','".$about."','".$hash."')") or die("Error: Inserting the user has failed.");	
    mail("$email","Account verification","Dear $fname,\n\nThank you for creating an account!\n\nClick this link to activate your account:\nhttp://www.aiandyou.csgja.com/verify?email=$email&hash=$hash\n\nKind regards,\n\n\nThe AI And You team",'From:noreply@aiandyou.csgja.com');
    echo"<p class='success'><i class='fa fa-check'></i> Your account has been succesfully made. Verify it by clicking the activation link that has been sent to $email.</p>";
  } 
  mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
?>