<?php
include('includes.php');
include('settings.php');

//shout messages
$result = mysql_query("SELECT * FROM i_shouts ORDER BY id DESC LIMIT 15");
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
//echo '<thead><tr><th class="chatter-box"><span class="ranking-title">TOP 5 SHOUTERS <i class="icon-chevron-right"></i></span></th><th>';
echo '<thead><tr><th colspan="2">';
$topuser = mysql_query("SELECT username, COUNT(username) AS top5 FROM i_shouts GROUP BY username ORDER BY top5 DESC LIMIT 5");
$rankz   = 1;
echo '<div class="ranking">';
while ($userz = mysql_fetch_assoc($topuser)) {
    $username = $userz['username'];
    $noofmsg  = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(shout) FROM i_shouts WHERE username='$username'")));
    echo '<span class="user-rank rank-' . $rankz . '"><a href="profile.php?user=' . $username . '">' . $username . '</a> <strong>' . $noofmsg . '</strong></span> ';
    $rankz++;
}
echo '</div>';
echo '</th></tr></thead><tbody>';

while ($shout = mysql_fetch_assoc($result)) {
    $data_date = time() - 60 * 60 * 24 * 7; // 7 days ago
    $check_data = mysql_query("SELECT * FROM i_shouts WHERE `datetime` < {$data_date}") or die(mysql_error());
    if (mysql_num_rows($check_data) > 0) {
        mysql_query("DELETE FROM i_shouts WHERE `datetime` < {$data_date}");
    }
    
    $nick      = $shout['username'];
    $userid    = $shout['id'];
    $posttime  = $shout['datetime'];
    $ori_shout = makeClickableLinks(bbCode($shout['shout']));
    $shoutx    = stripslashes(rtrim($ori_shout));
    //$shoutx    = $ori_shout;
    $shoutx    = str_replace("\n", " ", $shoutx);
    $shoutx    = str_replace("\r", " ", $shoutx);
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
        // check shoutmsg of each user
        $total_usershouts = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(shout) FROM i_shouts WHERE username='$nick'")));
        // admin
        if (in_array(strtolower($nick), $admin, true)) {
            $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_admin">ADMIN</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
            $lines[] = '</div></td></tr>
    ';
            // VIP
        } else if (in_array(strtolower($nick), $kitty, true)) {
            $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_vip">VIP</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
            $lines[] = '</div></td></tr>
    ';
        // pangkat
        } else if ($total_usershouts >= 150 && !in_array(strtolower($nick), $kitty, true) && !in_array(strtolower($nick), $admin, true)) {
            if ($total_usershouts >= 400) {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;&#9733;&#9733;</span></span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 350) {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;&#9733;</span>&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 300) {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;&#9733;</span>&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 250) {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;&#9733;</span>&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            else if ($total_usershouts >= 200) {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank"><span class="star">&#9733;</span>&#9734;&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            else {
                $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><span class="mark_rank">&#9734;&#9734;&#9734;&#9734;&#9734;</span> <a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
                $lines[] = '</div></td></tr>';
            }
            // public user
        } else {
            $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
                $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
            $lines[] = '</div></td></tr>
    ';
        }
        // public user
    } else {
        $lines[] = '
    <tr onmouseover="document.getElementById(\'timeago-' . $userid . '\').style.display = \'block\'" onmouseout="document.getElementById(\'timeago-' . $userid . '\').style.display = \'none\'"><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View '.$nick.' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" id="timeago-' . $userid . '" style="display:none;text-align:right;">';
            $lines[] = '<span class="label label-success reply-nick" style="font-weight:normal;" onclick="insertNickname(\'@' . $nick . '\')"><i class="icon-retweet icon-white"></i> Reply</span> ';
        $lines[] = '</div></td></tr>
    ';
    }
    $i++;
}
echo implode($lines);

echo '</tbody></table>';
?>
