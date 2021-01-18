<?php session_start();if($_SESSION["login"]==1){header("Location: /");}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Forgot password - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
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
          </div>
          
          <div class="leftcolumn">
            <div class="card">
              <div class="login">
                <h1>Forgot password?</h1>
<?php 
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if(isset($_POST["forgot"])) {
    $usname = test_input($_POST["usname"]);
    $email = test_input($_POST["email"]);
    $confirmemail = test_input($_POST["confirmemail"]);

    if (empty($_POST["usname"]) or empty($_POST["email"]) or empty($_POST["confirmemail"])) {
      echo'<p class="info"><i class="fa fa-info-circle"></i> Fill in everything.</p>';  
    }
    elseif ($email == $confirmemail) {
      include "../../mysql/forgotpass.php";
    }
    else {
      echo'<p class="error"><i class="fa fa-times-circle"></i> Your email addresses do not match.</p>';
    }
  }
?>
                <form method="post" autocomplete="off">
                  <table>
                    <tr><td>Username</td><td><input type="text" size="20" name="usname" maxlength="20" placeholder="Username" required></td></tr>
                    <tr><td>Email address</td><td> <input type="email" id="email" size="20" name="email" maxlength="40" placeholder="Email" required></td></tr>
                    <tr><td>Confirm email address</td><td> <input type="email" id="confirmemail" size="20" name="confirmemail" maxlength="40" placeholder="Confirm email" required></td></tr>
                    <tr><td></td><td><input type="submit" name="forgot" value="Send email"></td></tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include "../footer.html";?>
      <script type="text/javascript" src="/js/validateEmail.js"></script>
    </div>
  </body>
</html>