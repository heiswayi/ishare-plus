<?php
session_start();
session_regenerate_id();
include('../includes.php');
include('../settings.php');
if (!isset($_SESSION['userwd'])) { header('Location: ../404.php'); }
else if (isset($_SESSION['userwd']) && !isset($_SESSION['xuidPJVE218'])) {
    $nick = $_SESSION['userwd'];
    $data = mysql_query("SELECT (userwd) FROM i_users WHERE userwd='$nick'") or die(mysql_error());
    if (mysql_num_rows($data) == 0) { header('Location: ../404.php'); }
    else {
         if (in_array(strtolower($nick), $admin, true)) { header('Location: index.php'); }
         else { header('Location: ../404.php'); }
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ishare+ | Portal of Sharers</title>
    <meta name="description" content="A digital place for USM Engineering Campus students to share their stuffs and chat with people.">
    <meta name="author" content="Heiswayi Nrird">

    <!-- Le styles -->
    <link href="../assets/css/ishare.css" rel="stylesheet">
    <style type="text/css">
      .mydrag { margin-top: 70px; }
    </style>
    <link href="style.css" rel="stylesheet">
    <link href="../assets/css/typeface.css" rel="stylesheet">
    <link href="../assets/css/event-ticker.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="../assets/css/ie-suck.css" />
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    
    <script src="../assets/js/jquery.js"></script>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="index.php">Ishare<strong style="color:#ee0000">+</strong> Administration</a>
          <?php if(isset($_SESSION['userwd'])){ ?>
          <div class="btn-group pull-right">
          <a class="btn btn-danger" href="../index.php">Home</a>
            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $_SESSION['userwd']; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="../profile.php?user=<?php echo $_SESSION['userwd']; ?>">View Profile</a></li>
              <li><a href="../edit.php?user=<?php echo $_SESSION['userwd']; ?>">Edit Profile</a></li>
              <li class="divider"></li>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </div>
          
          <div class="nav-collapse">
            <ul class="nav">
            <li class="divider-vertical"></li>
              <?php include('nav.php'); ?>
            </ul>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="container mydrag">

<?php
function renderForm($msg, $msg_type, $msg_onoff, $msg_date) {
?>
<form class="well form-horizontal" action="" method="post">
  <fieldset>
    <legend>Make Announcement</legend>
    <div class="control-group">
      <label class="control-label" for="input00">Date &amp; Time</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="input00" value="<?php echo date('j F Y, g:i A', $msg_date); ?>" disabled="disabled">
        <p class="help-block"></p>
      </div>
      <label class="control-label" for="input01">Message</label>
      <div class="controls">
        <textarea class="input-xxlarge" id="input01" name="msg" rows="5"><?php echo $msg; ?></textarea>
        <p class="help-block"></p>
      </div>
      <label class="control-label" for="input02">Message Type</label>
      <div class="controls">
        <select id="input02" name="msg_type">
        <?php
        if ($msg_type !== '' && $msg_type == 'announcement') {
                echo '<option value="announcement" selected="selected">Announcement</option>';
                echo '<option value="news">News</option>';
                echo '<option value="notice">Notice</option>';
        } else if ($msg_type !== '' && $msg_type == 'news') {
                echo '<option value="announcement">Announcement</option>';
                echo '<option value="news" selected="selected">News</option>';
                echo '<option value="notice">Notice</option>';
        } else if ($msg_type !== '' && $msg_type == 'notice') {
                echo '<option value="announcement">Announcement</option>';
                echo '<option value="news">News</option>';
                echo '<option value="notice" selected="selected">Notice</option>';
        } else {
                echo '<option value="announcement">Announcement</option>';
                echo '<option value="news">News</option>';
                echo '<option value="notice">Notice</option>';
        }
        ?>
              </select>
        <p class="help-block"></p>
      </div>
      <label class="control-label" for="input03">Display</label>
      <div class="controls">
        <select id="input03" name="msg_onoff">
        <?php
        if ($msg_onoff !== '' && $msg_onoff == 'enable') {
                echo '<option value="enable" selected="selected">Enable</option>';
                echo '<option value="disable">Disable</option>';
        } else if ($msg_onoff !== '' && $msg_onoff == 'disable') {
                echo '<option value="enable">Enable</option>';
                echo '<option value="disable" selected="selected">Disable</option>';
        } else {
                echo '<option value="enable">Enable</option>';
                echo '<option value="disable">Disable</option>';
        }
        ?>
              </select>
        <p class="help-block"></p>
      </div>
      <div class="controls">
      <input type="submit" class="btn btn-info" name="ann" value="Submit">
      </div>
    </div>
  </fieldset>
</form>

<?php
}
include('../includes.php');
include('../settings.php');
$table = "i_ann";
if (isset($_POST['ann'])) {
    $msg = clean($_POST['msg']);
    if (isset($_POST['msg_type'])) { $msg_type = $_POST['msg_type']; }
    else { $msg_type = 'announcement'; }
    if (isset($_POST['msg_onoff'])) { $msg_onoff = $_POST['msg_onoff']; }
    else { $msg_onoff = 'enable'; }
    
    $checkMsg = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(id) FROM $table")));
    if ($checkMsg == 0) {
        $msg_date = time();
        $msg_perm = 'Admin';
        mysql_query("INSERT INTO $table (msg, msg_type, msg_onoff, msg_date, msg_perm) VALUES ('$msg', '$msg_type', '$msg_onoff', '$msg_date', '$msg_perm')") or die(mysql_error());
        header('Location: make_ann.php');
    } else {
        $msg_date = time();
        $msg_perm = 'Admin';
        mysql_query("UPDATE $table SET msg='$msg', msg_type='$msg_type', msg_onoff='$msg_onoff', msg_date='$msg_date' WHERE msg_perm='$msg_perm'") or die(mysql_error());
        header('Location: make_ann.php');
    }
} else {
include('../includes.php');
include('../settings.php');
$table = "i_ann";
$checkMsg = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(id) FROM $table")));
if ($checkMsg == 1) {
    $msg_perm = 'Admin';
    $new_result = mysql_query("SELECT * FROM $table WHERE msg_perm='$msg_perm'") or die(mysql_error());
    $new_row = mysql_fetch_array($new_result);
    $msg = $new_row['msg'];
    $msg_type = $new_row['msg_type'];
    $msg_onoff = $new_row['msg_onoff'];
    $msg_date = $new_row['msg_date'];
    renderForm($msg, $msg_type, $msg_onoff, $msg_date);
} else {
    renderForm('', '', '', '');
}
}
?>

    </div><!--/.fluid-container-->

  </body>
</html>