<?php
  session_start();
  if(isset($_POST["login"])){include "../../mysql/verification.php";}
  if($_SESSION["login"]==1){header("Location: /");}
  if(isset($_SESSION["expire"])){$_SESSION["time_remaining"] = round(($_SESSION["expire"] - time()) / 60, 0);}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Log in - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
    
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
          <a href="/login" style="float:right" class="active">Log in</a>
          <a href="/help" title="Help" class="help" style="float:right;"><img src="/images/help.png"/></a>
          <a href="javascript:void(0);" class="icon" onclick="showMenu()"><img src="/images/menu.svg"/></a>
        </div>

        <div class="row">
          <div class="rightcolumn">
            <div class="card">
              <h2>Contact us!</h2>
              <img src="/images/logo/favicon.ico"/>
              <p>Make sure to contact us, to let us know what you think of our service.</p>
            </div>
          </div>
          
          <div class="leftcolumn">
            <div class="card">
              <div class="login">
						    <h1>Log in</h1>
						<?php echo"$errormsg <br> $warning
";?>
                <form method="post" autocomplete="off">
                <table>
                  <tr><td>Username</td><td><input type="text" size="20" name="usname" maxlength="20" placeholder="Username" required></td></tr>
                  <tr><td>Password</td><td><input type="password" id="newpass" size="20" name="pass" maxlength="20" placeholder="Password" required></td></tr>
                  <tr><td></td><td><input type="submit" name="login" value="Log in"></td></tr>
                </table>
                </form> 
                <p>Don't have an account yet? Click <a href="/signup">here</a> to sign up.</p>
                <p>Forgot password? Click <a href="/forgot">here</a>.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include "../footer.html";?>
    </div>
  </body>
</html>