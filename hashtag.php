<?php
session_start();
if (!empty($_GET['q']) && isset($_GET['q'])) {
  include('includes.php');
  include('settings.php');
  $hashtag = clean($_GET['q']);
} else {
  header('Location: 404.php');
}
include('header.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>#hashtag</h1>
  <h3>Some shouting messages that are being grouped by a particular hashtag.</h3>
</div>
</div>

    <div class="container">
      
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">

<div id="shoutbox-reload">
<?php
include("includes.php");
include('settings.php');

//$hashtag = $_SESSION['hashtag1212'];
$find_hashtag = '#'.$hashtag;

$per_page = 25;
$result = mysql_query("SELECT * FROM i_shouts WHERE shout LIKE '%$find_hashtag%' ORDER BY id DESC") or die(mysql_error());
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
        $start = 0;
        $end   = $per_page;
        $show_page = 1;
        //header('Location: index.php');
    }
} else {
    // if page isn't set, show first set of results
    $start = 0;
    $end = $per_page; 
    $show_page = 1;
    //header('Location: 404.php');
}
echo "<div style='padding-bottom:15px;height:30px;' id='more_shouts_nav'>";
echo "<div style='float:left'><a href='index.php' class='btn btn-info'><i class='icon-chevron-left icon-white'></i> Back to Shoutbox</a></div><div style='float:right'>";
if ($show_page > 1 && $show_page < $total_pages) {
    $olderpage = $show_page + 1;
    $newerpage = $show_page - 1;
    $firstpage = 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a href='hashtag_get.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='hashtag_get.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='hashtag_get.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='hashtag_get.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='hashtag_get.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='hashtag_get.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='hashtag_get.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='hashtag_get.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
//for ($i = 1; $i <= $total_pages; $i++)
//{
//        echo "<a href='more_shouts.php?page=$i' class='uiButton uiButtonNormal'>$i</a> ";
//}
echo "</div></div>";
echo '<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>';
echo '<thead><tr><th class="chatter-box"><span class="ranking-title">TOP 5 SHOUTERS <i class="icon-chevron-right"></i></span></th><th>';
$topuser = mysql_query("SELECT username, COUNT(username) AS top5 FROM i_shouts GROUP BY username ORDER BY top5 DESC LIMIT 5");
$rankz   = 1;
echo '<div class="ranking">';
while ($userz = mysql_fetch_assoc($topuser)) {
    $poster = $userz['username'];
    $noofmsg  = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(shout) FROM i_shouts WHERE username='$poster'")));
    echo '<span class="user-rank rank-' . $rankz . ' rankno" title="Rank No. '.$rankz.'"><a href="profile.php?user=' . $poster . '">' . $poster . '</a> <strong>' . $noofmsg . '</strong></span> ';
    $rankz++;
}
echo '</div>';
echo '</th></tr>';
if ($show_page == 1) {
echo '<tr class="usermsg"><th style="text-align:right;"><span class="label label-info"><i class="icon-info-sign icon-white"></i> Info</span></th><th>Found '.$total_results.' message(s) with hashtag: <span class="label label-success">#'.stripslashes(rtrim($hashtag)).'</span></th></tr>';
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
        // check shoutmsg of each user
        $total_usershouts = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(shout) FROM i_shouts WHERE username='$nick'")));
        // admin
        if (in_array(strtolower($nick), $admin, true)) {
            $lines[] = '
    <tr><td class="chatter-box"><span class="mark_admin">ADMIN</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
            $lines[] = '</div></td></tr>
    ';
            // VIP
        } else if (in_array(strtolower($nick), $kitty, true)) {
            $lines[] = '
    <tr><td class="chatter-box"><span class="mark_vip">VIP</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
            $lines[] = '</div></td></tr>
    ';
        // pangkat
        } else if ($total_usershouts >= 150 && !in_array(strtolower($nick), $kitty, true) && !in_array(strtolower($nick), $admin, true)) {
            if ($total_usershouts >= 400) {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;&#9733;&#9733;</span></span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 330) {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;&#9733;</span>&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 300) {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;</span>&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 250) {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;</span>&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 200) {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;</span>&#9734;&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            else {
                $lines[] = '
    <tr><td class="chatter-box"><span class="mark_rank">&#9734;&#9734;&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '</div></td></tr>';
            }
            // public user
        } else {
            $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
            $lines[] = '</div></td></tr>
    ';
        }
        // public user
    } else {
        $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
        $lines[] = '</div></td></tr>
    ';
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
    echo "<div class='btn-group'><a href='hashtag_get.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='hashtag_get.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='hashtag_get.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='hashtag_get.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='hashtag_get.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='hashtag_get.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='hashtag_get.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='hashtag_get.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
echo "</div></div>";
?>
</div>

</div>

        </div><!--/span-->
        <div class="span4">
          <div class="well special-bg">
          <div id="sharerlink-reload"><?php include('sharerlink.php'); ?></div>
          </div><!--/well-->
        </div><!--/span-->
      </div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->
    
<?php include('footer.php'); ?>