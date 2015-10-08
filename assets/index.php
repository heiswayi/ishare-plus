<style>body { font-family: "Lucida Console"; font-size: 10pt; }</style>
<?php
$files = glob("*.*");
for ($i=1; $i<count($files); $i++) {
  $filename = $files[$i];
  if ($filename != 'index.php') {
  
  $protocol = 'http'.(!empty($_SERVER['HTTPS']) ? 's' : '');
  $root = $protocol.'://'.$_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
  echo '\'' . $root . '/' . $filename . '\', ';
  }
}
?>