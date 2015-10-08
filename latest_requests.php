<?php
include('includes.php');
include('settings.php');

//shout messages
$result = mysql_query("SELECT * FROM i_requests ORDER BY id DESC LIMIT 10");
$lines  = array();

if (mysql_num_rows($result) == 0) {
    echo '<div class="alert alert-block"><h4 class="alert-heading">Oops!</h4>
    There is no any <span class="requestcode">!request</span> from any user yet!</div>';
} else {

echo '<table class="table table-borderz shoutbox-striped table-override" id="shoutbox-table"><colgroup><col class="span2"><col class="span6"></colgroup>';
echo '<thead><tr><th></th><th>Latest <span class="requestcode">!request</span> from Users ';
echo ' <a href="request_shouts.php?page=1" class="label label-success">More...</a></th></tr></thead><tbody>';

while ($shout = mysql_fetch_assoc($result)) {
    // data clearance period
    $data_date = time() - 60 * 60 * 24 * 21; // 21 days
    $check_data = mysql_query("SELECT * FROM i_requests WHERE `datetime` < {$data_date}") or die(mysql_error());
    if (mysql_num_rows($check_data) > 0) {
        mysql_query("DELETE FROM i_requests WHERE `datetime` < {$data_date}");
    }

    
    $userid         = $shout['id'];
    $nick           = $shout['username'];
    $posttime       = $shout['datetime'];
    $shout_combined = makeClickableLinks(bbCode($shout['item']));
    $shoutx         = stripslashes(rtrim($shout_combined));
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
        // admin
        if (in_array($nick, $admin, true)) {
            $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . ' ';
            $lines[] = '<a href="reply.php?id='.$userid.'&uref='.$nick.'" class="label label-success" style="float:right;"><i class="icon-retweet icon-white"></i> Reply</a> ';
            $lines[] = '<div class="replied-answer">';
            $result1 = mysql_query("SELECT * FROM i_replies WHERE item_id='$userid' ORDER BY id DESC LIMIT 3");
            while ($item1 = mysql_fetch_assoc($result1)) {
                $answer1 = linkThisOne($item1['answer']);
                $answer2 = stripslashes(rtrim($answer1));
                $lines[] = '<div class="replied-msg"><strong>' . $item1['user'] . '</strong> ' . $answer2 . '</div>';
            }
            $lines[] = '</div>';
            $lines[] = '</td></tr>';
            // VIP
        } else if (in_array($nick, $kitty, true)) {
            $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . ' ';
            $lines[] = '<a href="reply.php?id='.$userid.'&uref='.$nick.'" class="label label-success" style="float:right;"><i class="icon-retweet icon-white"></i> Reply</a> ';
            $lines[] = '<div class="replied-answer">';
            $result1 = mysql_query("SELECT * FROM i_replies WHERE item_id='$userid' ORDER BY id DESC LIMIT 3");
            while ($item1 = mysql_fetch_assoc($result1)) {
                $answer1 = linkThisOne($item1['answer']);
                $answer2 = stripslashes(rtrim($answer1));
                $lines[] = '<div class="replied-msg"><strong>' . $item1['user'] . '</strong> ' . $answer2 . '</div>';
            }
            $lines[] = '</div>';
            $lines[] = '</td></tr>';
            // public user
        } else {
            $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . ' ';
            $lines[] = '<a href="reply.php?id='.$userid.'&uref='.$nick.'" class="label label-success" style="float:right;"><i class="icon-retweet icon-white"></i> Reply</a> ';
            $lines[] = '<div class="replied-answer">';
            $result1 = mysql_query("SELECT * FROM i_replies WHERE item_id='$userid' ORDER BY id DESC LIMIT 3");
            while ($item1 = mysql_fetch_assoc($result1)) {
                $answer1 = linkThisOne($item1['answer']);
                $answer2 = stripslashes(rtrim($answer1));
                $lines[] = '<div class="replied-msg"><strong>' . $item1['user'] . '</strong> ' . $answer2 . '</div>';
            }
            $lines[] = '</div>';
            $lines[] = '</td></tr>';
        }
        // public user
    } else {
        $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . ' ';
            $lines[] = '<a href="reply.php?id='.$userid.'&uref='.$nick.'" class="label label-success" style="float:right;"><i class="icon-retweet icon-white"></i> Reply</a> ';
            $lines[] = '<div class="replied-answer">';
            $result1 = mysql_query("SELECT * FROM i_replies WHERE item_id='$userid' ORDER BY id DESC LIMIT 3");
            while ($item1 = mysql_fetch_assoc($result1)) {
                $answer1 = linkThisOne($item1['answer']);
                $answer2 = stripslashes(rtrim($answer1));
                $lines[] = '<div class="replied-msg"><strong>' . $item1['user'] . '</strong> ' . $answer2 . '</div>';
            }
            $lines[] = '</div>';
            $lines[] = '</td></tr>';
    }
}
echo implode($lines);

echo '</tbody></table>';

}

?>
