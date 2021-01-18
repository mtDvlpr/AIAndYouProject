<?php
  include "connectChat.php";
  session_start();$usname = $_SESSION["username"];$visitUsname = $_SESSION["visit"];if($usname=="Admin"){$usname="AI And You";}$fname=$_SESSION["name"];if($visitUsname=="Admin"){$visitUsname="AI And You";}
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  $messagesResult = mysqli_query($mysql,"SELECT * FROM private WHERE (sender='$usname' AND receiver ='$visitUsname') OR (sender='$visitUsname' AND receiver ='$usname')") or die("Error: The selection of the messages has failed.");
  $countResult = mysqli_query($mysql,"SELECT COUNT(*) AS cntResults2 FROM private WHERE (sender='$usname' AND receiver ='$visitUsname') OR (sender='$visitUsname' AND receiver ='$usname')") or die("Error: The selection of the messages has failed.");
  $row = mysqli_fetch_array($countResult);
  $countResults = $row['cntResults2'];if(!isset($_SESSION["cntResults2"])){$_SESSION["cntResults2"]=$countResults;}else{if($countResults > $_SESSION["cntResults2"]){echo'<script>scrollPrivateChat()</script>';$_SESSION["cntResults2"]=$countResults;}}
  while(list($id,$sender,$receiver,$msg,$posted) = mysqli_fetch_row($messagesResult))
  {
    if($sender == $usname){$sender = "You";}
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    if(preg_match($reg_exUrl, $msg, $url)) {$msg = preg_replace($reg_exUrl, "<a href='{$url[0]}' target='_blank'>{$url[0]}</a> ", $msg);} 
    echo"            <div title='$posted' class='msg'><b>$sender:</b> $msg</div>";
  }
  if($countResults==0 and $visitUsname=="Karen"){$time = date('d M H:i:s', strtotime('-6 minutes -53 seconds'));mysqli_query($mysql,"INSERT INTO private (sender,receiver,msg,posted) VALUES('$visitUsname','$usname','Hey $fname, how are you?','$time')") or die("Error: The selection of the messages has failed.");}
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>