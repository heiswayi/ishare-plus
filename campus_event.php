<?php
include('connect_db.php');
$result = mysql_query("SELECT * FROM hn_event ORDER BY id DESC");
if ($result) {
?>
<script src="assets/js/jquery.ticker.js" type="text/javascript"></script>
<div id="event_ticker">
<span class="event_global_title">CAMPUS EVENTS</span>
<ul id="js-news" class="js-hidden">
<?php
if (mysql_num_rows($result) > 0) {
while($row = mysql_fetch_array( $result )) {
                
    $md = strtotime($row['date']);
    $cd = strtotime('now');
    $next24 = strtotime("+24 hours", $md);
                
    if ($cd > $next24) {
        $event_id = $row['id'];
        $go_delete = mysql_query("DELETE FROM hn_event WHERE id='$event_id'") or die(mysql_error());
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
    else if ($cd < $md) {
        echo '<li class="news-item"><span class="event_status_in">Upcoming</span> <a href="http://mpp.eng.usm.my/events/view_event.php?id=' . $row['id'] . '" target="_blank" title="Click for details...">' . $row['name'] . '</a> <span class="event-date">'.$row['date'].'</span></li>';
    }
    else if (($cd >= $md) && ($cd <= $next24)) {
        echo '<li class="news-item"><span class="event_status_ha">Happening Now</span> <a href="http://mpp.eng.usm.my/events/view_event.php?id=' . $row['id'] . '" target="_blank" title="Click for details...">' . $row['name'] . '</a> <span class="event-date">'.$row['date'].'</span></li>';
    }                 
}
} else { 
    echo '<li class="news-item">No upcoming event added yet. <a class="event_status_add" href="http://mpp.eng.usm.my/events/add_event.php" target="_blank">Add an Event</a></li>';
}
?>
</ul>
</div>
<?php } ?>