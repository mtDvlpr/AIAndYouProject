<?php
  session_start();
  include "connectChat.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  $messagesResult = mysqli_query($mysql,"SELECT * FROM messages") or die("Error: The selection of the messages has failed.");
  $countResult = mysqli_query($mysql,"SELECT COUNT(*) AS cntResults FROM messages") or die("Error: The selection of the messages has failed.");
  $row = mysqli_fetch_array($countResult);
  $countResults = $row['cntResults'];if(!isset($_SESSION["cntResults"])){$_SESSION["cntResults"]=$countResults;}else{if($countResults > $_SESSION["cntResults"]){echo'<script>scrollChat()</script>';$_SESSION["cntResults"]=$countResults;}}
  while(list($id,$name,$msg,$posted) = mysqli_fetch_row($messagesResult))
  {
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    if(preg_match($reg_exUrl, $msg, $url)) {$msg = preg_replace($reg_exUrl, "<a href='{$url[0]}' target='_blank'>{$url[0]}</a> ", $msg);} 
    echo"            <div title='$posted' class='msg'><b>$name:</b> $msg</div>";
  }
  mysqli_close($mysql) or die("Error: connection could not be interupted.");
?>