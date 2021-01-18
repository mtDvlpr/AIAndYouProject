<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$mname=$_SESSION["mname"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>403 - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/403.css">
    
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
        
        <!-- Source: https://codepen.io/marianab/full/EedpEb/ -->
        <div class="error">
          <svg xmlns="http://www.w3.org/2000/svg" id="robot-error" viewBox="0 0 260 118.9">
            <defs>
              <clipPath id="white-clip"><circle id="white-eye" fill="#cacaca" cx="130" cy="65" r="20" /> </clipPath>
              <text id="text-s" class="error-text" y="106"> 403 </text>
            </defs>
            <path class="alarm" fill="#e62326" d="M120.9 19.6V9.1c0-5 4.1-9.1 9.1-9.1h0c5 0 9.1 4.1 9.1 9.1v10.6" />
            <use xlink:href="#text-s" x="-0.5px" y="-1px" fill="black"></use>
            <use xlink:href="#text-s" fill="#2b2b2b"></use>
            <g id="robot">
              <g id="eye-wrap">
                <use xlink:href="#white-eye"></use>
                <circle id="eyef" class="eye" clip-path="url(#white-clip)" fill="#000" stroke="#2aa7cc" stroke-width="2" stroke-miterlimit="10" cx="130" cy="65" r="11" />
                <ellipse id="white-eye" fill="#2b2b2b" cx="130" cy="40" rx="18" ry="12" />
              </g>
              <circle class="lightblue" cx="105" cy="32" r="2.5" id="tornillo"/>
              <use xlink:href="#tornillo" x="50"></use>
              <use xlink:href="#tornillo" x="50" y="60"></use>
              <use xlink:href="#tornillo" y="60"></use>
            </g>
          </svg>
          <h1>You are not allowed to enter here</h1>
          <h2>Go <a href="/">Home</a></h2>
        </div
      </div>

      <?php include "pages/footer.html";?>
      <script src="/js/403.js"></script>
    </div>
  </body>
</html>