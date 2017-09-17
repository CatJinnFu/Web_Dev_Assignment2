<?php
  /* Set oracle user login and password info */
  $dbuser = "schmidd";  /* your deakin login */
  $dbpass = "22pelf74";  /* your deakin password */
  $dbname = "SSID"; 
  $db = oci_connect($dbuser, $dbpass, $dbname); 

  if (!$db)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

?>