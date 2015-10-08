<?php
session_start();
if ($_SESSION['NoRedirect_US'] == 'false') { die('Direct access is not permitted!'); }
else { $_SESSION['NoRedirect_US'] = 'false'; }
ob_start();
function sanitize($string, $force_lowercase = false, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", " ", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "—", "–", ",", "<", ">", "/", "?");
    $clean = trim(str_replace($strip, " ", strip_tags($string)));
    $clean = preg_replace('/\s+/', "_", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}
function check_ext($file_name)
{
  return substr(strrchr($file_name,'.'),1);
}
$antispam = $_POST['antispam'];
if ($antispam !== '') { die(); }

$uploader = $_POST['uploader'];
$author = htmlspecialchars($_POST['author']);
$filenamed = htmlspecialchars($_POST['filename']);
$filenamex = $_FILES['file']['name'];
$Ext = substr($_FILES['file']['name'], strpos($_FILES['file']['name'],'.'), strlen($_FILES['file']['name'])-1);
$filesize = $_FILES['file']['size'];
$fs = $_FILES['file']['size'] / 1024;
$fs_limit = 1.049e+6; // <-- 1 Mb // 1024 bytes = 1 Kb

$path = 'repo/'; //CHMOD 777 (writable)
?>

<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Upload - HFS Templates Only</title>

  <!-- Included CSS Files -->
  <link rel="stylesheet" href="stylesheets/foundation.css">
  <link rel="stylesheet" href="stylesheets/app.css">

  <!--[if lt IE 9]>
    <link rel="stylesheet" href="stylesheets/ie.css">
  <![endif]-->

  <script src="javascripts/modernizr.foundation.js"></script>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

  <div class="row">
    <div class="six columns main-box">
    <div class="desc">Hello, <strong><?php echo $uploader; ?></strong>! Now, you can share your customized <a href="http://www.rejetto.com/hfs/" class="has-tip tip-top" title="HTTP File Server - Official Site">HFS</a> template by uploading it here. Once uploaded, you can't delete it, you need to contact <a href="../team.php" class="has-tip tip-top" title="People who voluntarily to take care of this matter">Ishare Technology Team</a> for manually request.
    <div class="cond">
    <strong>File extension allowed:</strong> .tpl (recommended) / .txt / .zip<br />
    <strong>Max. filesize:</strong> 500 Kb
    </div></div>
    <fieldset>
    <legend>Uploader</legend>
    
    <?php
    include('../connect_db.php');
    if ($filenamex == '') {
        echo '<div class="alert-box alert">';
        echo 'ERROR: Please select any file!';
        echo '<a href="" class="close">&times;</a>';
        echo '</div>';
        echo '<a href="index.php" class="radius secondary button">Back</a>';
    } else {
        if ($Ext == '.tpl' || $Ext == '.txt' || $Ext == '.zip') {
        if ($filesize > $fs_limit) {
            echo '<div class="alert-box alert">';
            echo 'ERROR: Your filesize is overlimit (>1Mb)!';
            echo '<a href="" class="close">&times;</a>';
            echo '</div>';
            echo '<a href="index.php" class="radius secondary button">Back</a>';
        }
        else if ($filenamed !== '') {
            $fn = sanitize($filenamed);
            
            echo '<div class="alert-box success">';
            echo 'SUCCESS: Your HFS Template was successfully uploaded!';
            echo '</div>';
        
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Filename</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="filename" id="filename" value="'.$fn.'" disabled />';
            echo '</div>';
            echo '</div>';
        
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Filesize</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="filesize" id="filesize" value="'.round($fs, 2).' Kb" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Author</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="author" id="author" value="'.$author.'" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Uploader</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="uploader" id="uploader" value="'.$uploader.'" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<a href="../hfs.php" class="radius button">To Repository</a> <a href="../" class="radius secondary button">Back to Ishare+ Home</a>';
        
            move_uploaded_file($_FILES['file']['tmp_name'], $path . $fn . $ext);
            $udate = time();
            $fullfname = $fn . $ext;
            if ($author !== '') { $thisauthor = $author; }
            else { $thisauthor = 'Anonymous'; }
            mysql_query("INSERT i_hfs SET uploaddate='$udate', filename='$fullfname', author='$thisauthor', uploader='$uploader'") or die(mysql_error());
            
        } else {
            $fn = sanitize($filenamex);
            
            echo '<div class="alert-box success">';
            echo 'SUCCESS: Your HFS Template was successfully uploaded!';
            echo '</div>';
            
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Filename</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="filename" id="filename" value="'.$fn.'" disabled />';
            echo '</div>';
            echo '</div>';
        
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Filesize</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="filesize" id="filesize" value="'.round($fs, 2).' Kb" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Author</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="author" id="author" value="'.$author.'" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="row collapse">';
            echo '<div class="three mobile-two columns">';
            echo '<span class="prefix">Uploader</span>';
            echo '</div>';
            echo '<div class="nine mobile-four columns">';
            echo '<input type="text" name="uploader" id="uploader" value="'.$uploader.'" disabled />';
            echo '</div>';
            echo '</div>';
            
            echo '<a href="../hfs.php" class="radius button">To Repository</a> <a href="../" class="radius secondary button">Back to Ishare+ Home</a>';
        
            move_uploaded_file($_FILES['file']['tmp_name'], $path . $fn);
            $udate = time();
            if ($author !== '') { $thisauthor = $author; }
            else { $thisauthor = 'Anonymous'; }
            mysql_query("INSERT i_hfs SET uploaddate='$udate', filename='$fn', author='$thisauthor', uploader='$uploader'") or die(mysql_error());
        }
    } else {
        echo '<div class="alert-box alert">';
        echo 'ERROR: Only file with extension .tpl / .txt / .zip is allowed!';
        echo '<a href="" class="close">&times;</a>';
        echo '</div>';
        echo '<a href="index.php" class="radius secondary button">Back</a>';
    }
    }
    ?>
    
    <div class="clear"></div>
    </fieldset>
    </div>
  </div>
  
  <div class="row"><div class="six columns credit">This script is a part of <strong>Ishare+</strong>, &copy; 2012</div></div>



  <!-- Included JS Files -->
  <script src="javascripts/jquery.min.js"></script>
  <script src="javascripts/jquery.reveal.js"></script>
  <script src="javascripts/jquery.orbit-1.4.0.js"></script>
  <script src="javascripts/jquery.customforms.js"></script>
  <script src="javascripts/jquery.placeholder.min.js"></script>
  <script src="javascripts/jquery.tooltips.js"></script>
  <script src="javascripts/app.js"></script>

</body>
</html>
<?php ob_flush(); ?>