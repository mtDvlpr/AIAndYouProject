<?php
if (strpos($bericht, 'Do you have') !== false) { //Heb jij
                     $bericht = str_replace("any","",$bericht);
                      $vraag = explode("Do you have ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          
                          $sql_query = "SELECT count(*) AS cntWord FROM Have WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Have WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            $vraag[1] = str_replace('your', 'my', $vraag[1]);
                            if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Have (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                            $vraag[1] = str_replace('your', 'my', $vraag[1]);
                            if($opinion == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
elseif (strpos($bericht, 'Do you also have') !== false) { //Heb jij ook
                     
                      $vraag = explode("Do also you have ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Have WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Have WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                           if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Have (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                            if($opinion == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
elseif (strpos($bericht, 'do you have') !== false) { //heb jij
                     
                      $vraag = explode("do you have ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Have WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Have WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            $vraag[1] = str_replace('your', 'my', $vraag[1]);
                            if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Have (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                            $vraag[1] = str_replace('your', 'my', $vraag[1]);
                            if($opinion == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
elseif (strpos($bericht, 'do you also have') !== false) { //heb jij ook
                     
                     $vraag = explode("do you also have ", $bericht);
                      include "connectBot.php";
                      $mysql = mysqli_connect($server,$user,$pass,$db) or die("Fout: Er is geen verbinding met de MySQL-server tot stand gebracht!");
                          // Kijken of woord in de database staat
                          $sql_query = "SELECT count(*) AS cntWord FROM Have WHERE Word='$vraag[1]'";
                          $result = mysqli_query($mysql,$sql_query);
                          $row = mysqli_fetch_array($result);
                          $count = $row['cntWord'];
                          
                          if($count > 0) {
                            $result1 = mysqli_query($mysql,"SELECT Opinion FROM Have WHERE Word = '$vraag[1]'") or die("De selectquery op de database is mislukt!");
                            $Opinion = mysqli_fetch_row($result1);
                            if($Opinion[0] == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($Opinion[0] == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                          else {
                            $opinion = rand(1,2);
                            mysqli_query($mysql,"INSERT INTO Have (word,opinion) VALUES('".$vraag[1]."','".$opinion."')") or die("Error: Inserting the opinion has failed");	
                            if($opinion == 2) { 
                              $t_antwoord = "Yes, I have $vraag[1]";
                              
                            }
                            elseif($opinion == 1) {
                              $t_antwoord = "No, I have no $vraag[1]";
                              
                            }
                          }
                        // Verbinding weer sluiten
                        mysqli_close($mysql) or die("Het verbreken van de verbinding met de MySQL-server is mislukt!");
                        $antwoord=1;
                    }
?>