<?php
  include "connect.php";

  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  $usname = mysqli_real_escape_string($mysql,$_POST["usname"]);$usname = lcfirst($usname);
  $email = mysqli_real_escape_string($mysql,$_POST["email"]);

  $result = mysqli_query($mysql,"SELECT * FROM users WHERE username='".$usname."' AND email='".$email."'") or die("Error: Selecting the users has failed.");
  $countUser = mysqli_fetch_assoc($result);
 
  if($countUser > 0) {
    $query = mysqli_query($mysql,"SELECT password FROM usersBackup WHERE username='".$usname."'") or die("Error: The selection of the admin level has failed.");
    $password = mysqli_fetch_all($query,MYSQLI_ASSOC);
    $pass= $password[0]["password"];
    
    mail("$email","Forgot password","Dear $usname,\n\nYour password is: $pass. You can always change your password in the 'your account' section.\n\nPS. If you did not forget your password, you can ignore this email.\n\nKind regards,\n\n\nThe AI And You team",'From:noreply@aiandyou.csgja.com');
    echo'<p class="success"><i class="fa fa-check"></i> An email, containing your password, has been sent to you.</p>';
  }
  else { 
    echo'<p class="error"><i class="fa fa-times-circle"></i> Your given username and email address do not match.</p>';
  } 
  mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
?>