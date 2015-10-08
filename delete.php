<?php
session_start();
if (!empty($_GET['user']) && isset($_GET['user'])) {
include('header.php');
include('includes.php');
include('settings.php');
$nickname = clean($_GET['user']);
$userDB = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
if (mysql_num_rows($userDB) == 0) { header('Location: 404.php'); } // check user existance in database
if ($nickname == isset($_SESSION['userwd'])) {
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Delete Account &raquo; <?php echo $nickname; ?></h1>
</div>
</div>

    <div class="container">
    <div class="row">

<div class="span4">
<div class="well special-bg">
<div class="alert alert-warning">
This is your profile account that you're about to delete including all your shouted messages. <i class="icon-hand-down"></i>
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
$userProfile = mysql_query("SELECT * FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
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
    echo '<td class="user-info-label">Nickname</td>';
    echo '<td><strong>'.$usernamex.'</strong></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Fullname</td>';
    if ($fullnamex) { echo '<td>'.$fullnamex.'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Registered</td>';
    echo '<td>'.$regtimex.'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="user-info-label">Free Note</td>';
    if ($freenotex) { echo '<td>'.linkThisOne(stripslashes(rtrim($freenotex))).'</td>'; } else { echo '<td>N/A</td>'; }
    echo '</tr>';
}  
$sharerProfile = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$nickname'") or die(mysql_error());
$sharerdatax = mysql_fetch_array($sharerProfile);
    if ($sharerdatax) {
        $sharerdescx = str_replace("\n", " ", $sharerdatax['sharerdesc']);
        $sharerdescx = str_replace("\r", " ", $sharerdatax['sharerdesc']);
        $sharernamex = $sharerdatax['sharername'];
        $sharerlinkx = $sharerdatax['sharerlink'];
        echo '<tr>';
        echo '<td class="user-info-label">Sharer Name</td>';
        echo '<td style="background:#f3f3f3"><span class="label label-info">'.$sharernamex.'</span></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="user-info-label">Sharer Link</td>';
        echo '<td style="background:#f3f3f3"><a href="'.$sharerlinkx.'">'.$sharerlinkx.'</a></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td class="user-info-label">Sharer Description</td>';
        echo '<td style="background:#f3f3f3">'.stripslashes(rtrim($sharerdescx)).'</td>';
        echo '</tr>';
    }

?>

</tbody>
</table>

</div>
</div><!--/span-->

    <div class="span8">
<div class="well special-bg">    
<div class="hero-unit">
  <h2>Deleting your account...</h2>
  <p>You are about to delete your account and this is just a confirmation before we proceed. Once deleted, all your data and shouted messages will be totally wiped from the database.</p>
  <p>
  <form action="" method="post">
    <div class="input-prepend">
    <span class="add-on"><i class="icon-asterisk"></i></span><input type="password" class="input-xlarge regtip" placeholder="Password" name="password" value="" maxlength="15" title="Enter your Password">
     </div>
    <input type="submit" class="btn btn-danger btn-large" name="delete" value="Confirm &amp; Delete">
    <a href="edit.php?user=<?php echo $nickname; ?>" class="btn btn-inverse btn-large">Cancel</a>
  </form>
  </p>
</div>
</div>

</div><!--/span-->
</div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->

<?php
include('footer.php');

if (isset($_POST['delete'])) {
    $password = md5(mysql_real_escape_string(htmlspecialchars($_POST['password'])));
    $username = $nickname;
    $data = mysql_fetch_array(mysql_query("SELECT * FROM i_users WHERE userwd='$username'")) or die(mysql_error());
    if ($password == $data['passwd']) {

    //delete sharerData
    $callSharerData = mysql_query("SELECT * FROM i_sharerlinks WHERE owner='$nickname'") or die(mysql_error());
    if (mysql_num_rows($callSharerData) == 1) { mysql_query("DELETE FROM i_sharerlinks WHERE owner='$nickname'") or die(mysql_error()); }
    
    //delete shoutdata
    $callShoutData = mysql_query("SELECT * FROM i_shouts WHERE username='$nickname'") or die(mysql_error());
    if (mysql_num_rows($callShoutData) > 0) { mysql_query("DELETE FROM i_shouts WHERE username='$nickname'") or die(mysql_error()); }
    
    //delete userdata
    $deleteUserData = mysql_query("DELETE FROM i_users WHERE userwd='$nickname'") or die(mysql_error());
    
    unset($_SESSION['userwd']);
    if (isset($_COOKIE[$cookie_name]) && isset($_COOKIE[$cookie_user])) {
        setcookie ($cookie_name, '', time() - $cookie_time);
        setcookie ($cookie_user, '', time() - $cookie_time);
    }
    session_destroy();
    header('Location: index.php');
    
    }
}

}

} else { header('Location: 404.php'); }
?>