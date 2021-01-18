<?php
                      session_start();
                      
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $vraag=$bericht;
                          $sql_query = "SELECT count(*) AS cntWord FROM Alles WHERE Vraag='$vraag'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Antwoord FROM Alles WHERE Vraag = '$vraag'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            $t_antwoord = $Opinion[0];
                            $t_antwoord = mysqli_real_escape_string($mysql,$t_antwoord);
                              $antwoord=1;
                            }
                            
                              // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");


?>