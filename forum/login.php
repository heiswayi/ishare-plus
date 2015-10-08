<?php
session_start();
session_regenerate_id();

include('algorithm.php');
include('../connect_db.php');

if (isset($_SESSION['userwd'])) {
  $ishare_username = $_SESSION['userwd'];
  $checkUserInIshare = mysql_query("SELECT * FROM i_users WHERE userwd='$ishare_username'") or die(mysql_error());
  $dapat = mysql_fetch_array($checkUserInIshare);
  $ishare_keypass = $dapat['keypass'];

  //$secretkey = 'Ishare+';
  //$encrypted_kp = ssl_encrypt($secretkey, $ishare_keypass);
  //$_SESSION['ekp'] = $encrypted_kp;
  
  $_SESSION['ekp'] = $ishare_keypass; // Not Safe. Hackable!
  echo 'Logging in...';
  sleep(2);
  header('Location: login_proceed.php');
} else {
  header('Location: 404.php');
}

?>