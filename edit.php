<?php
session_start();
session_regenerate_id();
include('header.php');
if (!empty($_GET['user']) && isset($_GET['user'])) {
include('includes.php');
include('settings.php');
$nickname = clean($_GET['user']);
$userDB = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
if (mysql_num_rows($userDB) == 0) { header('Location: 404.php'); } // check user existance in database
else if ($nickname == isset($_SESSION['userwd'])) {
function renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline)
{
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Edit Profile &raquo; <?php echo $username; ?></h1>
  <h3><?php if ($tagline == '') { echo '&lt;Your tagline is here&gt;'; } else { echo stripslashes(rtrim($tagline)); } ?></h3>
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
  <legend>Update Your Profile</legend>
    <div class="control-group">
      <label class="control-label" for="nickname">Username</label>
      <div class="controls">
        <input type="text" class="input-large" id="nickname" name="username" value="<?php echo $username; ?>" maxlength="15" disabled>
        <p class="help-inline"><span class="label label-info info-tip" title="Once registered, you cannot change your nickname anymore."><i class="icon-exclamation-sign icon-white"></i></span> <a href="change_password.php" class="label label-info"><i class="icon-lock icon-white"></i> Change Password</a></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="fullname">Name</label>
      <div class="controls">
        <input type="text" class="input-large regtip" id="fullname" name="fullname" value="<?php echo $fullname; ?>" maxlength="30" title="Max. 30 chars including alphanumerics, whitespaces and dots.">
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
       <div class="control-group">
      <label class="control-label" for="email">Email</label>
      <div class="controls">
        <input type="text" class="input-large regtip" id="email" name="email" value="<?php echo $email; ?>" maxlength="50" title="Required when you forgot/lost your password, a new reset password will be sent to this email.">
        <p class="help-inline"><span class="label label-important"><i class="icon-exclamation-sign icon-white"></i> Required</span></p>
      </div>
    </div>
    <legend>What's Else?</legend>
    <div class="control-group">
      <label class="control-label" for="tagline">Tagline</label>
      <div class="controls">
        <input type="text" class="input-large regtip" id="tagline" name="tagline" value="<?php echo stripslashes(rtrim($tagline)); ?>" maxlength="100" title="Max. 100 chars. Be short and simple.">
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="freenote">Free note</label>
      <div class="controls">
        <textarea class="input-large regtip" id="freenote" rows="5" placeholder="Write something." name="freenote" maxlength="500" title="Max. 500 chars including whitespaces, alphanumerics and symbols."><?php echo stripslashes(rtrim($freenote)); ?></textarea>
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
    <legend>Sharerlink (Optional) <small>If you are a sharer... You can fill up this!</small></legend>
      <div class="control-group">
      <label class="control-label" for="sharername">Sharer name</label>
      <div class="controls">
        <input type="text" class="input-large regtip" id="sharername" name="sharername" value="<?php echo $sharername; ?>" maxlength="20" title="Max. 20 chars including whitespaces, alphanumerics and underscore, but no symbols.">
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="sharerlink">Sharer link</label>
      <div class="controls">
        <input type="text" class="input-large regtip" id="sharerlink" placeholder="http://" name="sharerlink" value="<?php echo $sharerlink; ?>" maxlength="50" title="Your link/IP must begin with 'http://' to make SharerLink status indicator works.">
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="sharerdesc">Sharer description</label>
      <div class="controls">
        <textarea class="input-large regtip" id="sharerdesc" placeholder="Be simple & descriptive..." rows="3" name="sharerdesc" maxlength="200" title="Max. 200 chars including whitespaces, alphanumerics and symbols."><?php echo stripslashes(rtrim($sharerdesc)); ?></textarea>
        <p class="help-inline"><span class="label label-success"><i class="icon-question-sign icon-white"></i> Optional</span></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label"></label>
      <div class="controls">
        <input type="hidden" name="antispam" value="">
        <input type="submit" class="btn btn-primary" name="update" value="Submit">
        <?php
        $callSharerData = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$username'") or die(mysql_error());
        $initSharerData = mysql_fetch_array($callSharerData);
        if ($initSharerData) {
            echo '<input type="submit" class="btn btn-inverse" name="delete_sharerdata" value="Delete Sharerlink">';
        }
        ?>
        <a class="btn btn-danger" href="delete.php?user=<?php echo $username; ?>">Delete this Account</a>
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

if (isset($_POST['update'])) {
    $username       = $_SESSION['userwd'];
    $email          = mysql_real_escape_string(htmlspecialchars($_POST['email']));
    $sharername     = mysql_real_escape_string(htmlspecialchars($_POST['sharername']));
    $sharerlink     = mysql_real_escape_string(htmlspecialchars($_POST['sharerlink']));
    $sharerdesc     = mysql_real_escape_string(htmlspecialchars($_POST['sharerdesc']));
    $freenote       = mysql_real_escape_string(htmlspecialchars($_POST['freenote']));
    $fullname       = mysql_real_escape_string(htmlspecialchars($_POST['fullname']));
    $tagline        = mysql_real_escape_string(htmlspecialchars($_POST['tagline']));
    $antispam       = $_POST['antispam'];
    
    // detect ip
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $check_email = mysql_fetch_array(mysql_query("SELECT * FROM i_users WHERE userwd='$username'")) or die(mysql_error());
    $userEmail = $check_email['email'];
    
    if ($antispam !== '') { header('Location: 404.php'); }
    else {
    
    if ($email == '') {
        $error = '<strong>ERROR:</strong> Please insert your valid email address.';
        renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
    } else if ($email !== $userEmail) {
        $error = '<strong>ERROR:</strong> The email address already exists in database!';
        renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
    } else if (!check_email($email)) {
        $error = '<strong>ERROR:</strong> Invalid email address!';
        renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
    } else if (($sharername !== '') && (!check_sharername($sharername))) {
        $error = '<strong>ERROR:</strong> Only alphanumerics, dot, underscore and whitespace are allowed!';
        renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
    } else if (($fullname !== '') && (!validateFullname($fullname))) {
        $error = '<strong>ERROR:</strong> Only alphanumerics, whitespaces and dots are allowed!';
        renderForm($username, $error, $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
    } else {
        $freenote_ok = stripslashes(rtrim($freenote));
        $tagline_ok = stripslashes(rtrim($tagline));
        mysql_query("UPDATE i_users SET email='$email', free_note='$freenote_ok', userip='$ip', fullname='$fullname', tagline='$tagline_ok' WHERE userwd='$username'") or die(mysql_error());
        
        if (($sharername !== '') && ($sharerlink !== '')) {
        $owner = $username;
        $add_date = time();
        $callSharerData = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$owner'") or die(mysql_error());
        $initSharerData = mysql_fetch_array($callSharerData);
        if ($initSharerData) {
            if ($sharerdesc == '') { $sharerdesc = 'N/A'; }
            $sharerdesc_ok = stripslashes(rtrim($sharerdesc));
            mysql_query("UPDATE i_sharerlinks SET sharername='$sharername', sharerlink='$sharerlink', sharerdesc='$sharerdesc_ok', add_date='$add_date' WHERE owner='$owner'") or die(mysql_error());
        } else {
            $likes = 0;
            $sharerdesc_ok = stripslashes(rtrim($sharerdesc));
            mysql_query("INSERT i_sharerlinks SET owner='$owner', sharername='$sharername', sharerlink='$sharerlink', sharerdesc='$sharerdesc_ok', add_date='$add_date', likes='$likes'") or die(mysql_error());
        }
        }
    
        $_SESSION['profileUpdate'] = 'Success'; 
        header('Location: edit.php?user='.$username.'');
    }
    
    } // end check spam

} else if (isset($_POST['delete_sharerdata'])) {
    $username = $_SESSION['userwd'];
    mysql_query("DELETE FROM i_sharerlinks WHERE owner='$username'") or die(mysql_error());
    $_SESSION['profileUpdate'] = 'Success'; 
    header('Location: edit.php?user='.$username.'');
} else {
    $callUserData = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
    $callSharerData = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$nickname'") or die(mysql_error());
    $initUserData = mysql_fetch_array($callUserData);
    $initSharerData = mysql_fetch_array($callSharerData);
    $username = $initUserData['userwd'];
    $email = $initUserData['email'];
    if ($initUserData['free_note']) { $freenote = stripslashes(rtrim($initUserData['free_note'])); } else { $freenote = ''; }
    if ($initUserData['fullname']) { $fullname = $initUserData['fullname']; } else { $fullname = ''; }
    if ($initUserData['tagline']) { $tagline = stripslashes(rtrim($initUserData['tagline'])); } else { $tagline = ''; }
    
    if ($initSharerData) {
        $sharername = $initSharerData['sharername'];
        $sharerlink = $initSharerData['sharerlink'];
        $sharerdesc = stripslashes(rtrim($initSharerData['sharerdesc']));
    } else {
        $sharername = '';
        $sharerlink = '';
        $sharerdesc = '';
    }
    renderForm($username, '', $email, $sharername, $sharerlink, $sharerdesc, $freenote, $fullname, $tagline);
}

} else { header('Location: 404.php'); }
} else { header('Location: 404.php'); }

?>