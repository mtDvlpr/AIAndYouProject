<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Help - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
      <?php include "header.html";?>

      <div class="content">
        <div class="topnav" id="myTopnav">
          <a href="/">Home</a>
          <a href="/stories">Succesful stories</a>
          <a href="/about">About Us</a>
          <a href="/contact">Contact Us</a>
<?php if($_SESSION["login"]==1) {?>
          <div class='dropdown'>
            <button class='dropbtn'><?php echo"$fname $prep $lname <img src='/images/persons/$picture' class='profilepic'/>
";?>
              <i class='fa fa-caret-down'></i>
            </button>
            <div class='dropdown-content'>
              <a href='/account'>Your account</a>
              <a href='/logout'>Log out</a>
            </div>
          </div>
          <div class="vl"></div>
          <a href="/help" title="Help" class="help active"><img src="/images/help.png"/></a>
<?php
  include "../mysql/connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  if($usname=="Admin"){$usname="AI And You";}
  if(isset($_POST["deleteNot"])){mysqli_query($mysql,"DELETE FROM messages WHERE Owner='".$usname."'");}
  
  $result = mysqli_query($mysql,"SELECT count(*) AS cntResults FROM messages WHERE Owner='".$usname."'") or die("Error: There is no connection to the database.");
  $row = mysqli_fetch_array($result);
  $countResults = $row['cntResults'];
?>
          <div class='dropdown'>
            <button title="Notifications" class='messagebtn' onclick="showMessages()"><img src="/images/notifications.png"/><?php if($countResults > 0){echo" ($countResults)";}?></button>
            <div id="messages" class='message-content' style="display:none;">
<?php
  if($countResults > 0) {
    $result = mysqli_query($mysql,"SELECT * FROM messages WHERE Owner='$usname' ORDER BY ID desc") or die("Error: The selection of the messages has failed.");
    while(list($id,$owner,$message,$target) = mysqli_fetch_row($result)) {
      echo"             <a href='/visit?u=$target'>$message</a>
";
    }
    echo'             <hr>
             <form method="post" autocomplete="off">
               <p><input type="submit" name="deleteNot" class="removeMessages" value="Delete all notifications"></p>
             </form>
';
  }
  else {
    echo"              <p>You have no notifications.</p>
";
  }
?>
            </div>
          </div>
          <div class='search-container'>
            <form action='/visit' autocomplete='off'><input type='text' id='search' name='u' placeholder='search people...'></form>
            <div id='display' class='search-results'>
            </div>
          </div>
<?php }else{ ?>          <a href="/login" style="float:right">Log in</a>
          <a href="/help" title="Help" class="help active" style="float:right;"><img src="/images/help.png"/></a>
<?php } ?>
          <a href="javascript:void(0);" class="icon" onclick="showMenu()"><img src="/images/menu.svg"/></a>
        </div>

        <div class="row">
          <div class="rightcolumn">
            <div class="card">
              <h2>Check out our successful stories!</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>We are proud of the results we've had with people and machines who met each other here and fell in love.</p>
            </div>
          </div>
          
          <div class="leftcolumn">
            <div class="card">
              <h1>Help</h1>
              
              <p>This website has multiple functions to offer. If you need help with any of them, you can find useful tips here.<br>Is your problem not mentioned? Contact us with your question by clicking <a href="/contact">here</a>!</p>

              <h2>Sign up</h2>
              <p>To make an account, you can click <a href="/signup">here</a>. You have to fill in some basic information, like your full name and email address.<br>Make sure you fill in a valid email address, because after signing up, you get a verification mail to activate your account.</p>

              <h2>Log in</h2>
              <p>To log in, you can click <a href="/login">here</a>. You log in with your self-chosen, unique username and your password.<br>Your username's first letter is not case-sensitive, but your password is case-sensitive.</p>

              <h2>Forgot password?</h2>
              <p>If you forgot your password, we can send you an email with your current password. Click <a href="/forgot">here</a>.<br>You have to fill in your email address twice after which we will send you an email with your password.</p>

              <h2>Search users</h2>
              <p>You can search other users, once you are logged in. The search function searches accounts with a username that matches the search.<br>If your search is a valid username you will be redirected to that user's visit page.</p>
              
              <h2>Matching</h2>
              <p>When visiting someone's account, you can like that person. If that person likes you back you get a match. You will be notified.</p>
            
              <h2>Question not answered?</h2>
              <p>Contact us with your question by clicking <a href="/contact">here</a>!</p>
            </div>
          </div>
          
          <div class="rightcolumn">
            <?php if($_SESSION["login"]==1){include "../chatroom/chatroom.php";}?>
          </div>
        </div>
      </div>

      <?php include "footer.html";?>
    </div>
  </body>
</html>