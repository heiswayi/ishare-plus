<?php
session_start();
define('NoDirectAccess', TRUE);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ishare+ | Portal of Sharers</title>
    <meta name="description" content="A digital place for USM Engineering Campus students to share their stuffs and chat with people.">
    <meta name="author" content="Heiswayi Nrird">

    <!-- Le styles -->
    <link href="assets/css/ishare.css" rel="stylesheet">
    <style type="text/css">
      body { padding-bottom: 40px; }
    </style>
    <link href="assets/css/silent_room.css?<?php echo "20121202"; ?>" rel="stylesheet">
    <link href="assets/css/typeface.css" rel="stylesheet">
    <link href="assets/css/event-ticker.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="assets/css/ie-suck.css" />
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    
    <script src="assets/js/jquery.js"></script>

  </head>

  <body>
  
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="index.php">Ishare<strong style="color:#ee0000">+</strong></a>
          <?php if(isset($_SESSION['userwd'])){ ?>
          <div class="btn-group pull-right">
          <a class="btn btn-danger" href="index.php">Home</a>
            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $_SESSION['userwd']; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="profile.php?user=<?php echo $_SESSION['userwd']; ?>">View Profile</a></li>
              <li><a href="edit.php?user=<?php echo $_SESSION['userwd']; ?>">Edit Profile</a></li>
              <?php
              include('settings.php');
              $nickCheck = $_SESSION['userwd'];
              if (in_array(strtolower($nickCheck), $admin, true)) {
                  echo '<li class="divider"></li>';
                  echo '<li><a href="admin">Administration</a></li>';
              }
              ?>
              <li class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
          
          <?php } ?>
        </div>
      </div>
    </div>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Silent Room</h1>
  <h3>A serious corner of chatting. No emoticons, no features and a boring place to be.</h3>
</div>
</div>

    <div class="container">
      
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">

<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (!preg_match('/Chrome/i', $user_agent)) { 
echo '<div id="for-chrome">';
echo '<span class="label label-info">Whassup?!</span> Get <strong><a href="http://www.google.com/chrome/" target="_blank">Google Chrome</a></strong> for better experience in browsing the Internet. It\' fast and free web browser!';
echo '</div>';
}
?>

 <form class="form-horizontal" action="" method="post" onsubmit="return push_shout()">
<?php
if(isset($_SESSION['userwd'])){
  echo '<input type="hidden" name="user" id="user" value="'.$_SESSION['userwd'].'">';
} else {
	header('Location: login.php');
}
?>
<input type="hidden" name="antispam" id="antispam" value="" />
<div class="shouting-section">
<textarea class="shouting-box" placeholder="Keep quiet..." name="shout" id="shout" rows="3" maxlength="500"></textarea>
<div class="shouting-function">
<span class="shouting-count"><span id="charcount">500</span></span>
<span id="active-user" class="active-user"><?php include('active_user.php'); ?></span>
<span id="total-user" class="active-user"><i class="icon-user"></i> 
<?php
include('includes.php');
$totaluser = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(userwd) FROM i_users")));
echo $totaluser;
?>
</span>
<span class="shouting-btn">
<select id="select-colors" class="color-text" name="color-text" onChange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor;">
   <option value="default" class="default" style="background:#333;color:#fff">Default</option>
   <option value="blue" class="blue" style="background:#049cdb;color:#fff">Blue</option>
   <option value="green" class="green" style="background:#46a546;color:#fff">Green</option>
   <option value="red" class="red" style="background:#9d261d;color:#fff">Red</option>
   <option value="yellow" class="yellow" style="background:#ffc40d;color:#fff">Yellow</option>
   <option value="orange" class="orange" style="background:#f89406;color:#fff">Orange</option>
   <option value="pink" class="pink" style="background:#c3325f;color:#fff">Pink</option>
   <option value="purple" class="purple" style="background:#7a43b6;color:#fff">Purple</option>
</select> 
<input type="submit" class="btn btn-info" value="SHOUT">
</span>
</div><!--/shouting-function-->

</div><!--/shouting-section-->

</form>

<div id="console" class="alert alert-error" style="display:none"></div>

<script type="text/javascript">
function $(a){return document.getElementById(a)}function urlencode(a){a=(a+"").toString();return encodeURIComponent(a).replace(/!/g,"%21").replace(/'/g,"%27").replace(/\(/g,"%28").replace(/\)/g,"%29").replace(/\*/g,"%2A").replace(/%20/g,"+")}function shouts(){clearTimeout(getshout);var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("GET","shouts_sr.php?i="+Math.random(),true);a.onreadystatechange=function(){if(this.readyState==4){if(parseInt(this.responseText)>current_shouts){getshouts();current_shouts=parseInt(this.responseText)}getshout=setTimeout("shouts()",1e3)}};a.send(null)}function getshouts(){var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("GET","get_shouts_sr.php?i="+Math.random(),true);a.onreadystatechange=function(){if(this.readyState==4)$("shoutbox-reload-sr").innerHTML=this.responseText};a.send(null)}function push_shout(){shouting();return false}function shouting(){var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("POST","post_shout_sr.php",true);var b="user="+urlencode($("user").value)+"&"+"shout="+urlencode($("shout").value)+"&"+"color-text="+urlencode($("select-colors").value)+"&"+"antispam="+urlencode($("antispam").value);a.setRequestHeader("Content-type","application/x-www-form-urlencoded");a.setRequestHeader("Content-length",b.length);a.onreadystatechange=function(){if(this.readyState==4){if(!this.responseText)$("shout").value="";else{$("console").style.display="";$("console").innerHTML=this.responseText;setTimeout("$('console').style.display='none';$('console').innerHTML = ''",3e3)}getshouts()}};a.send(b);return true}var current_shouts=0;var getshout=setTimeout("shouts()",1e3)
</script>

<div id="shoutbox-reload-sr"><?php include('get_shouts_sr.php'); ?></div>
<div class="archived-nav"><a href="more_sr.php?page=2" class="label label-inverse arc-btn-tip" title="Show previous shouted messages">View Archived Messages <i class="icon-chevron-right icon-white"></i></a></div>
</div>

<div class="well special-bg"><div id="latest-updates"><?php include('latest_updates.php'); ?></div></div>

<div class="well special-bg"><div id="latest-requests"><?php include('latest_requests.php'); ?></div></div>

        </div><!--/span-->
        <div class="span4">
          <div class="well special-bg">
          <div id="sharerlink-reload"><?php include('sharerlink.php'); ?></div>
          </div><!--/well-->
        </div><!--/span-->
      </div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->
    
<div id="campus-event"><?php include('campus_event.php'); ?></div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/ishare-transition.js"></script>
    <script src="assets/js/ishare-alert.js"></script>
    <script src="assets/js/ishare-modal.js"></script>
    <script src="assets/js/ishare-dropdown.js"></script>
    <script src="assets/js/ishare-scrollspy.js"></script>
    <script src="assets/js/ishare-tab.js"></script>
    <script src="assets/js/ishare-tooltip.js"></script>
    <script src="assets/js/ishare-popover.js"></script>
    <script src="assets/js/ishare-button.js"></script>
    <script src="assets/js/ishare-collapse.js"></script>
    <script src="assets/js/ishare-carousel.js"></script>
    <script src="assets/js/ishare-typeahead.js"></script>
    <script src="assets/js/jquery.popupWindow.js"></script>
    <script src="assets/js/application.js"></script>
    <script src="assets/js/shoutbox.js"></script>
    <script src="assets/js/scrolltopcontrol.js"></script>

  </body>
</html>