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
        <div class="span8">     

<form class="form-horizontal" action="crawler.php" method="GET">
  <fieldset>
    <legend>Crawler</legend>
    <div class="control-group">
      <label class="control-label" for="input01">URL to Crawl:</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="input01" name="url">
        <p class="help-block">HFS URL. Full URL.<br /><strong>Example:</strong> http://10.122.255.255/</p>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <input type="submit" class="btn btn-primary" value="Crawl" name="crawl">
        <p class="help-block">Crawling may take several minutes to complete depending how much file links available on that HFS server. Please be patient!</p>
      </div>
    </div>
  </fieldset>
</form>

        </div><!--/span-->
        <div class="span4">
          <div class="well">
          <strong>Crawler will only display the results based on these following extensions:-</strong>
          <ul>
          <li>mp3, mp4, dat, wav, ogg</li>
          <li>wma, avi, mkv, rmvb</li>
          <li>srt</li>
          </ul>
          <p>For any additional file extension, future upgrade, bug report or discussion to improve this crawler, you may refer to <a href="http://mpp.eng.usm.my/sharers/forum/board">Forum Ishare</a>.</p>
          </div><!--/well-->
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
