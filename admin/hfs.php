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

$config['table'] = "i_hfs";

//CONNECT
include('../includes.php');
include('../settings.php');

//IF ORDERBY NOT SET, SET DEFAULT
if(!isset($_GET['orderby']) OR trim($_GET['orderby']) == ""){
	//GET FIRST FIELD IN TABLE TO BE DEFAULT SORT
	$sql = "SELECT * FROM `".$config['table']."` LIMIT 1";
	$result = mysql_query($sql) or die(mysql_error());
	$array = mysql_fetch_assoc($result);
	//first field
	$i = 0;
	foreach($array as $key=>$value){
		if($i > 0){break;}else{
		$orderby=$key;}
		$i++;		
	}
	//default sort
	$sort="ASC";
}else{
	$orderby=mysql_real_escape_string($_GET['orderby']);
}	

//IF SORT NOT SET OR VALID, SET DEFAULT
if(!isset($_GET['sort']) OR ($_GET['sort'] != "ASC" AND $_GET['sort'] != "DESC")){
	//default sort
		$sort="ASC";
	}else{	
		$sort=mysql_real_escape_string($_GET['sort']);
}

//GET DATA
$sql = "SELECT * FROM `".$config['table']."` ORDER BY $orderby $sort";
$result = mysql_query($sql) or die(mysql_error());

//START TABLE AND TABLE HEADER
echo "<table class=\"table table-striped table-bordered table-condensed\">\n<thead>\n<tr>";
$field1 = columnSortArrows('id','ID',$orderby,$sort);
$field2 = columnSortArrows('filename','Filename',$orderby,$sort);
$field3 = columnSortArrows('author','Author',$orderby,$sort);
$field4 = columnSortArrows('uploaddate','Upload Date',$orderby,$sort);
$field5 = columnSortArrows('uploader','Uploader',$orderby,$sort);
echo "<th>" . $field1 . "</th>\n";
echo "<th>" . $field2 . "</th>\n";
echo "<th>" . $field3 . "</th>\n";
echo "<th>" . $field4 . "</th>\n";
echo "<th>" . $field5 . "</th>\n";
echo "<th></th>\n";
echo "</tr>\n</thead>\n";

//reset result pointer
mysql_data_seek($result,0);

//LOOP TABLE ROWS
echo "<tbody>\n";
while($row = mysql_fetch_assoc($result)){
  
	echo "<tr>\n";
	echo "<td>".$row['id']."</td>\n";
	echo "<td>".$row['filename'];
	echo "</td>\n";
	echo "<td>".$row['author']."</td>\n";
	echo "<td>".date('d/m/Y, H:m', $row['uploaddate'])."</td>\n";
	echo "<td>".$row['uploader']."</td>\n";
	echo "<td>";
	echo '<a href="delete_hfs.php?u='.$row['filename'].'">Delete</a></td>';
	echo "</tr>\n";
	
}
echo "</tbody>\n";

//END TABLE
echo "</table>\n";

/*FUNCTIONS*/

function columnSortArrows($field,$text,$currentfield=null,$currentsort=null){	
	//defaults all field links to SORT ASC
	//if field link is current ORDERBY then make arrow and opposite current SORT
	
	$sortquery = "sort=ASC";
	$orderquery = "orderby=".$field;
	
	if($currentsort == "ASC"){
		$sortquery = "sort=DESC";
		$sortarrow = '<i class="icon-chevron-up"></i>';
	}
	
	if($currentsort == "DESC"){
		$sortquery = "sort=ASC";
		$sortarrow = '<i class="icon-chevron-down"></i>';
	}
	
	if($currentfield == $field){
		$orderquery = "orderby=".$field;
	}else{	
		$sortarrow = null;
	}
	
	return '<a href="?'.$orderquery.'&'.$sortquery.'">'.$text.'</a> '. $sortarrow;	
	
}

?>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/ishare-transition.js"></script>
    <script src="../assets/js/ishare-alert.js"></script>
    <script src="../assets/js/ishare-modal.js"></script>
    <script src="../assets/js/ishare-dropdown.js"></script>
    <script src="../assets/js/ishare-scrollspy.js"></script>
    <script src="../assets/js/ishare-tab.js"></script>
    <script src="../assets/js/ishare-tooltip.js"></script>
    <script src="../assets/js/ishare-popover.js"></script>
    <script src="../assets/js/ishare-button.js"></script>
    <script src="../assets/js/ishare-collapse.js"></script>
    <script src="../assets/js/ishare-carousel.js"></script>
    <script src="../assets/js/ishare-typeahead.js"></script>
    <script src="../assets/js/jquery.popupWindow.js"></script>
    <script src="../assets/js/application.js"></script>
    <script src="../assets/js/shoutbox.js"></script>

  </body>
</html>