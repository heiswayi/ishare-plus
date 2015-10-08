<?php

function shortenurl($url){
 if (strlen($url) > 30) {
  $url = str_replace('http://','',$url);
  $url = str_replace('www.','',$url);
  return substr($url, 0, 25)."...";
 } else {
  $url = str_replace('http://','',$url);
  $url = str_replace('www.','',$url);
  return $url;
 }
}

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}

// convert plain URL to clickable link
function makeClickableLinks($ret){
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a class=\"label label-info fnote-tip\" title=\"\\2\" href=\"\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a class=\"label label-info fnote-tip\" title=\"\\2\" href=\"http://\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<span class=\"nickname mention\" onclick=\"insertNickname('@\\1')\">@\\1</span>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a href=\"hashtag.php?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
  return $ret;
}
    
// convert plain URL to clickable link
function linkThisOne($ret){
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a class=\"label label-info show-url\" title=\"\\2\" href=\"\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a class=\"label label-info show-url\" title=\"\\2\" href=\"http://\\2\" target=\"_blank\"><i class=\"icon-magnet icon-white\"></i> Link</a>", $ret);
  return $ret;
}
    
// check for alphanumeric and underscore 
function validate_alphanumeric_underscore($str) {
    return preg_match('/^[a-zA-Z0-9_]+$/', $str);
}
function validateFullname($str) {
    return preg_match('/^[a-zA-Z0-9.\s]+$/', $str);
}

// bbCode  
function bbCode($var) { 
        $search = array( 
        //        '/\[b\](.*?)\[\/b\]/is', 
                '/\[i\](.*?)\[\/i\]/is', 
                '/\[u\](.*?)\[\/u\]/is', 
        //        '/\[img\](.*?)\[\/img\]/is', 
        //        '/\[url\](.*?)\[\/url\]/is', 
        //        '/\[url\=(.*?)\](.*?)\[\/url\]/is',
        //        '/\[ann\](.*?)\[\/ann\]/is',
                '/\!request/is',
                '/\!update/is',
                '/\{\:(.*?)\:\}/is',
                '/\[\:(.*?)\:\]/is',
                '/\[\;(.*?)\;\]/is',
                '/\{\;(.*?)\;\}/is'
                ); 

        $replace = array( 
        //        '<strong>$1</strong>', 
                '<em>$1</em>', 
                '<u>$1</u>', 
        //        '<img src="$1" />', 
        //        '<a href="$1">$1</a>', 
        //        '<a href="$1">$2</a>',
        //        '<span style="background:#cc0000;color:#fff;padding:2px;"><i class="icon-bullhorn icon-white"></i> $1</span>',
                '<span class="requestcode">!request</span>',
                '<span class="requestcode">!update</span>',
                '<img src="assets/img/onion/$1.gif">',
                '<img src="assets/img/tuzki/$1.gif">',
                '<img src="assets/img/smilies/$1.png">',
                '<img src="assets/img/cutes/$1.gif">'
                ); 

        $var = preg_replace ($search, $replace, $var); 
        return $var; 
}

function bbCode_sr($var) { 
        $search = array( 
        //        '/\[b\](.*?)\[\/b\]/is', 
                '/\[i\](.*?)\[\/i\]/is', 
                '/\[u\](.*?)\[\/u\]/is', 
        //        '/\[img\](.*?)\[\/img\]/is', 
        //        '/\[url\](.*?)\[\/url\]/is', 
        //        '/\[url\=(.*?)\](.*?)\[\/url\]/is',
                '/\[ann](.*?)\[\/ann]/is',
                '/\!request/is',
                '/\!update/is'
                ); 

        $replace = array( 
        //        '<strong>$1</strong>', 
                '<em>$1</em>', 
                '<u>$1</u>', 
        //        '<img src="$1" />', 
        //        '<a href="$1">$1</a>', 
        //        '<a href="$1">$2</a>',
                '<span style="background:#cc0000;color:#fff;padding:2px;"><i class="icon-bullhorn icon-white"></i> $1</span>',
                '<span class="requestcode">!request</span>',
                '<span class="requestcode">!update</span>'
                ); 

        $var = preg_replace ($search, $replace, $var); 
        return $var; 
}

// replace any UPPERCASE to lowercase for comparison use  
function strtolower_utf8($string) {
  $convert_to = array( 
    "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", 
    "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", 
    "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "?", "?", "?", "?", "?", "?", "?", "?", 
    "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", 
    "?", "?", "?", "?" 
  ); 
  $convert_from = array( 
    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", 
    "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", 
    "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "?", "?", "?", "?", "?", "?", "?", "?", 
    "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", "?", 
    "?", "?", "?", "?" 
  ); 
    
    return str_replace($convert_from, $convert_to, $string);
}

// filter bad words  
//function badword_filter($badword_text) {
//    $badword = array(
//    'kelentit', 'babi', 'suck', 'puki', 'fuck', 'chibai', 'penis', 'cunt', 'asshole', 'slut', 'shlong', 'pussy', 'clit',
//    'kimak', 'lancau', 'butuh', 'burit', 'pantat', 'dick', 'cibai', 'kote', 'cipap', 'pelir', 'jubur'
//    );
//    $reptext = str_ireplace($badword, '<span class="censored">**CENSORED**</span>', $badword_text);
//    return $reptext;
//    
//}

// flood control in posting  
function fcontrol($field, $delay) {
    $ip     = $_SERVER['REMOTE_ADDR'];
    $now    = time();
    $result = mysql_query("SELECT {$field}_time AS time FROM i_fcontrol WHERE client_ip = '$ip'");
    if (!mysql_num_rows($result)) {
        mysql_query("INSERT INTO i_fcontrol (client_ip, {$field}_time) VALUES ('$ip', $now)");
        return true;
    }
    $time = mysql_fetch_assoc($result);
    $time = $time['time'];
    if ($now - $time > $delay) {
        mysql_query("UPDATE i_fcontrol SET {$field}_time = $now WHERE client_ip = '$ip'");
        return true;
    } else {
        return false;
    }
}

function time_ago($timestamp) {
  //return date('d.m | g:i A', $timestamp);
  
    //type cast, current time, difference in timestamps
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
    
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
    
    //now we just find the difference
    if ($diff == 0)
    {
        return 'just now';
    }    

    if ($diff < 60)
    {
        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
    }        

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
    }        

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
    }    

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
    }    

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
    }    

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
    }    

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
    }
}

function check_email($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_{|}~-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
  }
  
function check_sharername($str) {
  return preg_match('/^[a-zA-Z0-9_.\s]+$/',$str);
}

?>