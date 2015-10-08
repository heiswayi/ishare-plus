<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ishare+ | Portal of Sharers</title>
    <meta name="description" content="A digital place for USM Engineering Campus students to share their stuffs and chat with people.">
    <meta name="author" content="Heiswayi Nrird">

    <!-- Le styles -->
    <link href="assets/css/ishare.css" rel="stylesheet">
    <link href="assets/css/google-style.css" rel="stylesheet">
    <style type="text/css">
      body { padding-bottom: 40px; }
      .sidebar-nav { padding: 9px 0; }
      .span6-intro { background:#000 url(assets/homepic/ishare.png); }
      .welcome-text { color: #333; text-shadow: white 0 1px 2px; }
    </style>
    <link href="assets/css/sandbox.css?<?php echo "20121202"; ?>" rel="stylesheet">
    <link href="assets/css/typeface.css" rel="stylesheet">
    <link href="assets/css/event-ticker.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="assets/css/ie-suck.css" />
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    
    <script src="assets/js/jquery.js"></script>
    <script src="raptorize/jquery.raptorize.1.0.js"></script>
    <script src="assets/js/airport.js"></script>
    <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('.raptorize').raptorize();
      //jQuery('#airport').airport([ 'Welcome to Ishare+', 'Portal of Sharers', 'Happy New Year 2013' ]);
    });
    </script>

  </head>

  <body>
  
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="index.php">Ishare<strong style="color:#ee0000">+</strong></a>
          <?php if(isset($_SESSION['userwd'])){ ?>
          <div class="btn-group pull-right">
          <a class="btn btn-danger" href="index.php">Home</a>
            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $_SESSION['userwd']; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="profile.php?user=<?php echo $_SESSION['userwd']; ?>">View Profile</a></li>
              <li><a href="edit.php?user=<?php echo $_SESSION['userwd']; ?>">Edit Profile</a></li>
              <?php
              include('settings.php');
              $nickCheck = $_SESSION['userwd'];
              if (in_array(strtolower($nickCheck), $admin, true)) {
                  echo '<li class="divider"></li>';
                  echo '<li><a href="admin">Administration</a></li>';
              }
              ?>
              <li class="divider"></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
          
          <div class="nav-collapse">
            <ul class="nav">
            <li class="divider-vertical"></li>
              <li><a href="about.php">About</a></li>
              
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-th-list icon-white"></i> Pages<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="request_shouts.php?page=1">Request Shouts</a></li>
                      <li><a href="sharer_updates.php?page=1">Update Shouts</a></li>
                      <li class="divider"></li>
                      <li><a href="gamers_corner.php"><i class="icon-comment"></i> Gamers Corner</a></li>
                      <li><a href="silent_room.php"><i class="icon-comment"></i> Silent Room</a></li>
                      <li><a href="forum/board/"><i class="icon-comment"></i> Forum Ishare</a></li>
                  </ul>
              </li>
              
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-gift icon-white"></i> Services<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="hfs.php">HFS Templates Upload</a></li>
                      <li><a href="image_hosting.php">Free Image Hosting</a></li>
                      <li><a href="info">Check IP &amp; Location</a></li>
                      <li><a href="routeplanner">RoutePlanner</a></li>
                      <li><a href="drawing">Drawing Canvas</a></li>
                      <li><a href="audiovisualizer" target="_blank">AudioVisualizer</a></li>
                      <li><a href="audio" target="_blank">audio<strong>player</strong></a></li>
                      <li class="divider"></li>
                      <li><a href="http://hik3.net/notepad"><i class="icon-bookmark"></i> Online Notepad</a></li>
                      <li><a href="http://hik3.net/dl"><i class="icon-bookmark"></i> File Download Linker</a></li>
                  </ul>
              </li>
              
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-magnet icon-white"></i> Links<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="http://mpp.eng.usm.my/">Blog MPPUSMKKj</a></li>
                      <li><a href="http://hepp.eng.usm.my/">Portal BHEPP USMKKj</a></li>
                      <li><a href="http://infodesk.eng.usm.my/">Infodesk PPKT USMKKj</a></li>
                      <li><a href="http://www.eng.usm.my/php/blockedIP/">Blocked Port List</a></li>
                      <li><a href="http://elearning.usm.my/">e-Learning Portal</a></li>
                      <li><a href="http://campusonline.usm.my/">Campus Online</a></li>
                      <li><a href="http://www.tcom.usm.my/">Sistem Direktori Telefon USM</a></li>
                      <li><a href="http://mpp.eng.usm.my/events">Event Lister System</a></li>
                      <li><a href="http://www.facebook.com/ppkt.eng.usm">PPKT USMKKj (FB Page)</a></li>
                      <li class="divider"></li>
                      <li><a href="http://hik3.net/refcode"><i class="icon-bookmark"></i> RefCode (Snippets)</a></li>
                  </ul>
              </li>
              
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-refresh icon-white"></i> Networks<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="http://www.facebook.com/groups/komuniti.ishare/">Komuniti Ishare (FB)</a></li>
                  </ul>
              </li>
              
              <li><a href="gamers_corner.php"><i class="icon-comment icon-white"></i> Gamers Corner</a></li>
              <li><a href="silent_room.php"><i class="icon-comment icon-white"></i> Silent Room</a></li>
              <li><a href="forum/board/"><i class="icon-comment icon-white"></i> Forum Ishare</a></li>
              
            </ul>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>