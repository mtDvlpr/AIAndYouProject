<?php 
  session_start();if(isset($_POST["update"])){include "../../mysql/update.php";}$usname=$_SESSION["username"];$picture=$_SESSION["picture"];
  if(isset($_POST["removePrep"])) {
    include "../../mysql/connect.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    mysqli_query($mysql,"UPDATE users SET preposition='' WHERE username= '$usname'") or die("Error: The removal of the preposition has failed.");
    mysqli_close($mysql) or die("Error: connection could not be interupted.");
    $_SESSION["prep"]= "";
    $msg = '<p class="success"><i class="fa fa-check"></i> Your preposition was succesfully removed.</p>';
  }
  $fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];
      
  if($_SESSION["login"]==0){header("Location: /");}

  include "../../mysql/connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  if(isset($_POST["removePic"])) {
    $query = mysqli_query($mysql,"SELECT picture FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
    $pic = mysqli_fetch_all($query,MYSQLI_ASSOC);
    $pic = $pic[0]["picture"];
    if($pic !== "fillerface.png"){unlink("../../images/persons/$pic");}

    mysqli_query($mysql,"UPDATE users SET picture='fillerface.png' WHERE username = '$usname'");
    $_SESSION["picture"]="fillerface.png";

    $msg = '<p class="success"><i class="fa fa-check"></i> Your profile picture was succesfully removed.</p>';
  }

  $query = mysqli_query($mysql,"SELECT about FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
  $about = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $about = $about[0]["about"];

  $query = mysqli_query($mysql,"SELECT gender FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
  $gender = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $gender = $gender[0]["gender"];

  $query = mysqli_query($mysql,"SELECT preference FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
  $pref = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $pref = $pref[0]["preference"];

  $query = mysqli_query($mysql,"SELECT picture FROM users WHERE username='".$usname."'") or die("Error: The selection of the name has failed.");
  $pic = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $pic = $pic[0]["picture"];
  
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Your account - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
	  <link rel="stylesheet" type="text/css" href="/css/account.css">
    <link rel="stylesheet" type="text/css" href="/css/form.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
    
      <?php include "../header.html";?>

      <div class="content"> 
        <div class="topnav" id="myTopnav">
          <a href="/">Home</a>
          <a href="/stories">Successful stories</a>
          <a href="/about">About Us</a>
          <a href="/contact">Contact Us</a>
<?php if($_SESSION["login"]==1) {?>
          <div class='dropdown active'>
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
  include "../../mysql/connect.php";
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
              <h2><?php echo"$fname $prep $lname";?></h2>
              <div class="img"><img src="/images/persons/<?php echo"$pic";?>"/></div>
<?php if($usname !== "AI And You"){echo"              <h3>Gender</h3>$gender<h3>Preference</h3>$pref
";}?>
<?php echo"              <p><h3>About me</h3>$about</p>
";?>
            </div>
            
            <div class="form-container card">
              <h2>Change your information</h2>
              <p>If you don't want to change something, leave it blank.</p>
              <form method="post" autocomplete="off" enctype="multipart/form-data">
<?php 
  if(!empty($msg1)) {echo"$msg1<br>";}
  if(!empty($msg2)) {echo"$msg2<br>";}
  if(!empty($msg3)) {echo"$msg3<br>";}
  if(!empty($msg4)) {echo"$msg4<br>";}
  if(!empty($msg5)) {echo"$msg5<br>";}
  if(!empty($msg6)) {echo"$msg6";}
?>
                <div class="row">
                  <div class="col-20">
                    <label for="fname">First name</label>
                  </div>
                  <div class="col-60">
                    <input type="text" id="fname" name="firstname" placeholder="Francesco">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="prep">Preposition</label>
                  </div>
                  <div class="col-60">
                    <input type="text" id="prep" name="prep" placeholder="de">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="lname">Last name</label>
                  </div>
                  <div class="col-60">
                    <input type="text" id="lname" name="lastname" placeholder="Bernardo">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="email">Email address</label>
                  </div>
                  <div class="col-60">
                    <input type="email" id="email" name="email" placeholder="example@example.com">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="newpass">New password</label>
                  </div>
                  <div class="col-60">
                    <input type="password" id="newpass" name="newpass" placeholder="New password">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="confirmnewpass">Confirm password</label>
                  </div>
                  <div class="col-60">
                    <input type="password" id="confirmnewpass" name="confirmpass" placeholder="Confirm password">
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="about">About me</label>
                  </div>
                  <div class="col-60">
                    <textarea id="about" name="about" placeholder="Hi, I am [name]. I live in [country]. I like to [hobbies]."><?php echo"$about";?></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label>Profile picture</label>
                  </div>
                  <div class="col-60">
                    <input type="file" id="pic" name="pic" class="inputpic">
                    <label for="pic"><span>Choose a file...</span></label>
                  </div>
                </div>
                 <div class="row">
                  <div class="col-20">
                    <label>Gender</label>
                  </div>
                  <div class="col-60">
                    <label for="mal">
                      <input type="radio" id="mal" name="gender" value="Male">Male
                    </label>
                    <label for="fem">
                      <input type="radio" id="fem" name="gender" value="Female">Female
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label>Preference</label>
                  </div>
                  <div class="col-60">
                    <label for="men">
                      <input type="checkbox" id="men" name="preferenceM" value="Men">Men
                    </label>
                    <label for="wom">
                      <input type="checkbox" id="wom" name="preferenceW" value="Women">Women
                    </label>
                  </div>
                </div>
                <div class="row">
                  <input type="submit" name="update<?php if($usname=="Koeniszeergay"){echo"Account";}?>" value="Change">
                </div>
              </form>
            </div>
          </div>

          <div class="rightcolumn">
            <?php if($_SESSION["login"]==1){include "../../chatroom/chatroom.php";}?>
            
            <div class="card">
			 <div class="matches">
              <h2>Your matches</h2>
<?php 
  include "../../mysql/connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  $result = mysqli_query($mysql,"SELECT * FROM likes WHERE Sender='$usname'") or die("Error: The selection of the messages has failed.");
  while(list($sender,$receiver) = mysqli_fetch_row($result)) {
    $result2 = mysqli_query($mysql,"SELECT * FROM likes WHERE Sender='".$receiver."' AND Receiver='$sender'") or die("Error: Selecting the users has failed.");
    $countMatch = mysqli_fetch_assoc($result2);if($countMatch > 0){$rec = strtolower($receiver);echo"              <a href='/visit?u=$rec'>$receiver</a><br>
";}
  }
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>
			 </div>
            </div>
            
            <div class="form-container responsive card">
              <h2>Account settings</h2>
              <hr>
              <h3>Remove preposition</h3>
<?php if(isset($_POST["removePrep"])) {echo"$msg";}?>
              <form method="post" autocomplete="off">
                <div class="row">
                  <input type="submit" name="removePrep" value="Remove preposition">
                </div>
              </form>
              <br><hr>
              <h3>Remove profile picture</h3>
<?php if(isset($_POST["removePic"])) {echo"$msg";}?>
              <form method="post" autocomplete="off">
                <div class="row">
                  <input type="submit" name="removePic" value="Remove picture">
                </div>
              </form>
              <br><hr>
              <h3>Remove account</h3>
              <form method="post" autocomplete="off">
<?php if (isset($_POST["remove"])) {include "../../mysql/remove.php";}?>
                <div class="row">
                  <div class="col-20">
                    <label for="usname">Username</label>
                  </div>
                  <div class="col-60">
                    <input type="text" id="usname" name="usname" placeholder="Username" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label for="pass">Password</label>
                  </div>
                  <div class="col-60">
                    <input type="password" id="pass" name="pass" placeholder="Password" required>
                  </div>
                </div>
                <div class="row">
                  <input type="submit" name="remove" value="Remove account">
                </div>
              </form>
            </div>  
          </div>
        </div>
      </div>

      <?php include "../footer.html";?>
      <script src="/js/validatePassword.js"></script> 
    </div>
  </body>
</html>