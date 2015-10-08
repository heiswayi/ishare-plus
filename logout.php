<?php
session_start();
unset($_SESSION['userwd']);
include('includes.php');
include('settings.php');
if (isset($_COOKIE[$cookie_name]) && isset($_COOKIE[$cookie_user])) {
    setcookie ($cookie_name, '', time() - $cookie_time);
    setcookie ($cookie_user, '', time() - $cookie_time);
}
if (isset($_COOKIE['Ishare_Forum_Board'])) { setcookie('Ishare_Forum_Board', '', time()-3600); }
session_destroy();
//header('Location: '.$_SERVER['HTTP_REFERER'].'');
header('Location: login.php');
?>