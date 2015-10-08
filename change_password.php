<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION['userwd'])) { header('Location: 404.php'); }
include('header.php');
function renderForm($error, $username, $tagline)
{
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Edit Profile &raquo; <?php echo $username; ?></h1>
  <h3><?php if ($tagline == '') { echo '&lt;Your tagline is here&gt;'; } else { echo $tagline; } ?></h3>
</div>
</div>

<div class="container">

<div class="row">

<div class="span4">
<div class="well special-bg">
<div class="alert alert-info">
This is how your profile information available to the public when people visiting your profile. <i class="icon-hand-down"></i>
</div>
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

include('includes.php');
include('settings.php');

$userProfile = mysql_query("SELECT * FROM i_users WHERE userwd='$username'") or die(mysql_error());
$userdatax = mysql_fetch_array($userProfile);
if ($userdatax) {
    $usernamex   = $userdatax['userwd'];
    $fullnamex   = $userdatax['fullname'];
    $regtime0   = $userdatax['reg_time'];
    $freenotex   = str_replace("\n", " ", $userdatax['free_note']);
    $freenotex   = str_replace("\r", " ", $userdatax['free_note']);
    
    if ($regtime0 == '') { $regtimex = 'Undefined'; }
    else { $regtimex = date('j F Y, g:i A', $regtime0); }
    
    echo '<tr>';
    echo '<td class="user-info-label">Username</td>';
    echo '<td><strong>'.$usernamex.'</strong></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Name</td>';
    if ($fullnamex) { echo '<td>'.$fullnamex.'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Registered on</td>';
    echo '<td>'.$regtimex.'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Free note</td>';
    if ($freenotex) { echo '<td>'.linkThisOne(stripslashes(rtrim($freenotex))).'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
}
$sharerProfile = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$username'") or die(mysql_error());
$sharerdatax = mysql_fetch_array($sharerProfile);
if ($sharerdatax) {
    $sharerdescx = str_replace("\n", " ", $sharerdatax['sharerdesc']);
    $sharerdescx = str_replace("\r", " ", $sharerdatax['sharerdesc']);
    $sharernamex = $sharerdatax['sharername'];
    $sharerlinkx = $sharerdatax['sharerlink'];
    echo '<tr>';
    echo '<td class="user-info-label">Sharer name</td>';
    echo '<td style="background:#f3f3f3"><span class="label label-info">'.$sharernamex.'</span></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Sharer link</td>';
    echo '<td style="background:#f3f3f3"><a href="'.$sharerlinkx.'">'.$sharerlinkx.'</a></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Sharer description</td>';
    echo '<td style="background:#f3f3f3">'.stripslashes(rtrim($sharerdescx)).'</td>';
    echo '</tr>';
}

?>

</tbody>
</table>

</div>
</div><!--/span-->

    <div class="span8">
        <div class="well no-radius special-bg">
<?php
if ($error == '' && isset($_SESSION['profileUpdate']) == 'Success') {
echo '<div class="alert alert-block alert-success" id="success">';
  echo '<a class="close" data-dismiss="alert" href="#"><i class="icon-remove"></i></a>';
  echo '<h4 class="alert-heading">Success!</h4>';
  echo 'Your profile was successfully updated.';
echo '</div>';
echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'success\').style.display=\'none\';$(\'success\').innerHTML = \'\'",5e3)</script>';
unset($_SESSION['profileUpdate']);
}
else if ($error != '') {
        echo '<div id="console" class="alert alert-error">' . $error . '</div>';
        echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'console\').style.display=\'none\';$(\'console\').innerHTML = \'\'",5e3)</script>';
    }
?>

<div class="register-box table-borderz" style="padding:20px;">
 <form class="form-horizontal" action="" method="post">
  <fieldset>
  <legend>Change Your Password</legend>
    <div class="control-group">
      <label class="control-label" for="oldpassword">Old password</label>
      <div class="controls">
        <input type="password" class="input-large" id="oldpassword" name="oldpassword" value="" maxlength="15">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="newpassword1">New password</label>
      <div class="controls">
        <input type="password" class="input-large" id="newpassword1" name="newpassword1" value="" maxlength="15">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="newpassword2">Confirm new password</label>
      <div class="controls">
        <input type="password" class="input-large" id="newpassword2" name="newpassword2" value="" maxlength="15">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label"></label>
      <div class="controls">
        <input type="submit" class="btn btn-primary" name="update" value="Submit">
        <a class="btn" href="index.php">Cancel</a>
      </div>
    </div>
  </fieldset>
</form>
</div>

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

if (isset($_POST['update'])) {
    $oldpassword = mysql_real_escape_string(htmlspecialchars($_POST['oldpassword']));
    $newpassword1 = mysql_real_escape_string(htmlspecialchars($_POST['newpassword1']));
    $newpassword2 = mysql_real_escape_string(htmlspecialchars($_POST['newpassword2']));
    $username = $_SESSION['userwd'];
    
    // detect ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $oldpassmd5 = md5($oldpassword);
    $newpass1md5 = md5($newpassword1);
    $newpass2md5 = md5($newpassword2);
    
    $callUserData = mysql_query("SELECT * FROM i_users WHERE userwd='$username'") or die(mysql_error());
    $initUserData = mysql_fetch_array($callUserData);
    $tagline = $initUserData['tagline'];
    
    if ($oldpassword == '' || $newpassword1 = '' || $newpassword2 = '') {
        $error = '<strong>ERROR:</strong> Please fill the blank!';
        renderForm($error, $username, $tagline);
    } else if ($oldpassmd5 !== $initUserData['passwd']) {
        $error = '<strong>ERROR:</strong> Invalid old password!';
        renderForm($error, $username, $tagline);
    } else if ($newpass1md5 !== $newpass2md5) {
        $error = '<strong>ERROR:</strong> Your new password does not match!';
        renderForm($error, $username, $tagline);
    } else {
        mysql_query("UPDATE i_users SET passwd='$newpass1md5' WHERE userwd='$username'") or die(mysql_error());       
        $_SESSION['profileUpdate'] = 'Success'; 
        header('Location: edit.php?user='.$username.'');
    }
    
} else {
    if (isset($_SESSION['userwd'])) {
        include('includes.php');
        include('settings.php');
        $nickname = $_SESSION['userwd'];
        $callUserData = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
        $initUserData = mysql_fetch_array($callUserData);
        if ($initUserData) {
            $username = $nickname;
            $tagline = stripslashes(rtrim($initUserData['tagline']));
            renderForm('', $username, $tagline);
        } else {
            header('Location 404.php');
        }
    } else { header('Location 404.php'); }
}

?>