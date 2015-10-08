<?php
session_start();
if (!isset($_SESSION['NoRedirect_US'])) { $_SESSION['NoRedirect_US'] = 'true'; }
else { $_SESSION['NoRedirect_US'] = 'true'; }
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

  <title>Ishare+ | Upload - HFS Templates Only</title>

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
    <div class="desc">Hello, <strong><?php if(isset($_SESSION['userwd'])){ echo $_SESSION['userwd']; } ?></strong>! Now, you can share your customized <a href="http://www.rejetto.com/hfs/" class="has-tip tip-top" title="HTTP File Server - Official Site">HFS</a> template by uploading it here. Once uploaded, you can't delete it, you need to contact <a href="../team.php" class="has-tip tip-top" title="People who voluntarily to take care of this matter">Ishare Technology Team</a> for manually request.
    <div class="cond">
    <strong>File extension allowed:</strong> .tpl (recommended) / .txt / .zip<br />
    <strong>Max. filesize:</strong> 500 Kb
    </div></div>
    <form action="upload_status.php" method="post" enctype="multipart/form-data">
    <fieldset>
    <legend>Uploader</legend>
    <div class="row collapse">
      <div class="three mobile-two columns">
        <span class="prefix">Filename</span>
      </div>
      <div class="nine mobile-four columns">
      <input type="text" name="filename" id="filename" placeholder="Optional" value="" />
      </div>
      <div class="three mobile-two columns">
        <span class="prefix">Author</span>
      </div>
      <div class="nine mobile-four columns">
      <input type="text" name="author" id="author" placeholder="Optional" value="" />
      </div>
    </div>
    <div class="row">
    <div class="four columns">
      <input type="file" name="file" id="file" />
    </div>
    <div class="two columns">
      <?php
      if(isset($_SESSION['userwd'])){
          echo '<input type="hidden" name="uploader" id="uploader" value="'.$_SESSION['userwd'].'">';
      } else {
          header('Location: ../login.php');
      }
      ?>
      <input type="hidden" name="antispam" />
      <input type="submit" name="upload" class="radius success button small" style="float:right;" value="Upload" />
    </div>
    </div>
    <div class="clear"></div>
    </fieldset>
    </form>
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