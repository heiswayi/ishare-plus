<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>RoutePlanner by Ishare+</title>
        <!--[if IE]>
        <script src="dist/html5shiv.js"></script>
        <![endif]-->

        <link href="css/routeplanner.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="js/jquery-1.8.0.min.js" type="text/javascript"></script> 
        <script src="js/routeplanner.min.js" type="text/javascript"></script>   
        <script src="core/script.js" type="text/javascript"></script>
        <link href="../assets/css/ishare.css" rel="stylesheet">
        <style type="text/css">
        body { margin-top: 50px; }
        @media print { 
        .no-print { display:none; } 
        }
        </style>
        
</head>

<body onLoad="initialize()">

<div class="navbar navbar-fixed-top no-print">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="../index.php">Ishare<strong style="color:#ee0000">+</strong></a>
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
              <?php
              include('settings.php');
              $nickCheck = $_SESSION['userwd'];
              if (in_array(strtolower($nickCheck), $admin, true)) {
                  echo '<li class="divider"></li>';
                  echo '<li><a href="../admin">Administration</a></li>';
              }
              ?>
              <li class="divider"></li>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </div>
          
          <div class="nav-collapse">
            <ul class="nav">
            <li class="divider-vertical"></li>
            </ul>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

<!-- Print Button  -->
<div class="pb_container">	
    <div class="printbox"><span onClick="window.print()"><img src="img/print.png" width="22" height="22"></span></div>
</div>

<!-- Logo -->
<div class="logo"><img src="img/logo.png" width="400" height="75"></div>

<!-- Route Forms -->	
<div class="search_container"> 
    <form action="mode" onSubmit="calcRoute();return false;" id="routeForm">
          From:   <input type="text" id="routeStart" value="" style="margin-right:10px;">
          To:     <input type="text" id="routeEnd" value=""  style="margin-right:10px;">
    <input id="submit" type="submit" value="Calculate Route" onClick="">
        <input class="advance_toggle" id="advToggle" type="button" value="Options">
    </form>
</div> 

<!-- Advanced Options -->
<div class="adv_options">
    <div class="adv_options_container">
   	<span>Travel Options:</span>
    <select id="mode">
   		 <option selected="selected" value="DRIVING">Driving</option>
         <option value="WALKING">Walking</option>
         <option value="TRANSIT">Public Transport</option>
         <option value="BICYCLING">Cycling</option>
    </select>
    </div>
</div>
    
<!-- The Actual Map -->	
<div class="mapcontainer">
    <div id="map_canvas"></div>
</div>	
    <div class="marginfix"></div>
  
<!-- Directions Box  -->	       
<div id="directionsPanel">
    <div align="center"><span id="dirtext">Enter a destination and click "<strong>Calculate Route</strong>".</span>
     </div>
        </div>
  
<!--  Footer  -->        
<div class="footer">
	<div class="footerInner">
  <a href="../index.php">Ishare+ &copy; 2012</a>
    </div>
</div>
 
<!-- Scroll To Top  -->	       
	<script src="js/easing.min.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.min.js" type="text/javascript"></script>
	<script src="../assets/js/ishare-dropdown.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var defaults = {
	  			containerID: 'UItoTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
    
</body>
</html>