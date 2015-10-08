<?php
error_reporting(E_ERROR);
include('connect_db.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    // query db
    $id = $_GET['id'];
    $result = mysql_query("SELECT id,sharerlink FROM i_sharerlinks WHERE id='$id'") or die(mysql_error());
    $row = mysql_fetch_array($result);
    
    //check that the 'id' matches up with a row in the databse
    if ($row) {
        $url        = $row['sharerlink'];
        $removehttp = str_replace('http://', '', $url);
        $nakedip    = rtrim($removehttp, '/');
        if (strpos($nakedip, ':') !== false) {
            list($ip, $port) = explode(":", $nakedip);
        } else {
            $ip   = $nakedip;
            $port = 80;
        }
        
        
        if (fsockopen($ip, $port, $errno, $errstr, 5) !== false) {
            sleep(3);
            echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAVNJREFUeNrUk09OwkAUh9+gUKpAFIuIfxJilLIlMd6gaw+Ax/AY7r2AnMFFb2DcC5gYYlBotYKttEwp83zjQtFIN6x8yZfJ9PfypZM3wxARFqkELFgLC5ZnN+yyQF9YjrR12hpEiegRJghoQIQunj7PF1DlQOB5dadi6Nt6cSWlKiPu8+ZTq9bu3tUoPyPc+UcQWK9sHRh6oVIOXF91XpzE2AtUXTss72tlQ+axR4AQjb313aJlWSCEAM75J3JS2dVMUebUdREjECWcojLwBiCZRJOvKB2mFZnH/wEXvb7b5zbaKmR+No6jMZd5/Bg5mt3HByupJQE24Js8gD/0LJnHC0zecNuO6d06HcGmAWRBTCEK/NZbh9+PTJn/FrDZq8wYS0GeVeE4cQIldkT6TZq/DT28gWtxBa/YpP73OMESLWuE8seli4gh9YdzBf/zMX0IMACs96WetcYlTQAAAABJRU5ErkJggg==">';
        } else {
            echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAVlJREFUeNrUU0FOg0AU/VMbCA1tjI0iLmx1U9OQNk2MN2DtAeoxPIZ7L2DP4IIbGDdNF9oNITXBlISWgi0OhcGPRNMQYcPKSV7I5z0e//2ZIXEcQ5lVgZKrtEF1t3ggJHnRQNchlipCRrwjNAYwCgHcm0zkasawgcK7s15PPe/3JV4U+U/Po/p4PNAnkwHytwg3NwJ+PDxVFPVEUdq26wqmaVYWniccd7ttudNRWdpZfgcBtt1stSTDMIAxBpTSbyQ7VRdFKUhj3RcZyEEU8SvbBm+5hHC7/eVorcYH6UzyO6A4MMc0aWxZgpgRhr5PaTrQ/G1EgfY2m80POQ6aWP/gAOGs1/OELzRAdjR1HO3FdQ3CmF9P5hpF/nSzMXRKtYTPGpDdo0wI4fBvF1cA1xj2Et2PcPIW9v38BPC4AHhF/UeRwR4+9hH8H4cuTJKgPsg1+J+X6UuAAQAG85S2YfuhcwAAAABJRU5ErkJggg==">';
        }
        
    }
} else {
    echo 'ERROR 404!';
}

?>