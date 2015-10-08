<?php
session_start();
session_regenerate_id();
include('../includes.php');
include('../settings.php');
if (!isset($_SESSION['userwd'])) { header('Location: ../404.php'); }
else if (isset($_SESSION['userwd']) && !isset($_SESSION['xuidPJVE218'])) {
    $nick = $_SESSION['userwd'];
    $data = mysql_query("SELECT (userwd) FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    if (mysql_num_rows($data) == 0) { header('Location: ../404.php'); }
    else {
         if (in_array(strtolower($nick), $admin, true)) { header('Location: index.php'); }
         else { header('Location: ../404.php'); }
    }   
}
else
{
    if (isset($_GET['u']))
    {
    $user = clean($_GET['u']);
    $result = mysql_query("DELETE FROM i_bans WHERE username='$user'") or die(mysql_error()); 
    header('Location: users.php');
    }
    else
    {
    header("Location: users.php.php");
    }
}
?>