<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Verify account - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/verify.css">
  </head>
  <body>
    <?php include "../header.html";?>

    <?php include "../menu.html";?>
    
    <div>
      <h2><?php 
  if(isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
    if(isset($_POST["verify"])) {
      include "../../mysql/connect.php";

      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

      $email = mysqli_real_escape_string($mysql,$_GET['email']);
      $hash = mysqli_real_escape_string($mysql,$_GET['hash']);

      $result = mysqli_query($mysql,"SELECT * FROM users WHERE email='$email' AND hash='$hash'") or die("The selection of the account has failed.");
      $countUser = mysqli_fetch_assoc($result);

      if($countUser > 0) {
        mysqli_query($mysql,"UPDATE users SET active='1',hash='' WHERE email='".$email."' AND hash='$hash' AND active='0'") or die("The activation of the account has failed.");
        echo 'Your account has been activated, you can now log in.';
      }
      else {
        $result = mysqli_query($mysql,"SELECT * FROM users WHERE email='$email' AND active='1'") or die("The selection of the account has failed.");
        $countUser = mysqli_fetch_assoc($result);
        
        if($countUser > 0){echo"Your account is already activated.";}
        else{echo"The user was not found. Make sure you have the right url.";}
      }
      mysqli_close($mysql) or die("The closing of the server connection has failed.");
    }
    else {
      echo'Click<form method="post"><input type="submit" name="verify" class="linkButton" value="here"></form>to activate your account.';
    } 
  }
  else {echo"You have inserted an invalid url.";}
?></h2> 
    </div>
    <?php include "../footer.html";?>
  </body>
</html>