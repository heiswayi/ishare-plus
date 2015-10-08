<?php
session_start();
session_regenerate_id();
header('Cache-control: private'); // IE 6 FIX
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); // always modified

// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);

header('Pragma: no-cache'); // HTTP/1.0

include('header.php');
function renderForm($username, $error, $email)
{
?>

<div class="container">
    <div class="row">   
        <div class="login-center">
            <div class="span6-intro">
                <div class="welcome-text">
                    <h1>Welcome to Ishare<strong style="color:#ee0000">+</strong></h1>A place to share your stuffs, chat with people and.. another community-driven information center.</div>
            </div>
            <div class="span3-intro">
            
<?php
    if ($error != '') {
        echo '<div id="console" class="alert alert-error">' . $error . '</div>';
        echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'console\').style.display=\'none\';$(\'console\').innerHTML = \'\'",5e3)</script>';
    }
?>
            
                <div class="well login-register">
                    <form action="" method="post">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span><input type="text" class="input-login regtip" placeholder="Nickname" name="username" value="<?php echo $username; ?>" title="Enter your Nickname" maxlength="15">
                        </div>
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-asterisk"></i></span><input type="password" class="input-login regtip" placeholder="Password" name="password" value="" maxlength="15" title="Enter your Password">
                        </div>
                        <div style="text-align:right">
                        
                        <label class="checkbox" style="float:left;"><input type="checkbox" name="autologin" value="1">Stay logged in
                        </label>
                            <a href="forgot_password.php" class="btn fpass" title="Forgot Password? Reset here!"><i class="icon-lock"></i></a>
                            <input type="submit" class="btn btn-primary" name="login" value="Login">
                        </div>
                    </form>
                    
                    <div class="login-divider"></div>
                    <form action="" method="post">
                        <p class="help-block"><h5 class="reg-intro">New to Ishare? <small style="margin-left:10px;">Register here!</small></h5></p>
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span><input type="text" class="input-login regtip" placeholder="Nickname" name="username" value="<?php echo $username; ?>" title="Max. 15 chars. No whitespace/symbol, only alphanumerics and underscore." maxlength="15">
                        </div>
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-asterisk"></i></span><input type="password" class="input-login regtip" placeholder="Password" name="password" value="" maxlength="15" title="Don't worry, your password will be encrypted!">
                        </div>
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-envelope"></i></span><input type="text" class="input-login regtip" placeholder="Email" name="email" value="<?php echo $email; ?>" maxlength="100" title="Required when you forgot/lost your password, a new reset password will be sent to this email.">
                        </div>
                        <div style="text-align:right;">
                            <input type="hidden" name="antispam" value="">
                            <input type="submit" class="btn btn-success" name="register" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/login-center-->
    </div>
    <!--/row-->
    <footer class="intro">
        <p class="copyright">Ishare+, the Portal of Sharers &copy; 2012. A Production of <a href="http://hik3.net" class="label label-copy">hik3studio</a>. All rights reserved.</p>
    </footer>
</div>
<!--/.fluid-container-->

<?php

include('footer.php');

}

include('includes.php');
include('settings.php');

if (isset($_POST['login'])) {
    $username = mysql_real_escape_string(htmlspecialchars($_POST['username']));
    $password = md5(mysql_real_escape_string(htmlspecialchars($_POST['password'])));
    $email = '';
    $autologin = isset($_POST['autologin']);
    
    $data = mysql_query("SELECT * FROM i_users WHERE userwd='$username'") or die(mysql_error());
    $row = mysql_fetch_array($data);
    
    $checkBan = mysql_query("SELECT * FROM i_bans WHERE username='$username'") or die(mysql_error());
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $newip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $newip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $newip = $_SERVER['REMOTE_ADDR'];
    }
    
    if ($username == '' || $password == '') {
        $error = '<strong>ERROR:</strong> Please insert your nickname -OR- your password -OR- both.';
        renderForm($username, $error, $email);
    } else if (mysql_num_rows($data) == 0) {
        $error = '<strong>ERROR:</strong> Nickname <u>' . $username . '</u> does not exist in database!';
        renderForm($username, $error, $email);
    } else if (mysql_num_rows($checkBan) == 1) {
        $error = '<strong>ERROR:</strong> Unable to login, your nickname has been BANNED!';
        renderForm($username, $error, $email);
    } else if ($password !== $row['passwd']) {
        $error = '<strong>ERROR:</strong> Incorrect password!';
        renderForm($username, $error, $email);
    } else {
        if ($autologin == 1) {
            setcookie ($cookie_name, 'usr='.$username.'&hash='.$password, time() + $cookie_time);
            setcookie ($cookie_user, $username, time() + $cookie_time);
        }
        $_SESSION['userwd'] = $username;
        if ($newip !== $row['userip']) {
            mysql_query("UPDATE i_users SET userip='$newip' WHERE userwd='$username'") or die(mysql_error());
        }
        header('Location: preloader/index.php');
    }
} else if (isset($_POST['register'])) {
    $username       = mysql_real_escape_string(htmlspecialchars($_POST['username']));
    $password_nomd5 = mysql_real_escape_string(htmlspecialchars($_POST['password']));
    $email          = mysql_real_escape_string(htmlspecialchars($_POST['email']));
    $antispam       = $_POST['antispam'];
    
    // detect ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $check_username = mysql_query("SELECT * FROM i_users WHERE userwd='$username'") or die(mysql_error());
    $check_email    = mysql_query("SELECT * FROM i_users WHERE email='$email'") or die(mysql_error());
    
    $username_check1 = strtolower($username);
    $no_nickname     = strtolower('Nickname');
    
    if ($antispam !== '') { header('Location: 404.php'); }
    else {
    
    if ($username == '' || $password_nomd5 == '' || $username_check1 == $no_nickname) {
        $error = '<strong>ERROR:</strong> Please insert your nickname -OR- your password -OR- both.';
        renderForm($username, $error, $email);
    } else if ($username !== '' && $password_nomd5 !== '' && $email == '') {
        $error = '<strong>ERROR:</strong> Please insert your valid email address.';
        renderForm($username, $error, $email);
    } else if (!validate_alphanumeric_underscore($username)) {
        $error = '<strong>ERROR:</strong> Only alphanumerics and underscore are allowed!';
        renderForm($username, $error, $email);
    } else if (strlen($username) < 3) {
        echo "<strong>ERROR:</strong> Your nickname is too short, minimum 3 characters and above.";
        renderForm($username, $error, $email);
    } else if (mysql_num_rows($check_username) > 0) {
        $error = '<strong>ERROR:</strong> Nickname <strong><u>' . $username . '</u></strong> already exists in database!';
        renderForm($username, $error, $email);
    } else if (mysql_num_rows($check_email) > 0) {
        $error = '<strong>ERROR:</strong> The email address already exists in database!';
        renderForm($username, $error, $email);
    } else if (in_array($username_check1, $reserved, true)) {
        $error = '<strong>ERROR:</strong> This nickname has been RESERVED, you cannot use it!';
        renderForm($username, $error, $email);
    } else if (in_array($username_check1, $censorednick, true)) {
        $error = '<strong>ERROR:</strong> This nickname has been CENSORED, you cannot use it!';
        renderForm($username, $error, $email);
    } else if (!check_email($email)) {
        $error = '<strong>ERROR:</strong> Invalid email address!';
        renderForm($username, $error, $email);
    } else {
        $password = md5($password_nomd5);
        $regtime = time();
        $freenote = '';
        $fullname = '';
        $tagline = '';
        mysql_query("INSERT i_users SET userwd='$username', passwd='$password', email='$email', reg_time='$regtime', free_note='$freenote', userip='$ip', fullname='$fullname', tagline='$tagline'") or die(mysql_error());
        $_SESSION['userwd'] = $username;
        header('Location: welcome.php?user='.$username.'');
    }
    
    } // end check spam
} else {
    include('includes.php');
    include('settings.php');
    if (isset($cookie_name) && isset($cookie_user)) {
        if (isset($_COOKIE[$cookie_name]) && isset($_COOKIE[$cookie_user])) {
            parse_str($_COOKIE[$cookie_name]);
            $this_user = $_COOKIE[$cookie_user];
            $callUserData = mysql_query("SELECT * FROM i_users WHERE userwd='$this_user'") or die(mysql_error());
            $initUserData = mysql_fetch_array($callUserData);
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $newip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $newip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $newip = $_SERVER['REMOTE_ADDR'];
            }
            if (($usr == $initUserData['userwd']) && ($hash == $initUserData['passwd'])) {
                $_SESSION['userwd'] = $initUserData['userwd'];
                if ($newip !== $initUserData['userip']) {
                    mysql_query("UPDATE i_users SET userip='$newip' WHERE userwd='$usr'") or die(mysql_error());
                }
                header('Location: index.php');
            } else { renderForm('', '', '', ''); }
        } else { renderForm('', '', '', ''); }
    } else {
        renderForm('', '', '', '');
    }
}

?>