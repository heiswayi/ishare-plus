<?php
include('includes.php');
include('settings.php');

// convert plain URL to clickable link (No hashtag)
function makeClickableLinksSR($ret){
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a class=\"label label-info fnote-tip\" title=\"\\2\" href=\"\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a class=\"label label-info fnote-tip\" title=\"\\2\" href=\"http://\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<span class=\"nickname mention\" onclick=\"insertNickname('@\\1')\">@\\1</span>", $ret);
  return $ret;
}

//shout messages
$result = mysql_query("SELECT * FROM i_shouts_sr ORDER BY id DESC LIMIT 15");
$lines  = array();
$i      = 1;

function linkit($text) {
$text = trim($text);
while ($text != stripslashes($text)) { $text = stripslashes($text); }    
$text = strip_tags($text,"<b><i><u>");
$text = preg_replace ("/\[url\=(.*?)](.*?)\[\/url]/is", "<a href='$1' title='$2' target='_blank' class='msg_link'>$2</a>", $text);
return $text;
}
$ann_table = "i_ann";
$checkMsg = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(id) FROM $ann_table")));
if ($checkMsg == 1) {
    $msg_perm = 'Admin';
    $new_result = mysql_query("SELECT * FROM $ann_table WHERE msg_perm='$msg_perm'") or die(mysql_error());
    $new_row = mysql_fetch_array($new_result);
    $msg = $new_row['msg'];
    $msg_type = $new_row['msg_type'];
    $msg_onoff = $new_row['msg_onoff'];
    $msg_date = $new_row['msg_date'];
    if ($msg_onoff == 'enable') {
        echo '<div class="make_ann '.$msg_type.'">';
        echo linkit($msg);
        echo ' <span class="msg_date">'.date('d.m | g:i A', $msg_date).'</span>';
        echo '</div>';
    }
}
    

echo '<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>';
echo '<thead><tr><th class="chatter-box"><span class="ranking-title">CHATBOX <i class="icon-chevron-right"></i></span></th><th>';

echo '</th></tr></thead><tbody>';

while ($shout = mysql_fetch_assoc($result)) {
    $data_date = time() - 60 * 60 * 24 * 7; // 7 days ago
    $check_data = mysql_query("SELECT * FROM i_shouts_sr WHERE `datetime` < {$data_date}") or die(mysql_error());
    if (mysql_num_rows($check_data) > 0) {
        mysql_query("DELETE FROM i_shouts_sr WHERE `datetime` < {$data_date}");
    }
    
    $nick      = $shout['username'];
    $userid    = $shout['id'];
    $posttime  = $shout['datetime'];
    $ori_shout = makeClickableLinksSR(bbCode_sr($shout['shout']));
    $shoutx    = stripslashes(rtrim($ori_shout));
    //$shoutx    = $ori_shout;
    $shoutx    = str_replace("\n", " ", $shoutx);
    $shoutx    = str_replace("\r", " ", $shoutx);
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
            $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
            $lines[] = '</div></td></tr>';
    }
    $i++;
}
echo implode($lines);

echo '</tbody></table>';
?>
