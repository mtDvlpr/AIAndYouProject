<?php
if (strpos($bericht, 'Where do your') !== false) { //Waar ... jouw
                      
                      $vraag = explode("Where do your ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Waar WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Answer FROM Waar WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            $t_antwoord = $Opinion[0];
                              
                               $antwoord=1;
                            }
                              // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                          }
elseif (strpos($bericht, 'Where do you') !== false) { //Waar ... jij
                      
                      $vraag = explode("Where do you ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Waar WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Answer FROM Waar WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            $t_antwoord = $Opinion[0];
                              
                              $antwoord=1;
                            }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                          }
?>