<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contact Us - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/form.css">
    
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
          <a href="/about">About Us</a>
          <a href="/contact" class="active">Contact Us</a>
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
            <center>
              <div class="card form-container">
                <a href="https://www.instagram.com/ai.andyou/" target="_blank" title="Find us on instagram!"><img src="/images/instagram.png"/></a>
                <a href="mailto:help.aiandyou@gmail.com" target="_blank" title="Email us!"><img src="/images/mail.png"/></a>
                <h2>Contact Us</h2>
                <form method="post" autocomplete="off">
<?php
  if(!empty($_POST['antispam'])) die();
  if(isset($_POST["submit"]))
  {
    $firstname = ucfirst($_POST["firstname"]);
    $middlename = lcfirst($_POST["middlename"]);
    $lastname = ucfirst($_POST["lastname"]);
    $msg = ucfirst($_POST["message"]);
    $subject = ucfirst($_POST["subject"]);
    $msg = wordwrap($msg,70);
    if (($firstname == trim($firstname) && strpos($firstname, ' ') !== false) or 1 === preg_match('~[0-9]~', $firstname)) {
      echo 'Please fill in a valid first name!';
    }
    elseif (1 === preg_match('~[0-9]~', $middlename)) {
      echo 'Please fill in a valid middlename!';
    }
    elseif (($lastname == trim($lastname) && strpos($lastname, ' ') !== false) or 1 === preg_match('~[0-9]~', $lastname)) {
      echo 'Please fill in a valid last name!';
    }
    else
    {
      mail("help.aiandyou@gmail.com","$subject","$msg\n\nKind regards,\n\n\n$firstname $middlename $lastname","From:noreply@aiandyou.cgja.com");
      echo '<p class="success">Your message was succesfully sent.</p>';
    }
  }
?>
                  <div class="row">
                    <div class="col-20">
                      <label for="fname">First name <span>(required)</span></label>
                    </div>
                    <div class="col-60">
                      <input type="text" id="fname" name="firstname" placeholder="Francesco" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-20">
                      <label for="prep">Middle name</label>
                    </div>
                    <div class="col-60">
                      <input type="text" id="prep" name="middlename" placeholder="de">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-20">
                      <label for="lname">Last name <span>(required)</span></label>
                    </div>
                    <div class="col-60">
                      <input type="text" id="lname" name="lastname" placeholder="Bernardo" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-20">
                      <label for="subject">Subject <span>(required)</span></label>
                    </div>
                    <div class="col-60">
                      <input type="text" id="subject" name="subject" placeholder="Homepage layout" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-20">
                      <label for="message">Message <span>(required)</span></label>
                    </div>
                    <div class="col-60">
                      <textarea id="message" name="message" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit." required></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <input type="text" name="antispam" style="display:none;">
                  </div>
                  <div class="row">
                    <input type="submit" name="submit" value="Send">
                  </div>
                </form>
              </div>
            </center>
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