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
  <h1>Archived Messages</h1>
  <h3>Previous shouted messages by users.</h3>
</div>
</div>

    <div class="container">
      
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">
<?php
include("includes.php");
include('settings.php');
$per_page = 15;
$result = mysql_query("SELECT * FROM i_shouts_sr ORDER BY id DESC") or die(mysql_error());
$total_results = mysql_num_rows($result);
$total_pages   = ceil($total_results / $per_page);

if (!empty($_GET['page']) && isset($_GET['page']) && is_numeric($_GET['page'])) {
    $show_page = clean($_GET['page']);
    
    // make sure the $show_page value is valid
    if ($show_page > 0 && $show_page <= $total_pages) {
        $start = ($show_page - 1) * $per_page;
        $end   = $start + $per_page;
    } else {
        // error - show first set of results
        //$start = 0;
        //$end   = $per_page;
        //$show_page = 1;
        header('Location: silent_room.php');
    }
} else {
    // if page isn't set, show first set of results
    //$start = 0;
    //$end = $per_page; 
    header('Location: 404.php');
}
echo "<div style='padding-bottom:15px;height:30px;' id='more_shouts_nav'>";
echo "<div style='float:left'><a href='silent_room.php' class='btn btn-info'><i class='icon-chevron-left icon-white'></i> Back to Shoutbox</a></div><div style='float:right'>";
if ($show_page > 1 && $show_page < $total_pages) {
    $olderpage = $show_page + 1;
    $newerpage = $show_page - 1;
    $firstpage = 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a href='more_sr.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='more_sr.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='more_sr.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='more_sr.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='more_sr.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='more_sr.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='more_sr.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='more_sr.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
//for ($i = 1; $i <= $total_pages; $i++)
//{
//        echo "<a href='more_shouts.php?page=$i' class='uiButton uiButtonNormal'>$i</a> ";
//}
echo "</div></div>";
echo '<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>';
echo '<thead><tr><th class="chatter-box"><span class="ranking-title">CHATBOX <i class="icon-chevron-right"></i></span></th><th>';
echo '</th></tr>';
if ($show_page == 1) {
echo '<tr class="usermsg"><th style="text-align:right;"><span class="label label-info"><i class="icon-info-sign icon-white"></i> Info</span></th><th><i class="icon-comment icon-white"></i> You are viewing the latest 15 shouted messages. <a href="index.php" class="label label-warning"><i class="icon-home icon-white"></i> Back to Shoutbox</a></th></tr>';
echo '</thead><tbody>';
} else {
echo '<tr class="usermsg"><th style="text-align:right;"><span class="label label-info"><i class="icon-info-sign icon-white"></i> Info</span></th><th><i class="icon-comment icon-white"></i> You are viewing the archived messages within 7 days.</th></tr>';
echo '</thead><tbody>';
}
$lines = array();
$j     = 1;
for ($i = $start; $i < $end; $i++) {
    // make sure that PHP doesn't try to show results that don't exist
    if ($i == $total_results) {
        break;
    }
    $userid         = mysql_result($result, $i, 'id');
    $nick           = mysql_result($result, $i, 'username');
    $posttime       = mysql_result($result, $i, 'datetime');
    $shout_combined = makeClickableLinks(bbCode(mysql_result($result, $i, 'shout')));
    $shoutx         = stripslashes(rtrim($shout_combined));
    $class          = $j % 2 === 0 ? 'row_even' : 'row_odd';
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
            $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
            $lines[] = '</div></td></tr>';
    }
    $j++;
}
echo implode($lines);
echo '</tbody></table>';

echo "<div style='padding-top:15px;height:30px'><div style='float:right'>";
if ($show_page > 1 && $show_page < $total_pages) {
    $olderpage = $show_page + 1;
    $newerpage = $show_page - 1;
    $firstpage = 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a href='more_sr.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='more_sr.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='more_sr.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='more_sr.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='more_sr.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='more_sr.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='more_sr.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='more_sr.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
echo "</div></div>";

?>
</div>

        </div><!--/span-->
        <div class="span4">
          <div class="well special-bg">
          <?php include('sharerlink.php'); ?>
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