<?php session_start();$usname=$_SESSION["username"];$fname=$_SESSION["name"];$prep=$_SESSION["prep"];$lname=$_SESSION["lname"];$picture=$_SESSION["picture"];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Karen - AI And You</title>
    <link rel="icon" type="image/x-icon" href="/images/logo/favicon.ico">
    
    <!-- Metadata -->
    <meta charset="utf-8"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
  </head>
  <body>
    <div class="container">
      <?php include "../../pages/header.html";?>

      <div class="content">
        <?php include "../../pages/menu.html";?>

        <div class="row">
          <div class="leftcolumn">
            <div class="card">
              <h2>Karen</h2>
              <form method="post" autocomplete="off">
               Hello stranger you can ask me some questions and I will try my best to answer them. <br>
                <input type="text" name="bericht" autofocus/> 
                <button type="submit" name="send" >Send</button>
                <br><br>   
              </form>
<?php
              session_start();
                
              $x=0;
                  
                if(isset($_POST["send"])) {
                  $antwoord=0;
                  $bericht = $_POST["bericht"];
                  $t_bericht = $bericht;
                  $bericht = mysqli_real_escape_string($mysql,$bericht);
                  $bericht = str_replace("? ","",$bericht);
                  $bericht = str_replace("?","",$bericht);
                  $bericht = str_replace(" karen","",$bericht);
                  $bericht = str_replace(" Karen","",$bericht);
                  
                  while ($antwoord<1)
                  {
                    if(strpos($bericht, 'Hello there') !== false or strpos($bericht, 'hello there') !== false) {
                    $t_antwoord = "General Kenobi. You are a bold one.";$antwoord=1;
                  }
                  elseif(strpos($bericht, 'how are you') !== false or strpos($bericht, 'How are you') !== false) {
                    $t_antwoord = "I'm good, how are you?";$antwoord=1;
                  } 
                  elseif(strpos($bericht, 'hey') !== false or strpos($bericht, 'hi') !== false or strpos($bericht, 'hello') !== false or strpos($bericht, 'Hey') !== false or strpos($bericht, 'Hi') !== false or strpos($bericht, 'Hello') !== false) {
                    $t_antwoord = "Hi there stranger." ;$antwoord=1;
                  }
                  include "Therest.php";

                  include "Have.php"; //Have you

                  include "Are.php"; //Are you

                  include "Wheredoyou.php"; //Where do you
                    if ($antwoord==0){
                      $t_antwoord = "I'm not allowed to comment on that.";
                    }
                  $antwoord=1;
                  }
                 echo "$t_bericht <br>";
                 echo "$t_antwoord";
                  $n_array = 0;
                  $antwoord=0;
                }   
              
              ?>
            </div>
          </div>
          <div class="rightcolumn">
            <?php if($_SESSION["login"]==1) {include "../../chatroom/chatroom.php";}?>
          </div>
        </div>
      </div>

      <?php include "../../pages/footer.html";?>
    </div>
  </body>
</html>