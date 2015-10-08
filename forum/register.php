<?php
session_start();
session_regenerate_id();

include('algorithm.php');
include('../connect_db.php');

function generateKeyPass($length = 6) { 
    $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "o", "p", "r", "s", "t", "u", "v", "x", "y", "z"); 
    $vocals = array("a", "e", "i", "o", "u"); 
    $xpassword = ""; 
    mt_srand ((double) microtime() * 1000000); 
    for ($i = 1; $i <= $length; $i++) 
        $xpassword .= ($i % 2 == 0)?$chars[mt_rand(0, count($chars) - 1)]:$vocals[mt_rand(0, count($vocals) - 1)]; 
    return $xpassword; 
} 

if (isset($_SESSION['userwd'])) {
  $ishare_username = $_SESSION['userwd'];
  $checkUserInIshare = mysql_query("SELECT * FROM i_users WHERE userwd='$ishare_username'") or die(mysql_error());
  $dapat = mysql_fetch_array($checkUserInIshare);
  $ishare_email = $dapat['email'];
  $ishare_keypass = generateKeyPass(10);
  mysql_query("UPDATE i_users SET keypass='$ishare_keypass' WHERE userwd='$ishare_username'") or die(mysql_error());

  $secretkey = 'Ishare+';
  $encrypted_kp = ssl_encrypt($secretkey, $ishare_keypass);
  $encrypted_email = ssl_encrypt($secretkey, $ishare_email);
  $_SESSION['erkp'] = $encrypted_kp;
  $_SESSION['erem'] = $encrypted_email;
  echo 'Registering...';
  sleep(2);
  header('Location: register_proceed.php');
} else {
  header('Location: 404.php');
}

?>