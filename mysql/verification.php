<?php
  if($_SESSION["try"]>2) {$_SESSION["time_remaining"] = round(($_SESSION["expire"] - time()) / 60, 0);}
  if(isset($_SESSION["expire"]) and $_SESSION["time_remaining"]<1) {unset($_SESSION["try"]);unset($_SESSION["expire"]);}
  if(!isset($_SESSION["try"])) {$_SESSION["try"]=0;}
  if($_SESSION["try"]>2) {
    $_SESSION["time_remaining"] = round(($_SESSION["expire"] - time()) / 60, 0);
    $time_remaining = $_SESSION["time_remaining"];
    $errormsg = "<p class='warning'><i class='fa fa-warning'></i> Logging in is temporarly disabled due to too many failed login attempts. Try again in $time_remaining minute(s).</p>";
  }
  else {
    include "connect.php";

    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

    $usname = mysqli_real_escape_string($mysql,$_POST['usname']);$usname = ucfirst($usname);
    $password = mysqli_real_escape_string($mysql,$_POST['pass']);
    
    if ($usname != "" && $password != "") {
      $password = crypt($password,'$6$aiandyou$');
      $result = mysqli_query($mysql,"SELECT * FROM users WHERE username= BINARY'".$usname."' AND password= BINARY'".$password."'") or die("Error: The selection of the account has failed.");
      $count = mysqli_fetch_assoc($result);

      if($count > 0) {
        $result = mysqli_query($mysql,"SELECT * FROM users WHERE username= BINARY'".$usname."' AND password= BINARY'".$password."' AND active='1'") or die("Error: The selection of the account has failed.");
        $count = mysqli_fetch_assoc($result);
        
        if($count > 0) {
          session_start();
          $query = mysqli_query($mysql,"SELECT firstName FROM users WHERE username='".$usname."'") or die("Error: The selection of the first name has failed.");
          $names = mysqli_fetch_all($query,MYSQLI_ASSOC);
          $_SESSION["name"] = $names[0]["firstName"];
          
          $query = mysqli_query($mysql,"SELECT preposition FROM users WHERE username='".$usname."'") or die("Error: The selection of the middle name has failed.");
          $preps = mysqli_fetch_all($query,MYSQLI_ASSOC);
          $_SESSION["prep"] = $preps[0]["preposition"];
          
          $query = mysqli_query($mysql,"SELECT lastName FROM users WHERE username='".$usname."'") or die("Error: The selection of the last name has failed.");
          $lnames = mysqli_fetch_all($query,MYSQLI_ASSOC);
          $_SESSION["lname"] = $lnames[0]["lastName"];
          
          $query = mysqli_query($mysql,"SELECT admin FROM users WHERE username='".$usname."'") or die("Error: The selection of the admin level has failed.");
          $adminnr = mysqli_fetch_all($query,MYSQLI_ASSOC);
          $_SESSION["admin"] = $adminnr[0]["admin"];
          
          $query = mysqli_query( $mysql,"SELECT picture FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
          $picture = mysqli_fetch_all($query,MYSQLI_ASSOC);
          $_SESSION["picture"] = $picture[0]["picture"];
          
          $_SESSION["username"] = $usname;
          $_SESSION["login"] = 1;
          unset($_SESSION["try"]);
        }
        else {$errormsg= '<p class="warning"><i class="fa fa-warning"></i> Make sure your account is activated.</p>';}
      }
      else {
        $errormsg = '<p class="error"><i class="fa fa-times-circle"></i> Username or password is invalid.</p>';
        $_SESSION["try"]++;
      }
    }
    else {$errormsg = '<p class="info"><i class="fa fa-info-circle"></i> Fill in your username and password.</p>';}
    mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
  }
  if($_SESSION["try"]>1 and $_SESSION["try"]<3){$warning='<p class="warning"><i class="fa fa-warning"></i> You failed to log in twice. You have one more try before logging in will be disabled for a while.</p>';}
  if($_SESSION["try"]>2 and $_SESSION["try"]<4){$_SESSION["expire"] = time()+600;$warning = '<p class="warning"><i class="fa fa-warning"></i> Logging in is disabled for a while.</p>';$_SESSION["try"]++;}
?>