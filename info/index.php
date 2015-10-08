<!DOCTYPE html> <!-- W3C Polyglot HTML5 Markup Guidelines : http://goo.gl/Rboe5 -->
<!-- Conditional hacks for IE by Paul Irish : http://goo.gl/Uewbx -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en">        <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en">               <![endif]-->
<!--[if gt IE 8]> <!--> <html class="no-js" lang="en">                <!--<![endif]-->
	<head>
		<!-- Character Encoding : All markup delivered as UTF-8, as its the most friendly for internationalization. -->
		<meta charset="utf-8">
		
		<!-- Chrome Frame for IE : http://goo.gl/GRNYi -->	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- Single most valid html tag : http://goo.gl/knLx6-->		
		<title>//info $me</title>
		
		<!-- Enable manual DNS pre-fetching :  http://goo.gl/8HTJy-->
		<link rel="dns-prefetch" href="//html5shiv.googlecode.com/">		<!-- To enable html5 elements   -->

		<!-- Reset CSS -->
		<!-- For Legacy Browsers -->
		<link rel="stylesheet" href="css/reset.css">
		<!-- For Non-Legacy Browsers -->
		<link rel="stylesheet" href="css/normalize.css">
		
		<!-- Site specific stylesheet -->
		<link rel="stylesheet" href="css/style.css">
		
		<!-- Suppress IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="false">
		
		<!-- Enable HTML5 tags for legacy IE browsers : http://goo.gl/gWcE8 -->
 		<!--[if lt IE 9]>
        	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

	</head>
	<body id="body">
		<!-- Prompt IE6 users to install Chrome Frame : chromium.org/developers/how-tos/chrome-frame-getting-started -->
		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
		<div id="container">
			<div id="head">
			<pre>
     _____        __         _                 
    / / (_)      / _|       | |                
   / / / _ _ __ | |_ ___   / __)_ __ ___   ___ 
  / / / | | '_ \|  _/ _ \  \__ \ '_ ` _ \ / _ \
 / / /  | | | | | || (_) | (   / | | | | |  __/
/_/_/   |_|_| |_|_| \___/   |_||_| |_| |_|\___|
      </pre>
			script written by heiswayi nrird
			</div>
			
			
			<div id="output">

<table class="info"><tbody>

<?php
// required functions
require("UAParser.php");
$ua = UA::parse();
if (!empty($_SERVER['HTTP_CLIENT_IP'])) { $iplocal=$_SERVER['HTTP_CLIENT_IP']; }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { $iplocal=$_SERVER['HTTP_X_FORWARDED_FOR']; }
else { $iplocal=$_SERVER['REMOTE_ADDR']; }
$file = file_get_contents('http://ip6.me/');
$pos = strpos( $file, '+3' ) + 3;
$ip = substr( $file, $pos, strlen( $file ) );
$pos = strpos( $ip, '</' );
$ip = substr( $ip, 0, $pos );

// display data
echo '<tr><td class="label">web_browser:</td><td>' . $ua->browserFull . '</td></tr>';
echo '<tr><td class="label">operating_system:</td><td>' . $ua->osFull . '</td></tr>';
echo '<tr><td class="label">user_agent:</td><td>' . $ua->uaOriginal . '</td></tr>';
echo '<tr><td class="label">client_ip:</td><td>' . $iplocal . '</td></tr>';
echo '<tr><td class="label">server_ip:</td><td>' . $ip . '</td></tr>';
?>

</tbody></table>

<div id="geo" class="geolocation_data"></div>
<script type="text/JavaScript" src="geo.js"></script>


			</div>
		</div>		
		
		<!-- JavaScript at the bottom for fast page loading -->

	</body>
</html>
