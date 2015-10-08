<?php
session_start();
include('includes.php');
include('settings.php');

if (fcontrol('shout', 3)) {
    $user     = mysql_real_escape_string(htmlspecialchars($_POST['user']));
    $shout    = mysql_real_escape_string(htmlspecialchars($_POST['shout']));
    $antispam = $_POST['antispam'];
    
    mysql_select_db($db) or die(mysql_error()); // check username from database
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$user'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    
    $user_check1 = strtolower($user);
    $no_nickname = strtolower('Nickname');
    
    // detect ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $uip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $uip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
    }
    
    if (isset($_POST['color-text'])) {
        $setcolor = $_POST['color-text'];
     } else { $setcolor = 'default'; }
            
    
    $bannedlorr = mysql_query("SELECT * FROM i_bans WHERE ip='$uip'") or die(mysql_error());
    
    if (!isset($_SESSION['userwd'])) {
        if ($antispam !== '') {
            echo "Spammer is not allowed here!";
        } else if (!validate_alphanumeric_underscore($user)) {
            echo "<strong>ERROR:</strong> Only alphanumeric and underscore characters are allowed!";
        } else if (mysql_num_rows($bannedlorr) > 0) {
            echo "<strong>ERROR:</strong> Unable to shout because your IP has been banned!";
        } else if (mysql_num_rows($data) > 0) {
            echo "<strong>ERROR:</strong> The nickname has been registered by someone!";
        } else if ($user == '' || $user_check1 == $no_nickname) {
            echo "<strong>ERROR:</strong> Please insert your nickname!";
        } else if (strlen($user) < 3) {
            echo "<strong>ERROR:</strong> Your nickname is too short, minimum 3 characters and above.";
        } else if ($shout == '' || $shout == 'Message') {
            echo "<strong>ERROR:</strong> Please insert your message!";
        } else if (in_array($user_check1, $censorednick, true)) {
            echo "<strong>ERROR:</strong> This nickname has been CENSORED, you cannot use it!";
        } else {
            if (strstr($shout, '!request') !== false) {
                $item_request = str_replace('!request', '', $shout);
                if ($item_request !== '') {
                    mysql_query("INSERT INTO i_requests (username, datetime, item, user_ip) VALUES ('$user', " . time() . ", '$item_request', '$uip')");
                }
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            } else if (strstr($shout, '!update') !== false) {
                $item_request = str_replace('!update', '', $shout);
                if ($item_request !== '') {
                    mysql_query("INSERT INTO i_updates (username, datetime, item, user_ip) VALUES ('$user', " . time() . ", '$item_request', '$uip')");
                }
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            } else {
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            }
        }
    } else {
        if ($antispam !== '') {
            echo "Spammer is not allowed here!";
        } else if (!validate_alphanumeric_underscore($user)) {
            echo "<strong>ERROR:</strong> Only alphanumeric and underscore characters are allowed!";
        } else if (mysql_num_rows($bannedlorr) > 0) {
            echo "<strong>ERROR:</strong> Your IP has been banned!";
        } else if ($user == '' || $user_check1 == $no_nickname) {
            echo "<strong>ERROR:</strong> Please insert your nickname!";
        } else if (strlen($user) < 3) {
            echo "<strong>ERROR:</strong> Your nickname is too short, minimum 3 characters and above.";
        } else if ($shout == '' || $shout == 'Message') {
            echo "<strong>ERROR:</strong> Please insert your message!";
        } else if (in_array($user_check1, $censorednick, true)) {
            echo "<strong>ERROR:</strong> This nickname has been CENSORED, you cannot use it!";
        } else {
            if (strstr($shout, '!request') !== false) {
                $item_request = str_replace('!request', '', $shout);
                if ($item_request !== '') {
                    mysql_query("INSERT INTO i_requests (username, datetime, item, user_ip) VALUES ('$user', " . time() . ", '$item_request', '$uip')");
                }
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            } else if (strstr($shout, '!update') !== false) {
                $item_request = str_replace('!update', '', $shout);
                if ($item_request !== '') {
                    mysql_query("INSERT INTO i_updates (username, datetime, item, user_ip) VALUES ('$user', " . time() . ", '$item_request', '$uip')");
                }
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            } else {
                $shoutit = '<span class="st-'.$setcolor.'"> '.$shout.' </span>';
                mysql_query("INSERT INTO i_shouts_sr (username, datetime, shout, user_ip) VALUES ('$user', " . time() . ", '$shoutit', '$uip')");
            }
        }
    }
} else {
    echo "<strong>Anti-Flood:</strong> Please wait...!";
}
?>