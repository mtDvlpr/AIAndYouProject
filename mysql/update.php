<?php 
  session_start();$usname=$_SESSION["username"];

  include "connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: Connection to the database could not be established.");

  $newFirstName = mysqli_real_escape_string($mysql,$_POST["firstname"]);$newFirstName = ucfirst($newFirstName);
  $newPrep = mysqli_real_escape_string($mysql,$_POST["prep"]);$newPrep = lcfirst($newPrep);
  $newLastName = mysqli_real_escape_string($mysql,$_POST["lastname"]);$newLastName = ucfirst($newLastName);
  $newEmail = mysqli_real_escape_string($mysql,$_POST["email"]);
  $backupPassword = mysqli_real_escape_string($mysql,$_POST["newpass"]);
  $newPassword = crypt($_POST["newpass"], '$6$aiandyou$');
  $newAbout = mysqli_real_escape_string($mysql,$_POST["about"]);
  $gender = mysqli_real_escape_string($mysql,$_POST["gender"]);
  $prefM = mysqli_real_escape_string($mysql,$_POST["preferenceM"]);
  $prefW = mysqli_real_escape_string($mysql,$_POST["preferenceW"]);
  $picName = basename($_FILES["pic"]["name"]);

  if (!empty($newFirstName)) {
    if(!preg_match("/^[a-zA-Z ]*$/",$newFirstName)) {$msg1 = '<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid name.</p>';}
    else {
      mysqli_query($mysql,"UPDATE users SET firstname='$newFirstName' WHERE username = '$usname'");
      $msg2 = '<p class="success"><i class="fa fa-check"></i> Your name was succesfully updated.</p>';
      $_SESSION["name"] = $newFirstName;
    }
  }

  if (!empty($newPrep)) {
    if(!preg_match("/^[a-zA-Z ]*$/",$newPrep)) {$msg1 = '<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid name.</p>';}
    else {
      mysqli_query($mysql,"UPDATE users SET preposition='$newPrep' WHERE username = '$usname'");
      $msg2 = '<p class="success"><i class="fa fa-check"></i> Your name was succesfully updated.</p>';
      $_SESSION["prep"] = $newPrep;
    }
  } 

  if (!empty($newLastName)) {
    if(!preg_match("/^[a-zA-Z ]*$/",$newLastName)) {$msg1 = '<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid name.</p>';}
    else {
      mysqli_query($mysql,"UPDATE users SET lastname='$newLastName' WHERE username = '$usname'");
      $msg2 = '<p class="success"><i class="fa fa-check"></i> Your name was succesfully updated.</p>';
      $_SESSION["lname"] = $newLastName;
    }
  }

  if (!empty($newEmail)) {
    
    $result = mysqli_query($mysql,"SELECT * FROM users WHERE email='".$newEmail."'") or die("Error: Selecting the users has failed.");
    $countEmail = mysqli_fetch_assoc($result);
    
    function is_valid_mail($mail) {
      $mail_domains_ko = array('gmail.com','live.nl','ja.nl','jamail.nl','outlook.com','hotmail.com','mac.com','icloud.com','me.com','yahoo.com','msn.com','googlemail.com');
      foreach($mail_domains_ko as $ko_mail) {
        list(,$mail_domain) = explode('@',$mail);
        if(strcasecmp($mail_domain, $ko_mail) == 0){
          return true;
        }
      }
      return false;
    }
    
    if($countEmail > 0) {$msg3 = '<p class="error"><i class="fa fa-times-circle"></i> Your email address is already taken.</p>';}
    elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL) or !is_valid_mail($newEmail)) {
      $msg3 = '<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid email address.</p>';
    }
    else {
      mysqli_query($mysql,"UPDATE users SET email='$newEmail' WHERE username = '$usname'");
      mysqli_query($mysql,"UPDATE usersBackup SET email='$newEmail' WHERE username = '$usname'");
      $msg3 = '<p class="success"><i class="fa fa-check"></i> Your email address was succesfully updated.</p>';
    }
  }

  if (!empty($backupPassword)) {
    mysqli_query($mysql,"UPDATE users SET password='$newPassword' WHERE username = '$usname'");
    mysqli_query($mysql,"UPDATE usersBackup SET password='$backupPassword' WHERE username = '$usname'");
    $msg4 = '<p class="success"><i class="fa fa-check"></i> Your password was succesfully updated.</p>';
  }

  if (!empty($newAbout)) {
    mysqli_query($mysql,"UPDATE users SET about='$newAbout' WHERE username = '$usname'");
    $msg5 = '<p class="success"><i class="fa fa-check"></i> Your additional information was succesfully updated.</p>';
  }

  if (!empty($gender)) {
    mysqli_query($mysql,"UPDATE users SET gender='$gender' WHERE username = '$usname'");
    $msg5 = '<p class="success"><i class="fa fa-check"></i> Your information was succesfully updated.</p>';
  } 

  if (!empty($prefM) and !empty($prefW)) {
    mysqli_query($mysql,"UPDATE users SET preference='Men & women' WHERE username = '$usname'");
    $msg5 = '<p class="success"><i class="fa fa-check"></i> Your additional information was succesfully updated.</p>';
  }
  
  elseif( !empty($prefM)) {
    mysqli_query($mysql,"UPDATE users SET preference='Men' WHERE username = '$usname'");
    $msg5 = '<p class="success"><i class="fa fa-check"></i> Your additional information was succesfully updated.</p>';
  }

  elseif (!empty($prefW)) {
    mysqli_query($mysql,"UPDATE users SET preference='Women' WHERE username = '$usname'");
    $msg5 = '<p class="success"><i class="fa fa-check"></i> Your additional information was succesfully updated.</p>';
  }
    
  if (!empty($picName)) {
    $target_dir = "../../images/persons/";
    $target_file = $target_dir . basename($_FILES["pic"]["name"]);
    $type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["pic"]["tmp_name"]);
    
    if($check == false) { // Check if image file is a actual image or fake image
      $msg6 = '<p class="error"><i class="fa fa-times-circle"></i> The given file is not an image.</p>';
    }
    elseif (file_exists($target_file)) { // Check if file already exists
      $msg6 = '<p class="error"><i class="fa fa-times-circle"></i> A picture with the same name already exists.</p>';
    }
    elseif ($_FILES["pic"]["size"] > 500000) { // Check file size
      $msg6 = '<p class="error"><i class="fa fa-times-circle"></i> Your picture is too big.</p>';
    }
    elseif($type != "jpg" && $type != "png" && $type != "jpeg" && $type != "gif") { // Allow certain file formats
      $msg6 = '<p class="error"><i class="fa fa-times-circle"></i> Choose a jpg, png, jpeg or gif file.</p>';
    }
    else {
      if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        include "../../mysql/connect.php";

        $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
        
        $query = mysqli_query($mysql,"SELECT picture FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
        $pic = mysqli_fetch_all($query,MYSQLI_ASSOC);
        $pic = $pic[0]["picture"];
        if($pic !== "fillerface.png"){unlink("../../images/persons/$pic");}
        
        mysqli_query($mysql,"UPDATE users SET picture='$picName' WHERE username = '$usname'");
        $_SESSION["picture"]=$picName;
        
        $msg6 = '<p class="success"><i class="fa fa-check"></i> Your profile picture was succesfully updated.</p>';
      } 
      else {
        $msg6 = '<p class="error"><i class="fa fa-times-circle"></i> An error occured. Try again later.</p>';
      }
    }
  }
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>