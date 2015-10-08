<?php
session_start();
include('header.php');
if (!empty($_GET['user']) && isset($_GET['user'])) {
include('includes.php');
include('settings.php');
$nickname = clean($_GET['user']);
$userDB = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
if (mysql_num_rows($userDB) == 0) { header('Location: 404.php'); } // check user existance in database
$userdata = mysql_fetch_array($userDB);

//$result = mysql_query("SELECT * FROM isbshout WHERE username='$nickname' ORDER BY id DESC LIMIT 50");
$per_page = 20;
$result = mysql_query("SELECT * FROM i_shouts WHERE username='$nickname' ORDER BY id DESC") or die(mysql_error());
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
        header('Location: 404.php');
    }
} else {
    //header('Location: 404.php');
    $start = 0;
    $end   = $per_page;
    $show_page = 1;
}

$lines  = array();
$i      = 1;
$topuser = mysql_query("SELECT username, COUNT(username) AS top5 FROM i_shouts GROUP BY username ORDER BY top5 DESC LIMIT 5");
$rankz   = 1;
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1><?php echo $nickname; ?></h1>
  <h3><?php if ($userdata['tagline']) { echo stripslashes(rtrim($userdata['tagline'])); } else { echo ''; } ?></h3>
</div>
</div>

    <div class="container">
    
      <div class="row">
        <div class="span4">
    
<div class="well special-bg">
<table class="table table-borderz table-override" id="profile">
<colgroup><col class="span2"><col class="span3"></colgroup>
<thead>
<tr>
<th>Information</th>
<th></th>
</tr>
</thead>
<tbody>

<?php
$userProfile = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
$userdatax = mysql_fetch_array($userProfile);
if ($userdatax) {
    $username   = $userdatax['userwd'];
    $fullname   = $userdatax['fullname'];
    $regtime0   = $userdatax['reg_time'];
    $freenote   = str_replace("\n", " ", $userdatax['free_note']);
    $freenote   = str_replace("\r", " ", $userdatax['free_note']);
    
    if ($regtime0 == '') { $regtime = 'Undefined'; }
    else { $regtime = date('j F Y, g:i A', $regtime0); }
    
    echo '<tr>';
    echo '<td class="user-info-label">Username</td>';
    echo '<td><strong>'.$username.'</strong></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Name</td>';
    if ($fullname) { echo '<td>'.$fullname.'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Registered on</td>';
    echo '<td>'.$regtime.'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Free note</td>';
    if ($freenote) { echo '<td>'.linkThisOne(stripslashes(rtrim($freenote))).'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
}
$sharerProfile = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$nickname'") or die(mysql_error());
$sharerdatax = mysql_fetch_array($sharerProfile);
    if ($sharerdatax) {
        $sharerdesc = str_replace("\n", " ", $sharerdatax['sharerdesc']);
        $sharerdesc = str_replace("\r", " ", $sharerdatax['sharerdesc']);
        $sharername = $sharerdatax['sharername'];
        $sharerlink = $sharerdatax['sharerlink'];
        $sharerid   = $sharerdatax['id'];
        
        echo '<script>';
        echo '!function ($) { $(function(){';
        echo 'var checkInterval' . $sharerid . ';';
        echo 'function check_status' . $sharerid . '(){';
        echo '$.ajax({';
        echo 'type:"GET",';
        echo 'url:"sharerlink_check.php?id=' . $sharerid . '&randval=" + Math.random(),';
        echo 'data: "",';
        echo 'cache:false,';
        echo 'success:function(response){';
        echo '$(".indicator-' . $sharerid . '").html(response);';
        echo 'clearTimeout(checkInterval);';
        echo 'checkInterval' . $sharerid . ' = setTimeout(check_status, 300000);';
        echo '}';
        echo '});';
        echo '}';
        echo 'var initializeCheck' . $sharerid . ' = check_status' . $sharerid . '();';
        echo '}) }(window.jQuery)';
        echo '</script>';
        
        echo '<tr>';
        echo '<td class="user-info-label">Sharer name</td>';
        echo '<td style="background:#f3f3f3"><span class="label label-info">'.$sharername.'</span> <span class="indicator-'.$sharerid.'"><img src="data:image/gif;base64,R0lGODlhEAAQAJEDALm5udPT0+3t7f///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgADACwAAAAAEAAQAAACLpw/EcisfYQ4zwCA5ExrXJxJyAeJxwWljLY1LJvC6mwaddgO2mr2dw3M8WYhSAEAIfkEBQoAAwAsBwAAAAkACQAAAhOUhjmmyRgCelGq2kbMvIEPeGABACH5BAUKAAMALAoAAgAGAAwAAAIU3CR2aJj9lFShBmPvBEDyrnweWAAAIfkEBQoAAwAsBwAHAAkACQAAAhScLSmHyn9CgENOA4CxWO+bUSFUAAAh+QQFCgADACwCAAoADAAGAAACFNwAZiKKqVh7JoTFkLKxqcF9YqgUACH5BAUKAAMALAAABwAJAAkAAAIUhDGZh+r/QoByupqESFJpOHyQVgAAIfkEBQoAAwAsAAACAAYADAAAAhTcAGaYynoaDDSYaqE2QqjuDeAXFgAh+QQFCgADACwAAAAACQAJAAACFZw/AHhqEdoaMKZJIXt2IwEKTCgiBQA7"></span></td>';
        echo '</tr>';
        echo '<tr>';   
        echo '<td class="user-info-label">Sharer link</td>';
        echo '<td style="background:#f3f3f3"><a href="'.$sharerlink.'">'.$sharerlink.'</a></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="user-info-label">Sharer description</td>';
        echo '<td style="background:#f3f3f3">'.stripslashes(rtrim($sharerdesc)).'</td>';
        echo '</tr>';
    }

?>

</tbody>
</table>

</div>

        </div><!--/span-->
        <div class="span8">
          <div class="well special-bg">
            
<?php
echo "<div style='padding-bottom:15px;height:30px;' id='more_shouts_nav'>";
echo "<div style='float:left'><a href='index.php' class='btn btn-info'><i class='icon-home icon-white'></i> Home</a></div><div style='float:right'>";
if ($show_page > 1 && $show_page < $total_pages) {
    $olderpage = $show_page + 1;
    $newerpage = $show_page - 1;
    $firstpage = 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a href='profile.php?user=$nickname&page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='profile.php?user=$nickname&page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='profile.php?user=$nickname&page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='profile.php?user=$nickname&page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == 1) {
    $olderpage = $show_page + 1;
    $lastpage  = $total_pages;
    echo "<div class='btn-group'><a class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a href='profile.php?user=$nickname&page=$olderpage' class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a href='profile.php?user=$nickname&page=$lastpage' class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
} else if ($show_page == $total_pages) {
    $newerpage = $show_page - 1;
    $firstpage = 1;
    echo "<div class='btn-group'><a href='profile.php?user=$nickname&page=$firstpage' class='btn nav-tip' title='Show Newest Messages'><i class='icon-fast-backward'></i></a><a href='profile.php?user=$nickname&page=$newerpage' class='btn nav-tip' title='Show Newer Messages'><i class='icon-backward'></i></a><a class='btn'>Page: $show_page of $total_pages</a><a class='btn nav-tip' title='Show Older Messages'><i class='icon-forward'></i></a><a class='btn nav-tip' title='Show Oldest Messages'><i class='icon-fast-forward'></i></a></div>";
}
//for ($i = 1; $i <= $total_pages; $i++)
//{
//        echo "<a href='more_shouts.php?page=$i' class='uiButton uiButtonNormal'>$i</a> ";
//}
echo "</div></div>";
?>

<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>
<!--<thead><tr><th style="text-align:center;"><span class="ranking-title">TOP 5 SHOUTERS <i class="icon-chevron-right"></i></span></th><th>-->
<thead><tr><th colspan="2">
<div class="ranking">
<?php
while ($userz = mysql_fetch_assoc($topuser)) {
    $poster = $userz['username'];
    $noofmsg  = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(shout) FROM i_shouts WHERE username='$poster'")));
    echo '<span class="user-rank rank-' . $rankz . ' rankno" title="Rank No. '.$rankz.'"><a href="profile.php?user=' . $poster . '">' . $poster . '</a> <strong>' . $noofmsg . '</strong></span> ';
    $rankz++;
}
?>
</div>
</th></tr>
<tr class="usermsg"><th style="text-align:center;"><i class="icon-time icon-white"></i> Time</th><th><i class="icon-pencil icon-white"></i> 
<?php
if ($show_page == 1) { echo 'Latest 20 Messages shouted by'; }
else { echo 'Messages shouted by'; }
?>
 <span class="label label-warning"><i class="icon-user icon-white"></i> <?php echo $nickname; ?></span></th></tr>
</thead><tbody>
<?php
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
    
    $data_date = time() - 60 * 60 * 24 * 7; // 7 days ago
    $check_data = mysql_query("SELECT * FROM i_shouts WHERE `datetime` < {$data_date}") or die(mysql_error());
    if (mysql_num_rows($check_data) > 0) {
        mysql_query("DELETE FROM i_shouts WHERE `datetime` < {$data_date}");
    }
    
        $lines[] = '
    <tr><td style="text-align:center;"><span class="label label-inverse">' . date('j F, g:i A', $posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
    $j++;
}
echo implode($lines);
?>
</tbody></table>



          </div><!--/well-->
        </div><!--/span-->
      </div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->

<?php
} else { header('Location: 404.php'); }
include('footer.php');
?>