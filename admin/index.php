<?php
session_start();
session_regenerate_id();
function renderForm($error)
{
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
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="container mydrag">

<div class="row">
  <div style="margin:100px auto;width:400px;">
  <div class="well" style="border:1px solid #ddd;">
  <div class="controls">
  
  <?php
  if ($error != '') {
  echo '<div class="alert alert-error">';
  echo '<a class="close" data-dismiss="alert" href="#">×</a>';
  echo '<h4 class="alert-heading">Access Denied!</h4>';
  echo $error;
  echo '</div>';
  }
  ?>
  
  <form action="" method="post">
              <div class="input-prepend">
                <span class="add-on">Verification: </span><input class="span2" id="prependedInput" size="16" type="password" name="code" placeholder="Enter Access Code Here"> <input type="submit" name="submit" class="btn btn-success" value="Proceed" style="float:right;">
              </div>
  </form>
  
  </div>
  </div>
  </div>
</div>

    </div><!--/.fluid-container-->

  </body>
</html>

<?php
}

include('../includes.php');
include('../settings.php');

if (isset($_POST['submit'])) {
    $code = mysql_real_escape_string(htmlspecialchars($_POST['code']));
    
    if ($code !== 'IshareComel812') {
        $error = 'The authentication code you entered is invalid. Please try again!';
        renderForm($error);
    } else {
        $_SESSION['xuidPJVE218'] = 'OK';
        header('Location: users.php');
    }
} else {
    include('../includes.php');
    include('../settings.php');
    if (!isset($_SESSION['userwd'])) { header('Location: ../404.php'); }
    else {
        $nick = $_SESSION['userwd'];
        $data = mysql_query("SELECT (userwd) FROM i_users WHERE userwd='$nick'") or die(mysql_error());
        if (mysql_num_rows($data) > 0 && in_array(strtolower($nick), $admin, true)) {
            if (isset($_SESSION['xuidPJVE218'])) { header('Location: users.php'); }
            else { renderForm(''); }
        } else {
            header('Location: ../404.php');
        }
    }
}

?>