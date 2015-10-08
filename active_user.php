<?php
include('includes.php');
include('settings.php');

$stringIp = $_SERVER['REMOTE_ADDR'];
$intIp = ip2long($stringIp);

$inDB = mysql_query("SELECT 1 FROM i_online WHERE ip=".$intIp);

if(!mysql_num_rows($inDB))
{
	mysql_query("	INSERT INTO i_online (ip)
					VALUES(".$intIp.")");
}
else
{
	mysql_query("UPDATE i_online SET dt=NOW() WHERE ip=".$intIp);
}

// Removing entries not updated in the last 5 minutes:
mysql_query("DELETE FROM i_online WHERE dt<SUBTIME(NOW(),'0 0:5:0')");

// Counting all the online visitors:
list($totalOnline) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM i_online"));

// Outputting the number as plain text:
if ($totalOnline == 1) {
    echo '<i class="icon-eye-open"></i> '.$totalOnline;
} else {
    echo '<i class="icon-eye-open"></i> '.$totalOnline;
}

?>