<?php session_start();if($_SESSION["login"]==1){?>
<?php
  session_start();$usname=$_SESSION["username"];
  
  include "connectChat.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  $resultBan = mysqli_query($mysql,"SELECT * FROM banned WHERE username='".$usname."'") or die("Error: Selecting the users has failed.");
  $countBan = mysqli_fetch_assoc($resultBan);if($countBan > 0){$banned=1;}else{$banned=0;}
  mysqli_close($mysql) or die("Error: Closing the server connection has failed.");

  if(isset($_POST["sendmsg"]) and !empty($_POST["msg"]))
  {
    include "connectChat.php";
    $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
    
    $msg = mysqli_real_escape_string($mysql,$_POST["msg"]);
    $time = date('d M H:i:s', strtotime('-6 minutes -55 seconds'));
    if($usname=="Admin"){$usname="AI And You";}
    
    function test_input($data) {$data = str_replace(' ', '', $data);$data = str_replace('0', 'o', $data);$data = str_replace('5', 's', $data);$data = str_replace('*', '', $data);return strtolower($data);}
    function contains($needle, $haystack) {return strpos($haystack, $needle) !== false;}
    if (contains('porn', test_input($msg)) or contains('fuck', test_input($msg)) or contains('kut', test_input($msg)) or contains('nudes', test_input($msg)) or contains('dick', test_input($msg)) !== false) {$msg = "This message has been deleted due to inappropriate content.";}
    
    if(!empty(test_input($msg))){mysqli_query($mysql,"INSERT INTO messages (name,msg,posted) VALUES('$usname','$msg','$time')") or die("Error: Your message could not be sent.");}
    mysqli_close($mysql) or die("Error: Closing the server connection has failed.");
  }
?>
<div class="card">
              <h2>Public chat</h2>
              <div id="chatroom" class="chatroom"></div>
              <form id="chat" method="post" autocomplete="off">
                <input type="text" name="msg<?php if($banned==1){echo"Send";}?>"<?php if($banned==1){echo' disabled';}?>/>
                <button name="sendmsg"<?php if($banned==1){echo' disabled';}?>>Send</button>
              </form>
<?php if($banned==1){echo'              <p class="banmsg">You have been banned from the chatroom.</p>
';}?>
            </div>
<?php } ?>