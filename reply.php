<?php
session_start();
define('NoDirectAccess', TRUE);
include('header.php');
function renderForm($error, $requestID, $requester) {
include('includes.php');
include('settings.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Reply to the Request</h1>
  <h3>You're about to reply to someone's request. Thank you for your kindness! <i class="icon-heart icon-white"></i></h3>
</div>
</div>

    <div class="container">
      
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">

<div style='padding-bottom:15px;height:30px;' id='more_shouts_nav'>
<a href='request_shouts.php?page=1' class='btn btn-info'><i class='icon-chevron-left icon-white'></i> Back to Request Message</a>
</div>

<?php
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
echo '</thead><tbody>';
echo '<tr><td colspan="2" style="text-align:center;background:#eee;border-bottom:1px solid #000"><strong>Request Message</strong></td></tr>';

$result = mysql_query("SELECT * FROM i_requests WHERE id='$requestID' ORDER BY id DESC LIMIT 1") or die(mysql_error());
$reqmsg = mysql_fetch_array($result);
if ($reqmsg) {
    $userid         = $reqmsg['id'];
    $nick           = $reqmsg['username'];
    $posttime       = $reqmsg['datetime'];
    $shout_combined = makeClickableLinks(bbCode($reqmsg['item']));
    $shoutx         = stripslashes(rtrim($shout_combined));
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    if (mysql_num_rows($data) > 0) {
        // admin
        if (in_array($nick, $admin, true)) {
            $lines[] = '
    <tr><td class="chatter-box"><a href="profile.php?user=' . $nick . '" class="chatter" title="View ' . $nick . ' Profile"><strong>' . $nick . '</strong></a><br /><span class="timeAgo">' . time_ago($posttime) . '</span></td>
    <td>' . $shoutx . '<div class="timeago" style="text-align:right;">';
            $lines[] = '</div>';
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
    <td>' . $shoutx . '<div class="timeago" style="text-align:right;">';
            $lines[] = '</div>';
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
    <td>' . $shoutx . '<div class="timeago" style="text-align:right;">';
            $lines[] = '</div>';
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
    <td>' . $shoutx . '<div class="timeago" style="text-align:right;">';
            $lines[] = '</div>';
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

    if ($error != '') {
        echo '<div id="console" class="alert alert-error">' . $error . '</div>';
        echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'console\').style.display=\'none\';$(\'console\').innerHTML = \'\'",5e3)</script>';
    }
?>


<form class="form-horizontal" action="" method="post">
<div class="shouting-section">
<textarea class="shouting-box" placeholder="Type your reply message here" name="answer" id="shout" rows="2" maxlength="250"></textarea>
<input type="hidden" name="requestID" value="<?php echo $requestID; ?>">
<input type="hidden" name="requester" value="<?php echo $requester; ?>">
<div class="shouting-function">
<span id="charcount" class="shouting-count">250</span>
<span class="shouting-btn">
<input type="submit" class="btn btn-info" name="reply" value="Shout">
</span>
</div><!--/shouting-function-->

</div><!--/shouting-section-->

</form>

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

<?php
include('footer.php');

}

include('includes.php');
include('settings.php');

if (isset($_POST['reply'])) {
    $answer = mysql_real_escape_string(htmlspecialchars($_POST['answer']));
    $requestID = $_POST['requestID'];
    $requester = $_POST['requester'];
    $replier = $_SESSION['userwd'];
        
    // detect ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $uip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $uip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
    }
    
    if ($answer == '') {
        $error = "<strong>ERROR:</strong> Write something, do not leave it blank!";
        renderForm($error, $requestID, $requester);
    } else if ($requester == $replier) {
        $error = "<strong>ERROR:</strong> You may reply to other requests, but NOT on yourself!";
        renderForm($error, $requestID, $requester);
    } else {
        $getDate = time();
        mysql_query("INSERT i_replies SET user='$replier', item_id='$requestID', answer='$answer'");
        $show_onShoutbox = '<span class="repliedto">Replied to <span class="repliedto_nick">' . $requester . '</span></span> ' . $answer . '';
        mysql_query("INSERT i_shouts SET username='$replier', datetime='$getDate', shout='$show_onShoutbox', user_ip='$uip'");
        header('Location: request_shouts.php?page=1');
    }
       
} else {
    include('includes.php');
    include('settings.php');
    if (isset($_SESSION['userwd'])) {
        if (!empty($_GET['id']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
            $requestID   = $_GET['id'];
            $requester = clean($_GET['uref']);
            $userDB = mysql_query("SELECT * FROM i_users WHERE userwd='$requester'") or die(mysql_error());
            if (mysql_num_rows($userDB) == 0) { header('Location: 404.php'); } // check user existance in database
            renderForm('', $requestID, $requester);
        } else { header('Location: 404.php'); }
    } else {
        header('Location: login.php');
    }
}

?>