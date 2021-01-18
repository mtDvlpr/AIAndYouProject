<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];$visitUsname = ucfirst($_GET["u"]);$_SESSION["visit"]=$visitUsname;
  if($_SESSION["login"]==0){header("Location: /");}

  include "../../mysql/connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  $query = mysqli_query( $mysql,"SELECT About FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the name has failed.");
  $about = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $about = $about[0]["About"];

  $query = mysqli_query( $mysql,"SELECT firstName FROM users WHERE username='".$visitUsname."' AND active='1'") or die("Error: The selection of the name has failed.");
  $firstname = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $firstname = $firstname[0]["firstName"];

  if(empty($firstname)){$visitUsname = strtolower($visitUsname);header("Location: /search?s=$visitUsname");}

  $query = mysqli_query( $mysql,"SELECT preposition FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the name has failed.");
  $preposition = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $preposition = $preposition[0]["preposition"];

  $query = mysqli_query( $mysql,"SELECT lastName FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the name has failed.");
  $lastname = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $lastname = $lastname[0]["lastName"];

  $query = mysqli_query( $mysql,"SELECT gender FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the gender has failed.");
  $gender = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $gender = $gender[0]["gender"];

  $query = mysqli_query( $mysql,"SELECT preference FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the preference has failed.");
  $pref = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $pref = $pref[0]["preference"];

  $query = mysqli_query($mysql,"SELECT picture FROM users WHERE username='".$visitUsname."'") or die("Error: The selection of the profile picture has failed.");
  $pic = mysqli_fetch_all($query,MYSQLI_ASSOC);
  $pic = $pic[0]["picture"];

  if(isset($_POST["like"])) {
    mysqli_query($mysql,"INSERT INTO likes (Sender, Receiver) VALUES ('".$usname."', '".$visitUsname."')") or die("Error: The liking of the user has failed.");
    $result = mysqli_query($mysql,"SELECT * FROM likes WHERE Sender='".$visitUsname."' AND Receiver='$usname'") or die("Error: Selecting the users has failed.");
    $countMatch = mysqli_fetch_assoc($result);
    
    $lowUsname = strtolower($usname);if($usname=="Admin"){$usname = "AI And You";}
    $lowVisitUsname = strtolower($visitUsname);if($visitUsname=="Admin"){$visitUsname = "AI And You";}
    if($countMatch > 0) {
      mysqli_query($mysql,"INSERT INTO messages (Owner,Message,Target) VALUES('$usname','You have a new match!','$lowVisitUsname')") or die("Error: There is no connection to the database.");
      mysqli_query($mysql,"INSERT INTO messages (Owner,Message,Target) VALUES('$visitUsname','You have a new match!','$lowUsname')") or die("Error: There is no connection to the database.");
    }
    else {
      mysqli_query($mysql,"INSERT INTO messages (Owner,Message,Target) VALUES('$visitUsname','$usname liked you!','$lowUsname')") or die("Error: There is no connection to the database.");
    }
  }

  $usname=$_SESSION["username"];$visitUsname=$_SESSION["visit"];
  if(isset($_POST["unlike"])){mysqli_query($mysql,"DELETE FROM likes WHERE Sender='$usname' AND Receiver='$visitUsname'") or die("Error: The liking of the user has failed.");}
  $result = mysqli_query($mysql,"SELECT * FROM likes WHERE Sender='".$usname."' AND Receiver='$visitUsname'") or die("Error: Selecting the users has failed.");
  $countLikes = mysqli_fetch_assoc($result);if($countLikes > 0){$liked=1;}else{$liked=0;}

  $result = mysqli_query($mysql,"SELECT count(*) AS cntMatch FROM likes WHERE (Sender='".$visitUsname."' AND Receiver='$usname') OR (Sender='".$usname."' AND Receiver='$visitUsname')") or die("Error: Selecting the users has failed.");
  $row = mysqli_fetch_array($result);
  $countMatch = $row['cntMatch'];
  if($countMatch > 1) {
    $match = 1;
  }
  mysqli_close($mysql) or die("Error: connection could not be interupted.");

  include "../../chatroom/connectChat.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");

  if(isset($_POST["blockUser"])) {
    mysqli_query($mysql,"INSERT INTO blocked (Blocker, Blocked) VALUES ('".$usname."', '".$visitUsname."')") or die("Error: The blocking of the user has failed.");
  }  
  if(isset($_POST["unblockUser"])) {
    mysqli_query($mysql,"DELETE FROM blocked WHERE Blocker='".$usname."' AND blocked='".$visitUsname."'") or die("Error: The blocking of the user has failed.");
  }
if(isset($_POST["karenBlock"])) {
    $time = date('d M H:i:s', strtotime('-6 minutes -56 seconds'));
    if($usname=="Admin"){$usname="AI And You";}
    mysqli_query($mysql,"INSERT INTO private (sender,receiver,msg,posted) VALUES('$visitUsname','$usname','I\'m sorry $fname, I\'m afraid I can\'t let you do that.','$time')") or die("Error: There is no connection to the database.");
}
  $result = mysqli_query($mysql,"SELECT count(*) AS cntBlock FROM blocked WHERE Blocker='".$visitUsname."' AND Blocked='$usname'") or die("Error: Selecting the users has failed.");
  $row = mysqli_fetch_array($result);$countBlock = $row['cntBlock'];if($countBlock > 0){$blocked=2;}else{$blocked=0;}
  $result = mysqli_query($mysql,"SELECT count(*) AS cntBlock FROM blocked WHERE Blocker='".$usname."' AND Blocked='$visitUsname'") or die("Error: Selecting the users has failed.");
  $row = mysqli_fetch_array($result);$countBlock = $row['cntBlock'];if($countBlock > 0){$blocked=1;}
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo"$visitUsname";?> - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/visit.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
    
      <?php include "../header.html";?>

      <div class="content"> 
        <?php include "../menu.html";?>

        <div class="row">
          <div class="leftcolumn">
            <div class="card">
<?php if($usname !== $visitUsname and (($usname =="AI And You" and $visitUsname !=="Admin") or ($usname !=="AI And You" and $visitUsname =="Admin") or ($usname !=="AI And You" and $visitUsname !=="Admin"))){if($liked==0){?>              <form method="post"><input type="submit" name="like" class="likebtn" value="Like this person!"></form>
<?php } else {?>              <form method="post"><input type="submit" name="unlike" class="unlikebtn" value="Unlike this person!"></form>
<?php } } ?>
              <h2><?php echo"$firstname $preposition $lastname";if($match==1){echo'<span> <i class="fa fa-check"></i> Match</span>';}?></h2>
              <div class="img"><img src="/images/persons/<?php echo"$pic";?>"/></div>
<?php if($visitUsname !== "Admin"){echo"              <h3>Gender</h3>$gender<h3>Preference</h3>$pref
";}?>
<?php echo"              <p><h3>About me</h3>$about</p>
";?>
            </div>
          </div>
          
          <div class="rightcolumn">   
            <div class="card">
              <h2>Public chat</h2>
<?php
  include "../../chatroom/connectChat.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  if($usname=="AI And You"){$usname="Admin";}
  $resultBan = mysqli_query($mysql,"SELECT * FROM banned WHERE username='".$usname."'") or die("Error: Selecting the users has failed.");
  $countBan = mysqli_fetch_assoc($resultBan);if($countBan > 0){$banned=1;}else{$banned=0;}
  mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
  if($usname=="Admin"){$usname="AI And You";}
?>
              <div id="chatroom" class="chatroom"></div>
              <form id="chat" method="post" autocomplete="off">
                <input type="text" name="msg<?php if($banned==1){echo"Send";}?>"<?php if($banned==1){echo' disabled';}?>/>
                <button name="sendmsg"<?php if($banned==1){echo' disabled';}?>>Send</button>
              </form>
<?php if($banned==1){echo'              <p class="banmsg">You have been banned from the chatroom.</p>
';}?>
            </div>
<?php if($usname !== $visitUsname){?>           
<?php
  function test_input($data) {$data = str_replace(' ', '', $data);$data = str_replace('0', 'o', $data);$data = str_replace('*', '', $data);return strtolower($data);}
  function contains($needle, $haystack) {return strpos($haystack, $needle) !== false;}

  if(isset($_POST["sendmsg"]) and !empty($_POST["msg"]))
  {
    include "../../chatroom/connectChat.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    
    $msg = mysqli_real_escape_string($mysql,$_POST["msg"]);
    $time = date('d M H:i:s', strtotime('-6 minutes -55 seconds'));
    if($usname=="Admin"){$usname="AI And You";}
    
    if (contains('porn', test_input($msg)) or contains('fuck', test_input($msg)) or contains('kut', test_input($msg)) !== false) {$msg = "This message has been deleted due to inappropriate content.";}
    
    mysqli_query($mysql,"INSERT INTO messages (name,msg,posted) VALUES('$usname','$msg','$time')") or die("Error: Your message could not be sent.");
    mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
  }
  if(isset($_POST["sendprivatemsg"])) {
    include "../../chatroom/connectChat.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    $msg = mysqli_real_escape_string($mysql,$_POST["msg"]);
    
    if (contains('porn', test_input($msg)) or contains('fuck', test_input($msg)) or contains('kut', test_input($msg)) !== false) {$msg = "This message has been deleted due to inappropriate content.";}
    
    $time = date('d M H:i:s', strtotime('-6 minutes -55 seconds'));
    if($usname=="Admin"){$usname="AI And You";}if($visitUsname=="Admin"){$visitUsname="AI And You";}
    mysqli_query($mysql,"INSERT INTO private (sender,receiver,msg,posted) VALUES('$usname','$visitUsname','$msg','$time')") or die("Error: There is no connection to the database.");
    mysqli_close($mysql) or die("Error: Closing the server connection has failed.");

    include "../../mysql/connect.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    $result = mysqli_query( $mysql,"SELECT count(*) AS cntMessage FROM messages WHERE Owner='".$visitUsname."' AND Message='<strong>$usname</strong> sent you a message.'") or die("Error: The selection of the name has failed.");
    $row = mysqli_fetch_array($result);
    $countMessage = $row['cntMessage'];
    if($countMessage < 1){if($usname=="AI And You"){$lowUsname = "admin";}else{$lowUsname = strtolower($usname);}mysqli_query($mysql,"INSERT INTO messages (Owner,Message,Target) VALUES('$visitUsname','<strong>$usname</strong> sent you a message.','$lowUsname')") or die("Error: There is no connection to the database.");}
    mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
    
    if($visitUsname =="Karen") {
      include "../../chatroom/connectChat.php";
      $mysql1 = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
      $antwoord=0;$bericht = $msg;
      $bericht = str_replace("? ","",$bericht);
      $bericht = str_replace("?","",$bericht);
      $bericht = str_replace(" karen","",$bericht);
      $bericht = str_replace(" Karen","",$bericht);
      
      while ($antwoord<1) {
        include "../../chatbot/karen/Therest.php";
        include "../../chatbot/karen/im_a.php";
        include "../../chatbot/karen/Have.php";
        include "../../chatbot/karen/Are.php";
        include "../../chatbot/karen/Wheredoyou.php";
        if($antwoord==0) {$t_antwoord = "I'm not allowed to comment on that.";$antwoord=1;}
      }
      
      $time = date('d M H:i:s', strtotime('-6 minutes -57 seconds'));
      if($usname=="Admin"){$usname="AI And You";}
      if($t_antwoord=="I'm not allowed to comment on that."){$t_antwoord = mysqli_real_escape_string($mysql1,$t_antwoord);}
      mysqli_query($mysql1,"INSERT INTO private (sender,receiver,msg,posted) VALUES('$visitUsname','$usname','$t_antwoord','$time')") or die("Error: There is no connection to the database 1.");
      mysqli_close($mysql1) or die("Error: Closing the server connection has failed.");
    }
  }
?>
            <div class="card">
<?php if($blocked==0){?>              <h2>Private chat
                <form method="post">
                  <button name="<?php if($visitUsname == "Karen"){echo'karenBlock';}else{echo'blockUser';} ?>" onclick="submit()" class="block">
                    <i class="fa fa-ban" aria-hidden="true" title="Block this user!"></i>
                  </button>
                </form>
              </h2>
              <div id="privatechatroom" class="chatroom"></div>
              <form id="privatechat" method="post" autocomplete="off">
                <input type="text" name="msg"/>
                <button name="sendprivatemsg">Send</button>
              </form>
<?php }elseif($blocked==1){?>              <h2>Private chat
                <form method="post">
                  <button name="unblockUser" onclick="submit()" class="unblock">
                    <i class="fa fa-plus" aria-hidden="true" title="Unblock this user!"></i>
                  </button>
                </form>
              </h2>
              <p>You have blocked this user.</p>
<?php }else{?>              <h2>Private chat</h2>
              <p>This user blocked you.</p>
<?php } ?>
            </div>
<?php } ?>
          </div>
        </div>
      </div>

      <?php include "../footer.html";?>
    </div>
  </body>
</html>