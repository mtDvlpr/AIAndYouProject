<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>About Us - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/about.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
      <?php include "header.html";?>

      <div class="content">
        <div class="topnav" id="myTopnav">
          <a href="/">Home</a>
          <a href="/stories">Successful stories</a>
          <a href="/about" class="active">About Us</a>
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
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
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
              <h2>Who are we?</h2>
              <p>We are four dutch high school students who have a passion for software engineering.</p>
              <p>We made this dating site as a school project for people who are very lonely and are tired of it.</p>
              <center>
                <div class="personcard">
                  <img src="/images/persons/tycho.jpg" class="img"/>
                  <p>Tycho Appelman</p>
                  <p>Main designer /<br>Coder</p>
                  <a href="http://149542.csgja.com/" target="_blank" class="link">149542.csgja.com/</a>
                </div>
                <div class="personcard">
                  <img src="/images/persons/kevin.jpg" class="img"/>
                  <p>Kevin Knoop</p>
                  <p>Main coder /<br>Designer</p>
                  <a href="http://149991.csgja.com/" target="_blank" class="link">149991.csgja.com/</a>
                </div>
                <div class="personcard">
                  <img src="/images/persons/karsten.jpg" class="img"/>
                  <p>Karsten Langerak</p>
                  <p>Project leader /<br>Coder</p>
                  <a href="http://149849.csgja.com/" target="_blank" class="link">149849.csgja.com/</a>
                </div>
                <div class="personcard">
                  <img src="/images/persons/manoah.jpg" class="img"/>
                  <p>Manoah Tervoort</p>
                  <p>Main coder /<br>Designer</p>
                  <a href="http://www.149895.csgja.com" target="_blank" class="link">149895.csgja.com/</a>
                </div>
              </center>
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