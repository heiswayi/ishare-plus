<?php
	require_once('connect_db.php');
	echo implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(id) FROM i_shouts")));
?>