<?php

//if(!defined('NoDirectAccess')){ die('Direct access is not permitted'); }

include('includes.php');
include('settings.php');

$result = mysql_query("SELECT * FROM i_sharerlinks ORDER BY status DESC, sharername ASC") or die(mysql_error());
$total = mysql_num_rows($result);

if (mysql_num_rows($result) > 0) {

echo '<div class="alert alert-info">';
if (isset($_SESSION['userwd'])) { echo 'To edit your sharerlink, just go to Edit Profile.'; } else { echo 'To add your sharerlink here, you need to be registered.'; }
echo '</div>';

echo '<table class="table table-borderz shoutbox-striped sharer">';
echo '<colgroup><col class="span1"><col class="span3"></colgroup>';
echo '<thead>';
echo '<tr>';
echo '<th>Status</th>';
echo '<th>SharerLink <span class="label label-inverse info-tip" title="Total of SharerLink">'.$total.'</span> <span class="label label-info info-tip" title="Automatically updated for every 5 minutes and sorted by random."><i class="icon-info-sign icon-white"></i></span></th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($row = mysql_fetch_array($result)) {
    $sharerdesc = str_replace("\n", " ", $row['sharerdesc']);
    $sharerdesc = str_replace("\r", " ", $row['sharerdesc']);
    //$sharerdesc = htmlspecialchars($row['sharerdesc']);
    $sharername = $row['sharername'];
    $sharerlink = $row['sharerlink'];
    $sharerid   = $row['id'];
    
    echo '<script>';
    echo '!function ($) { $(function(){';
    echo 'var checkInterval' . $sharerid . ';';
    echo 'function check_status' . $sharerid . '(){';
    echo '$.ajax({';
    echo 'type:"GET",';
    echo 'url:"sharerlink_check_home.php?id=' . $sharerid . '&randval=" + Math.random(),';
    echo 'data: "",';
    echo 'cache:false,';
    echo 'success:function(response){';
    echo '$(".indicator-' . $sharerid . '").html(response);';
    echo 'clearTimeout(checkInterval);';
    echo 'checkInterval' . $sharerid . ' = setTimeout(check_status, 240000);';
    echo '}';
    echo '});';
    echo '}';
    echo 'var initializeCheck' . $sharerid . ' = check_status' . $sharerid . '();';
    echo '}) }(window.jQuery)';
    echo '</script>';
    
    echo '<tr>';
    echo '<td class="status"><span class="indicator-' . $sharerid . '"><img src="data:image/gif;base64,R0lGODlhEAAQAJEDALm5udPT0+3t7f///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgADACwAAAAAEAAQAAACLpw/EcisfYQ4zwCA5ExrXJxJyAeJxwWljLY1LJvC6mwaddgO2mr2dw3M8WYhSAEAIfkEBQoAAwAsBwAAAAkACQAAAhOUhjmmyRgCelGq2kbMvIEPeGABACH5BAUKAAMALAoAAgAGAAwAAAIU3CR2aJj9lFShBmPvBEDyrnweWAAAIfkEBQoAAwAsBwAHAAkACQAAAhScLSmHyn9CgENOA4CxWO+bUSFUAAAh+QQFCgADACwCAAoADAAGAAACFNwAZiKKqVh7JoTFkLKxqcF9YqgUACH5BAUKAAMALAAABwAJAAkAAAIUhDGZh+r/QoByupqESFJpOHyQVgAAIfkEBQoAAwAsAAACAAYADAAAAhTcAGaYynoaDDSYaqE2QqjuDeAXFgAh+QQFCgADACwAAAAACQAJAAACFZw/AHhqEdoaMKZJIXt2IwEKTCgiBQA7"></span></td>';
    echo '<td><div style="background:#f3f3f3;padding:5px;border:1px solid #B4BBCD;">';
    echo '<a href="' . $sharerlink . '" target="_blank" class="label label-info" style="font-family: open sans,arial,sans-serif;font-size:12px;"><strong>' . $sharername . '</strong></a>';
    echo '<br />';
    echo '<span style="color:#888;font-size:11px;font-family: open sans,arial,sans-serif;"><i class="icon-signal"></i> ' . shortenurl($sharerlink) . '</span>';
    if ($sharerdesc !== '') {
    echo '<div style="font-size:11px;color:#555;font-family: open sans,arial,sans-serif;"><i class="icon-tags"></i> ' . stripslashes(rtrim($sharerdesc)) . '</div>';
    }
    echo '</div></td></tr>';
    
}

echo '</tbody>';
echo '</table>';

} else {
    echo '<div class="alert alert-warning"><strong>No sharerlink added yet.</strong> To add a sharerlink, you just simply go to <span class="label label-info">Edit Profile</span> and update your profile by filling the SharerLink section.</div>';
}


?>