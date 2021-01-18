<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">

    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="TcxMw-_2aRPHHTPyw8qJf3N235n7cXv3aupzEc4tP-M">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">

    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
  </head>
  <body>
    <div class="container">
      <?php
        //Font style = Spirax
        include "pages/header.html";
      ?>

      <div class="content">
        <div class="topnav" id="myTopnav">
          <a href="/" class="active">Home</a>
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
          <div class="leftcolumn">
            <div class="card">
              <h2>AI And You</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>AI And You is an upcoming, unqiue dating service where you can meet both physical and artificial people.</p>
              <p>We have a bunch of cool features in store for you, once you're logged in.</p>
            </div>
          </div>
          <div class="rightcolumn">
            <div class="card">
              <h2>Check out our successful stories!</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>We are proud of the results we've had with people and machines who met each other here and fell in love.</p>
            </div>

            <?php if($_SESSION["login"]==1){include "chatroom/chatroom.php";}?>
          </div>
          <div class="leftcolumn">
            <div class="card">
              <h2>Announcements</h2>
              <img src="/images/logo/favicon.ico"/>
              <p><span>1 February:</span>Dear users, we are happy to announce that you can now chat with other users all over the world to talk about anything!</p>
              <p><span>6 February:</span>Dear users, we are happy to announce that you can now have a profile picture for a more personal touch to your acocunt!</p>
              <p><span>10 February:</span>Dear users, we are happy to announce that you can now search for other users to get to know them and talk privately!</p>
              <p><span>14 February:</span>Dear users, we are happy to announce that we are almost done with the matching function, so you can meet your loves!</p>
              <p><span>19 February:</span>Dear users, we are happy to announce that you now receive notifications for unread private messages and new matches!</p>
              <p><span>1 March:</span>Dear users, we are happy to announce that you now receive a message when someone liked you and you can block users!</p>
              <p>~ The AI And You team</p>
            </div>
          </div>
        </div>
      </div>

      <?php include "pages/footer.html";?>
    </div>
  </body>
</html>
