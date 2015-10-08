<style>body { font-family: "Lucida Console"; font-size: 10pt; }</style>
<?php
// SAMPLE MODEL: <img src="assets/img/onion/phuw.gif" onclick="insertSmiley('{phuw}')" title="{phuw}" />
$files = glob("*.*");
for ($i=1; $i<count($files); $i++) {
  $filename = $files[$i];
  if ($filename != 'index.php') {
  $onlyname = str_replace(".gif", "", $filename);
  //echo '&lt;img src="assets/img/tuzki/' . $filename . '" onclick="insertSmiley(\'[:' . $onlyname . ':]\')" title="[:' . $onlyname . ':]" /&gt;';
  echo '&lt;img src="assets/img/onion/' . $filename . '" onclick="insertSmiley(\'{:' . $onlyname . ':}\')" title="{:' . $onlyname . ':}" /&gt;';
  echo '<br />';
  //$protocol = 'http'.(!empty($_SERVER['HTTPS']) ? 's' : '');
  //$root = $protocol.'://'.$_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
  //echo '\'' . $root . '/' . $onlyname .'.gif\', ';
  }
}
?>