<?php
session_start();
session_regenerate_id();

require('config.php');
mysql_connect($db_host, $db_username, $db_password) or die ("Could not connect to server ... \n" . mysql_error ());
mysql_select_db($db_name) or die ("Could not connect to database ... \n" . mysql_error ());

if (isset($_SESSION['userwd'])) {
  $ishare_username = $_SESSION['userwd'];
  $checkUserInPunBB = mysql_query("SELECT * FROM ".$db_prefix."users WHERE username='$ishare_username'") or die(mysql_error());
  $dapat = mysql_fetch_array($checkUserInPunBB);
  
  if (mysql_num_rows($checkUserInPunBB) == 0) { header('Location: ../register.php'); }
  else {
    $extract_cookie = explode("|", base64_decode($_COOKIE['Ishare_Forum_Board']));
    //echo $extract_cookie[0];
    if ($extract_cookie[0] > 1) { header('Location: home.php'); }
    else { header('Location: ../login.php'); }
  }
} else {
  header('Location: home.php');
}
?>