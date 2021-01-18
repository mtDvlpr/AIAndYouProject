<?php
if (strpos($bericht, 'What') !== false) {}
elseif (strpos($bericht, 'How') !== false){}
else{
if (strpos($bericht, 'Are you') !== false) { //Heb jij
                     $bericht = str_replace("my","your",$bericht);
                      $vraag = explode("Are you ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Are WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Are WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I am $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I am not $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Are (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                            if($opinion == 2) { 
                              $t_antwoord = "Yes, I am $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I am not $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
elseif (strpos($bericht, 'are you') !== false) { //Heb jij
                      $bericht = str_replace("my","your",$bericht);
                      $vraag = explode("are you ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Are WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Are WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                           if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I am $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I am not $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Are (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                           if($opinion == 2) { 
                              $t_antwoord = "Yes, I am $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I am not $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
}

?>