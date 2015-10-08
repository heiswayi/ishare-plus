<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>HFS Crawler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>


    <div class="container">
    
      <div class="page-header">
        <h1><a href="index.php">HFS Crawler</a> <small>Version 1.0</small></h1>
      </div>
      
      <div class="row">
        <div class="span12">     

<table class="table table-striped table-bordered">
  <tbody>

<?php
if ((isset($_GET['crawl']) == 'Crawl') && isset($_GET['url'])) {
$url = urldecode($_GET['url']);

set_time_limit(0);
include("libs/PHPCrawler.class.php");
class MyCrawler extends PHPCrawler 
{
  function handleDocumentInfo($DocInfo) 
  {
    if ($DocInfo->http_status_code == 200) {
      $info = pathinfo($DocInfo->url, PATHINFO_EXTENSION);
      if (($info == 'mp4') || ($info == 'mp3') || ($info == 'dat') || ($info == 'wav') || ($info == 'ogg') || ($info == 'wma') || ($info == 'avi') || ($info == 'mkv') || ($info == 'rmvb') || ($info == 'srt')) {
        echo '<tr><td>';
        echo '<span class="badge badge-success">Link</span> <a href="'.$DocInfo->url.'">'.urldecode($DocInfo->url).'</a><br />';
        echo '<span class="badge">Referer-link</span> <a href="'.$DocInfo->referer_url.'">'.urldecode($DocInfo->referer_url).'</a>';
        echo '</td></tr>';
        flush();
      }
    }
  } 
}
$crawler = new MyCrawler();
$crawler->setURL($url);
$crawler->addContentTypeReceiveRule("#text/html#");
//$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
$crawler->setTrafficLimit(5000 * 1024);
$crawler->go();
$report = $crawler->getProcessReport();
}
?>

  </tbody>
</table>

        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; <a href="http://mpp.eng.usm.my/sharers">Ishare+</a>, December 2012. Created by Heiswayi Nrird.</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
  </body>
</html>

