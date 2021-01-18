<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];$search = $_GET["s"];
  if($_SESSION["login"]==0){header("Location: /");}if(isset($_GET["s"]) and empty($_GET["s"])){header("Location: /search");}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php if(isset($_GET["s"])){echo"$search - ";}?>Search - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/search.css">
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
          <a href="/stories">Succesful stories</a>
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
          <div class="leftcolumn">
            <div class="card form-container">
              <form autocomplete="off">
                <div class="row">
                  <div class="col-20">
                    <label for="searchterm">Search term</label>
                  </div>
                  <div class="col-60">
                    <input type='text' id="searchterm" name='t' placeholder='search people...'/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label>Gender <span>(required)</span></label>
                  </div>
                  <div class="col-60">
                    <label for="mal">
                      <input type="radio" id="mal" name="g" value="Male" required>Male
                    </label>
                    <label for="fem">
                      <input type="radio" id="fem" name="g" value="Female" required>Female
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-20">
                    <label>Preference <span>(required)</span></label>
                  </div>
                  <div class="col-60">
                    <label for="men">
                      <input type="radio" id="men" name="p" value="Men" required>Men
                    </label>
                    <label for="wom">
                      <input type="radio" id="wom" name="p" value="Women" required>Women
                    </label>
                  </div>
                </div>
                <div class="row">
                  <input type="submit" name="search" value="Search">
                </div>
              </form>
            </div>
            
            <div class="card personcard">
<?php
  include "../mysql/connect.php";
  $mysql = mysqli_connect($server,$user,$pass,$db) or die("Error: There is no connection to the database.");
  
  if(isset($_GET["search"])) {
    $term = $_GET["t"];
    $gender = $_GET["g"];
    $pref = $_GET["p"];
    if(empty($term)) {
      $result = mysqli_query($mysql,"SELECT * FROM users WHERE gender='$gender' AND (preference='$pref' OR preference='Men & women') AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");
      $resultCnt = mysqli_query($mysql,"SELECT count(*) AS cntSearches FROM users WHERE gender='$gender' AND (preference='$pref' OR preference='Men & women') AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");
    }
    else {
      $result = mysqli_query($mysql,"SELECT * FROM users WHERE username LIKE '$term%' AND gender='$gender' AND (preference='$pref' OR preference ='Men & women') AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");
      $resultCnt = mysqli_query($mysql,"SELECT count(*) AS cntSearches FROM users WHERE username LIKE '$term%' AND gender='$gender' AND (preference='$pref' OR preference ='Men & women') AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");    }
   }
  else {
    $result = mysqli_query($mysql,"SELECT * FROM users WHERE username LIKE '$search%' AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");
    $resultCnt = mysqli_query($mysql,"SELECT COUNT(*) AS cntSearches FROM users WHERE username LIKE '$search%' AND active='1' AND NOT (username='admin' OR username='$usname')") or die("Error: The selection of the search results has failed.");
  }
              
  $row = mysqli_fetch_array($resultCnt);$countSearches = $row['cntSearches'];if($countSearches <1){echo"<h2>No users were found.</h2>";}

  while(list($username,$pas,$firstname,$preposition,$lastname,$email,$about,$gender,$preference,$pic) = mysqli_fetch_row($result)) {
    $usernameLowercase = strtolower($username);
    echo"              <div class='person' onclick=\"window.location.href='/visit?u=$usernameLowercase'\">
               <h2>$username</h2>
               <img src='/images/persons/$pic'/>
               <h3>$firstname $preposition $lastname</h3>
               <h3>Gender</h3><p>$gender</p>
               <h3>Preference</h3><p>$preference</p>
              </div>
";
  }
?>
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