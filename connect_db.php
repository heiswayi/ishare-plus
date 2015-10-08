<?php
// Database Variables (edit with your own server information)
 $server = 'localhost';
 $user = 'root';
 $pass = 'toor';
 $db = 'ishare';
 
 // Connect to Database
 $connection = mysql_connect($server, $user, $pass) 
 or die ("Could not connect to server ... \n" . mysql_error ());
 mysql_select_db($db) 
 or die ("Could not connect to database ... \n" . mysql_error ());
 
 $cookie_name = 'siteAuth';
 $cookie_user = 'userAuth';
 $cookie_time = (3600 * 24 * 30); // 30 days
 
?>