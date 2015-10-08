<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Free Image Hosting by Ishare</title>
	<style type="text/css">
	body {
	margin:0;
	padding:0;
	font-family:"Lucida Grande", "Tahoma", "Helvetica", "Arial", sans-serif;
	background:#fff;
	color:#222;
	font-size: 12px;
	}
	#path {
	color: #333;
  background-color: #F8F8F8;
  border-bottom: 1px solid #CCC;
  padding: 3px 8px;
  margin: 0px;
  }
  #desc {
  border-bottom:1px dashed #ccc;
  margin-bottom:10px;
  padding: 5px 8px;
  }
  a { color:#3B5998;text-decoration:none; }
  a:hover { border-bottom:1px solid #222; }
  </style>
  </head>
  
<body>  

<?php
if(isset($_FILES['image']) AND is_array($_FILES['image']) AND $_FILES['image']['error'] == 0){
	require_once("SafelyUpload.php"); // Require SafelyUpload PHP class
	$upload	=	new SafelyUpload($_FILES['image'],"images",100);
//	$upload->resize();	// Optional !! Resize to width = 600  if width > height || Height = 600 if height > width
	if( $upload->upload() ){
	echo "<div id=\"path\" />&raquo; <a style=\"text-decoration:none;color:#222;\" href=\"http://mpp.eng.usm.my/sharers\" />Home</a> &raquo; Free Image Hosting</div>";
	echo "<div id=\"desc\" />Your image link: <a href=\"http://mpp.eng.usm.my/sharers/upload/".$upload->new_name."\" /><strong>http://mpp.eng.usm.my/sharers/upload/".$upload->new_name."</strong></a></div>";
		echo "<a href=\"http://mpp.eng.usm.my/sharers/upload/".$upload->new_name."\" /><img src=\"".$upload->new_name."\" /></a>";
	}
	else{
		echo $upload->error;
	}
}
else{
	echo "You're welcome only from <a href=\"index.html\">index.html</a>";
}
?>

</body>
</html>