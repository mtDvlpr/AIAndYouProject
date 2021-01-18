<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cookies Policy - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/terms.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
      
      <?php include "../header.html";?>

      <div class="content">
        <?php include "../menu.html";?>

        <div class="row">
          <div class="rightcolumn">
            <div class="card">
              <h2>Contact us!</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>Make sure to contact us, to let us know what you think of our service.</p>
            </div>
            
            <div class="card">
              <h2>Check out our successful stories!</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>We are proud of the results we've had with people and machines who met each other here and fell in love.</p>
            </div>
          </div>
          
          <div class="leftcolumn">
            <div class="card">
              <?php include "cookies-text.html";?>
            </div>
          </div>
          
          <div class="rightcolumn">
            <?php if($_SESSION["login"]==1){include "../../chatroom/chatroom.php";}?>
          </div>
        </div>
      </div>

      <?php include "../footer.html";?>
    </div>
  </body>
</html>