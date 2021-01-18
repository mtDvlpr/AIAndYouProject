<?php session_start();if($_SESSION["login"]==1){header("Location: /");}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign up - AI And You</title>
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
                <h1>Sign up</h1>
<?php 
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function is_valid_mail($mail) {
    $mail_domains_ko = array('gmail.com','live.nl','ja.nl','jamail.nl','outlook.com','hotmail.com','mac.com','icloud.com','me.com','yahoo.com','msn.com','googlemail.com');
    foreach($mail_domains_ko as $ko_mail) {
      list(,$mail_domain) = explode('@',$mail);
      if(strcasecmp($mail_domain, $ko_mail) == 0){
        return true;
      }
    }
    return false;
  }
      
	if(isset($_POST["signup"])) {
    $usname = test_input($_POST["usname"]);
    $pass = test_input($_POST["pass"]);
    $confirmpass = test_input($_POST["confirmpass"]);
    $fname = test_input($_POST["fname"]);
    $prep = test_input($_POST["prep"]);
    $lname = test_input($_POST["lname"]);
    $email = test_input($_POST["email"]);
    
		if (empty($_POST["usname"]) or empty($_POST["pass"]) or empty($_POST["confirmpass"]) or empty($_POST["fname"]) or empty($_POST["lname"]) or empty($_POST["email"])) {
      echo'<p class="info"><i class="fa fa-info-circle"></i> Fill in everything.</p>';  
    }
    elseif(!preg_match("/^[a-zA-Z ]*$/",$fname) or !preg_match("/^[a-zA-Z ]*$/",$lname) or (!empty($prep) and !preg_match("/^[a-zA-Z ]*$/",$prep))) {
      echo'<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid name.</p>';  
    }
    //or !is_valid_mail($email)
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) or !is_valid_mail($email)) {
      echo'<p class="error"><i class="fa fa-times-circle"></i> Fill in a valid email address.</p>';  
    }
    elseif(!isset($_POST["agreed"])) {
      echo'<p class="info"><i class="fa fa-info-circle"></i> In order to sign up, you have to agree to the Privacy Policy and the Terms of Use.</p>';  
    }
    else {
      include "../../mysql/insert.php";
    }
  }
	?>
                <form method="post" autocomplete="off">
                  <table>
                    <tr><td>Username <span>(required)</span></td><td><input type="text" size="20" name="usname" maxlength="20" placeholder="Username" required></td></tr>
                    <tr><td>Password <span>(required)</span></td><td> <input type="password" id="newpass" size="20" name="pass" maxlength="20" placeholder="Password" required></td></tr>
                    <tr><td>Confirm password <span>(required)</span></td><td> <input type="password" id="confirmnewpass" size="20" name="confirmpass" placeholder="Confirm password"></td></tr>
                    <tr><td>First name <span>(required)</span></td><td><input type="text" size="20" name="fname" maxlength="20" placeholder="First name" required></td></tr>
                    <tr><td>Preposition</td><td><input type="text" size="20" name="prep" maxlength="10" placeholder="Preposition"></td></tr>
                    <tr><td>Last name <span>(required)</span></td><td><input type="text" size="20" name="lname" maxlength="20" placeholder="Last name" required></td></tr>
                    <tr><td>Email address <span>(required)</span></td><td><input type="email" size="20" name="email" maxlength="40" placeholder="Email" required></td></tr>
                  </table>
                  <label>
                    <input type="checkbox" name="agreed" checked="checked" required>
                    I read and agree to the <a href="/terms" target="_blank">Terms of Use</a> and the <a href="/privacy" target="_blank">Privacy Policy</a>.
                  </label>
                  <table><tr><td style="width:180px;"></td><td style="width:11em;"><input type="submit" name="signup" value="Sign up"></td></tr></table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include "../footer.html";?>
      <script type="text/javascript" src="/js/validatePassword.js"></script>
    </div>
  </body>
</html>