<?php
session_start();
define('NoDirectAccess', TRUE);
include('header.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>Free Image Hosting</h1>
</div>
</div>

    <div class="container">
    <div class="row">
    
<div class="span8">
<div class="well special-bg">    
<div class="hero-unit" style="background:#fff;">
  <p><span class="label label-important">Disclaimer</span><br />This is a Free Image File Hosting and it's public. You may use this service to host your image file your HFS background or to promote some events by poster and etc.. Any prohibited image uploaded here will be removed soon!<br />
  <span class="label label-info">Restriction</span><br />
  Allowed file format: .JPG / .GIF / .PNG / .JPEG / .BMP / .TIF<br />
  Max. file size: 1 Mb</p>
  <hr class="hrcolor-override">
 
 <form class="form-horizontal" action="upload/upload.php" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Upload Form</legend>
    <div class="control-group">
      <label class="control-label" for="input01">Select image file:</label>
      <div class="controls">
        <input type="file" name="image" class="input-xlarge" id="input01">
        <p class="help-block" style="color:#ff0000;">If your image file is successfully uploaded, don't forget your image link!</p>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="Upload" class="btn btn-success" />
    </div>
  </fieldset>
</form>
 
</div>
</div>
</div><!--/span-->



<div class="span4">
<div class="well special-bg">
<?php include('sharerlink.php'); ?>
</div>
</div><!--/span-->

</div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->

<?php include('footer.php'); ?>