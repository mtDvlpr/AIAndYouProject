<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$mname=$_SESSION["mname"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>404 - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/404.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
      <?php include "pages/header.html";?>

      <div class="content">
        <div class="topnav" id="myTopnav">
          <a href="/">Home</a>
          <a href="/stories">Successful stories</a>
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
          <a href="/help" title="Help" class="help"><img src="/images/help.png"/></a>
<?php
  include "mysql/connect.php";
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
    $result = mysqli_query($mysql,"SELECT * FROM messages WHERE Owner='$usname'") or die("Error: The selection of the messages has failed.");
    while(list($owner,$message,$target) = mysqli_fetch_row($result)) {
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
          <a href="/help" title="Help" class="help" style="float:right;"><img src="/images/help.png"/></a>
<?php } ?>
          <a href="javascript:void(0);" class="icon" onclick="showMenu()"><img src="/images/menu.svg"/></a>
        </div>
        
        <!-- Source: https://codepen.io/salehriaz/pen/erJrZM -->
        <div class="bg-purple">
        
          <div class="stars">
            <div class="central-body">
              <img class="image-404" src="/images/errors/404.svg" width="300px">
              <a href="/" class="btn-go-home">GO BACK HOME</a>
            </div>
              
            <div class="objects">
              <img class="object_rocket" src="/images/errors/rocket.svg" width="40px">
              <div class="earth-moon">
                <img class="object_earth" src="/images/errors/earth.svg" width="100px">
                <img class="object_moon" src="/images/errors/moon.svg" width="80px">
              </div>
              <div class="box_astronaut">
                <img class="object_astronaut" src="/images/errors/astronaut.svg" width="140px">
              </div>
            </div>
              
            <div class="glowing_stars">
              <div class="star"></div>
              <div class="star"></div>
              <div class="star"></div>
              <div class="star"></div>
              <div class="star"></div>
            </div>
          </div>
        </div>
      </div>

      <?php include "pages/footer.html";?>
    </div>
  </body>
</html>