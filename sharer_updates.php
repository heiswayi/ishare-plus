<?php
session_start();
define('NoDirectAccess', TRUE);
if (!isset($_SESSION['userwd'])) { header('Location: login.php'); }
include('header.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Updates from Sharers</h1>
  <h3>Any shouted messages from sharers with !update command will be saved here</h3>
</div>
</div>

    <div class="container">
    
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">
<?php
include("includes.php");
include('settings.php');
$per_page = 20;
$result = mysql_query("SELECT * FROM i_updates ORDER BY id DESC") or die(mysql_error());
$total_results = mysql_num_rows($result);
$total_pages   = ceil($total_results / $per_page);

// data clearance period
$data_date = time() - 60 * 60 * 24 * 21; // 21 days
$check_data = mysql_query("SELECT * FROM i_updates WHERE `datetime` < {$data_date}") or die(mysql_error());
if (mysql_num_rows($check_data) > 0) {
    mysql_query("DELETE FROM i_updates WHERE `datetime` < {$data_date}");
}

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
    //$start = 0;
    //$end = $per_page; 
    header('Location: 404.php');
}
echo "<div style='padding-bottom:15px;height:30px;' id='more_shouts_nav'>";
echo "<div style='float:left'><a href='index.php' class='btn btn-info'><i class='icon-chevron-left icon-white'></i> Back to Shoutbox</a></div><div style='float:right'>";
if ($show_page > 1 && $show_page < $total_pages) {
    $olderpage = $show_page + 1;
    $newerpage = $show_page - 1;
    $firstpage = 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a href='sharer_updates.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='sharer_updates.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='sharer_updates.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='sharer_updates.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='sharer_updates.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='sharer_updates.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='sharer_updates.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='sharer_updates.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
//for ($i = 1; $i <= $total_pages; $i++)
//{
//        echo "<a href='more_shouts.php?page=$i' class='uiButton uiButtonNormal'>$i</a> ";
//}
echo "</div></div>";
echo '<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>';
//echo '<thead><tr><th class="chatter-box"><span class="ranking-title">TOP 5 SHOUTERS <i class="icon-chevron-right"></i></span></th><th>';
echo '<thead><tr><th colspan="2">';
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
echo '</thead><tbody>';
echo '<tr><td class="request-desc" colspan="2">Type <span class="requestcode">!update Your_Update_Message</span> on the Shoutbox to make your update message appears here.</td></tr>';


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
    $shout_combined = makeClickableLinks(bbCode(mysql_result($result, $i, 'item')));
    $shoutx         = stripslashes(rtrim($shout_combined));
    $class          = $j % 2 === 0 ? 'row_even' : 'row_odd';
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
        // admin
        if (in_array($nick, $admin, true)) {
            $lines[] = '
    <tr class="UfS-showTime-tip" title="' . time_ago($posttime) . '"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a></td>
    <td>' . $shoutx . '';
            $lines[] = '</td></tr>';
            // VIP
        } else if (in_array($nick, $kitty, true)) {
            $lines[] = '
    <tr class="UfS-showTime-tip" title="' . time_ago($posttime) . '"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a></td>
    <td>' . $shoutx . '';
            $lines[] = '</td></tr>';
            // public user
        } else {
            $lines[] = '
    <tr class="UfS-showTime-tip" title="' . time_ago($posttime) . '"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a></td>
    <td>' . $shoutx . '';
            $lines[] = '</td></tr>';
        }
        // public user
    } else {
        $lines[] = '
   <tr class="UfS-showTime-tip" title="' . time_ago($posttime) . '"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a></td>
    <td>' . $shoutx . '';
            $lines[] = '</td></tr>';
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
    echo "<div class='btn-group'><a href='sharer_updates.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='sharer_updates.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='sharer_updates.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='sharer_updates.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='sharer_updates.php?page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='sharer_updates.php?page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='sharer_updates.php?page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='sharer_updates.php?page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
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

<?php include('footer.php'); ?>