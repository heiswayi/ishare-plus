<?php
session_start();
include('header.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <h1>HFS Templates</h1>
</div>
</div>

    <div class="container">
    <div class="row">
    
<div class="span8">
<div class="well special-bg">

<div style="margin-bottom:10px;text-align:right;"><a href="hfs/" class="btn btn-success">Upload your customized HFS template here <i class="icon-upload icon-white"></i></a></div>

<table class="table table-striped table-bordered" style="background:#fff;"><thead><tr>
<th>Filename <i class="icon-download"></i></th><th>Author</th><th>Upload Date</th>
</tr></thead><tbody>
<?php
include('includes.php');
$queryData = mysql_query("SELECT * FROM i_hfs") or die(mysql_error());
$hfs_repo = 'hfs/repo/';
while ($row = mysql_fetch_assoc($queryData)) {
$hfs_id = $row['id'];
$hfs_name = $row['filename'];
$hfs_author = $row['author'];
$upload_date = $row['uploaddate'];
echo '<tr>';
echo '<td><a href="'.$hfs_repo.$hfs_name.'" target="_blank">'.$hfs_name.'</a></td>';
echo '<td>'.$hfs_author.'</td>';
echo '<td>'.date('d.m.Y g:i A', $upload_date).'</td>';
echo '</tr>';
}
?>
</tbody>
</table>

</div>
</div><!--/span-->



<div class="span4">
<div class="well special-bg">
<div class="alert alert-info">
<a href="http://en.wikipedia.org/wiki/HTTP_File_Server" class="label label-info"><i class="icon-hand-right icon-white"></i> Wikipedia</a> HTTP File Server, otherwise known as HFS, is a free web server specifically designed for publishing and sharing files. The complete feature set differs from other web servers; it lacks some common features, like CGI, or even ability to run as a Windows service, but includes, for example, counting file downloads. It is even advised against using it as an ordinary web server.[2] Its foremost feature is its extreme ease of use even for ordinary home users; just launch one file and you're all set, no configuration or installation. HFS has received generally very positive reviews.
</div>



</div>
</div><!--/span-->

</div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->

<?php include('footer.php'); ?>