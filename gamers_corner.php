<?php
session_start();
define('NoDirectAccess', TRUE);
include('gamers_corner_header.php');
?>

<div class="under-nav special-bg">
<div class="head-text">
  <img src="assets/img/gc.png" title="Gamers Corner">
</div>
</div>

    <div class="container">
      
      <div class="row">
        <div class="span8">
    
<div class="well special-bg">

<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (!preg_match('/Chrome/i', $user_agent)) { 
echo '<div id="for-chrome">';
echo '<span class="label label-info">Whassup?!</span> Get <strong><a href="http://www.google.com/chrome/" target="_blank">Google Chrome</a></strong> for better experience in browsing the Internet. It\' fast and free web browser!';
echo '</div>';
}
?>

 <form class="form-horizontal" action="" method="post" onsubmit="return push_shout()">
<?php
if(isset($_SESSION['userwd'])){
  echo '<input type="hidden" name="user" id="user" value="'.$_SESSION['userwd'].'">';
} else {
	header('Location: login.php');
}
?>
<input type="hidden" name="antispam" id="antispam" value="" />
<div class="shouting-section">
<textarea class="shouting-box" placeholder="Shout Like A Boss!" name="shout" id="shout" rows="3" maxlength="500"></textarea>
<div class="shouting-function">
<span class="shouting-count"><a href="#" class="raptorize"><img src="raptorize/dino.png" style="margin-top:-4px;"></a>
<span id="charcount">500</span></span>
<span id="active-user" class="active-user outip" title="Online Users"><?php include('active_user.php'); ?></span>
<span id="total-user" class="active-user actip" title="Registered Users"><i class="icon-user"></i> 
<?php
include('includes.php');
$totaluser = implode(mysql_fetch_assoc(mysql_query("SELECT COUNT(userwd) FROM i_users")));
echo $totaluser;
?>
</span>
<span data-toggle="modal" id="tos" class="disclaimer">Terma &amp; Syarat</span>
<span class="shouting-btn">
<img data-toggle="modal" id="showTuzki" class="showTuzki" src="data:image/png;base64,R0lGODlhEAAQAHAAACH5BAEAAD8ALAAAAAAQABAAhf///+Hh4c3Nzebm5qurq5+fn+jo6JiYmLe3t7Kysqmpqby8vKOjo7a2tv7+/sTExKGhoc7Ozr29vb6+vqCgoMfHx/39/a6urvLy8vb29sjIyLm5udvb2/X19aenp+rq6sPDw/Hx8fn5+cvLy+vr69HR0bi4uOnp6bq6utra2tTU1Pr6+tPT08zMzOTk5L+/v6+vr8bGxrOzs93d3ff399nZ2e7u7o6OjqysrJycnN/f37W1tcLCwpGRkZ6engAAAAZWQIBwSCwaAbYWoGU7EgkH22HhHBIIi2l1eWgtssrjtfg1lo2EWZFg+za9SepwtrDNZm8mnWgjOL1kYUQzB0Z9aTZxbE4LN19QW4AAe1WNQllbmACaQ0EAOw==" title="Tuzki"> 
<img data-toggle="modal" id="showOnions" class="showOnions" src="data:image/gif;base64,R0lGODlhEAAQAOYAAAAAAP////729/73+OPg4f/+//v6+/Tz9Ojn6Ofm5+Xk5cTDxLy7vLq5urm4uf7+//v7/Pb29/Ly89PU1vT19vr7+/Dx8drb28fIyLe4uLS1tdLU0/T19DU1NP///efn5tra2crKya+vrquUdKmdjePXx62kmNzSxOXf18fEwLmffrKdhM+9pqydi/Hm2MG8trihh6uci/Hl1720q9bSzsfFw8/Kxs7My7ylodK/vbCNiq+Jh7GMi9Ktrdm9vejU1FVUVH9+fvj39+Pi4tfW1tLR0c/Ozs7NzcbFxbm4uJuamv7+/vz8/Pv7+/r6+vn5+ff39/T09PPz8/Hx8fDw8O/v7+3t7ezs7Ovr6+np6efn5+Xl5eTk5OLi4uHh4eDg4Nvb29nZ2dfX19bW1tPT08/Pz83NzcfHx8XFxcLCwsHBwb29vbu7u7i4uLOzs6mpqZ2dnVZWViwsLP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAHMALAAAAAAQABAAAAeygAGCgjcmNBSDiYIPEgQvIyotNhCKATUxKzAsJS4yJylTih8zJCgeiUJFoYkWE5UBT2ZNiURVY2KJVExdXIMVIFhsQVmCW3BpVmGDPjgBcXKrah1KFRuDPToBGm6DbUAXPzwDgyFOghFNTktQATk7AoNhRoJYZFqCTBgcimdoUYlZ1nipVCXDAgYOGqhJcqTSEjJgAhxQkMCAlDJUFEERgUQRgjddKl0ZEqBAyQBSviQKBAA7" title="Onion Club"> 
<img id="showSmileys" class="showSmileys" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAwRJREFUeNp8U0tPE1EYPTOdKTCUltJpC0gkCjWKtgmIjxglGIgxGl3o3oXRxKU/QGIMP0A3GuPSlStNTHShLsREQQRBeWlrJeWZgaJIZ6a1czvX7/LwsXGSM3fm3nPO/b7vfleauQ9IEqAo66Mmy+gGcJrQRPAT1ghpwhPXxQvOYTMGJB8CY49Ihz9PjBZ7Fb29tXLn2ajia9Rkb5XiFnOMmZl26+vjzp/G0AjxegipLdGWQcyVKu5Wxy8ktGibDpdmOKFoQeZQvVo04E1cDtjG/prVsfthIH9ly0R2HGgUUm+g5VxCqwrq3F4Ed0xwZv470rxYFzzBn+/H+RIwpJRK6C4P727TfH7dzRtk6YPksakgqvAnUDjcAS/lwV0T5V6fPv082r2aM9qJdU2hCE77G/ZF+NosiSgj2QIXYvENaSMXztZNzPkfeHtrHMYMC1bHkdQ1PBAGTV5V1Xj+O/HFjvnNUf6rvi4W+pcxeCeJssoQlDqPFDuxUlDKiFUswu/hTOHkxIs/N0HhFu3fWBgwMHj7M+K7u7BoZnH8agKuBB9podBrrWhZTGFMXQ9Zcjd2F81B/8aqjOEZD+J7utE3+RzHLm0HVYsJ3fopFApI5759tzlzqUhA35sFOI6HlsqwmnUwnPbi5I1XeBaYwtGLjdjZ5ofgCx0BsmniSWosvQSZEuIq6uuCmEqtIJdXMfp+BrGaCO5d70JHVy2aDlALEE/whc6yAM+ZOGa/Za2DlX5/bbCmRguGImBQ8W40g7GJNAZfT6PjcAPqa6vgUi/PZpazkx+m31Av3KQ0HMW2YVML9/T3TYVLJW+ieW9Ib9gegj+8A22HjsBD5VAlRi1bQCY5lx0Z+PSROeihEtnYPGjsigCnWhCLhdHb0FjXum//3mgoGtHKK8qVQr7AVowle3x4wpjLLI6kltHzdBKp5NLGAQsDUbEQQdd9CHQ2o/VgIw5rKrbRLlUUXc52MD+YwcDLLxjOmhDSZYK5ZSA6poKgEVT8/xFXjGoPS1w1MfFLgAEAqDZlqsFSMiIAAAAASUVORK5CYII=" title="Show/Hide Smileys"> <select id="select-colors" class="color-text" name="color-text" onChange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor;">
   <option value="default" class="default" style="background:#333;color:#fff">Default</option>
   <option value="blue" class="blue" style="background:#049cdb;color:#fff">Blue</option>
   <option value="green" class="green" style="background:#46a546;color:#fff">Green</option>
   <option value="red" class="red" style="background:#9d261d;color:#fff">Red</option>
   <option value="yellow" class="yellow" style="background:#ffc40d;color:#fff">Yellow</option>
   <option value="orange" class="orange" style="background:#f89406;color:#fff">Orange</option>
   <option value="pink" class="pink" style="background:#c3325f;color:#fff">Pink</option>
   <option value="purple" class="purple" style="background:#7a43b6;color:#fff">Purple</option>
</select> <input type="submit" class="btn btn-info" value="SHOUT">
</span>
</div><!--/shouting-function-->

<div id="smileys" class="smileys no-radius">
<img src="assets/img/smilies/blush.png" onclick="insertSmiley('[;blush;]')" title="[;blush;]" />
<img src="assets/img/smilies/broken-heart.png" onclick="insertSmiley('[;broken-heart;]')" title="[;broken-heart;]" />
<img src="assets/img/smilies/confuse.png" onclick="insertSmiley('[;confuse;]')" title="[;confuse;]" />
<img src="assets/img/smilies/cool.png" onclick="insertSmiley('[;cool;]')" title="[;cool;]" />
<img src="assets/img/smilies/cry.png" onclick="insertSmiley('[;cry;]')" title="[;cry;]" />
<img src="assets/img/smilies/eek.png" onclick="insertSmiley('[;eek;]')" title="[;eek;]" />
<img src="assets/img/smilies/evil.png" onclick="insertSmiley('[;evil;]')" title="[;evil;]" />
<img src="assets/img/smilies/fat.png" onclick="insertSmiley('[;fat;]')" title="[;fat;]" />
<img src="assets/img/smilies/green.png" onclick="insertSmiley('[;green;]')" title="[;green;]" />
<img src="assets/img/smilies/grin.png" onclick="insertSmiley('[;grin;]')" title="[;grin;]" />
<img src="assets/img/smilies/happy.png" onclick="insertSmiley('[;happy;]')" title="[;happy;]" />
<img src="assets/img/smilies/heart.png" onclick="insertSmiley('[;heart;]')" title="[;heart;]" />
<img src="assets/img/smilies/kiss.png" onclick="insertSmiley('[;kiss;]')" title="[;kiss;]" />
<img src="assets/img/smilies/kitty.png" onclick="insertSmiley('[;kitty;]')" title="[;kitty;]" />
<img src="assets/img/smilies/lol.png" onclick="insertSmiley('[;lol;]')" title="[;lol;]" />
<img src="assets/img/smilies/mad.png" onclick="insertSmiley('[;mad;]')" title="[;mad;]" />
<img src="assets/img/smilies/money.png" onclick="insertSmiley('[;money;]')" title="[;money;]" />
<img src="assets/img/smilies/neutral.png" onclick="insertSmiley('[;neutral;]')" title="[;neutral;]" />
<img src="assets/img/smilies/razz.png" onclick="insertSmiley('[;razz;]')" title="[;razz;]" />
<img src="assets/img/smilies/roll.png" onclick="insertSmiley('[;roll;]')" title="[;roll;]" />
<img src="assets/img/smilies/sad.png" onclick="insertSmiley('[;sad;]')" title="[;sad;]" />
<img src="assets/img/smilies/sleep.png" onclick="insertSmiley('[;sleep;]')" title="[;sleep;]" />
<img src="assets/img/smilies/surprise.png" onclick="insertSmiley('[;surprise;]')" title="[;surprise;]" />
<img src="assets/img/smilies/wink.png" onclick="insertSmiley('[;wink;]')" title="[;wink;]" />
<img src="assets/img/smilies/yell.png" onclick="insertSmiley('[;yell;]')" title="[;yell;]" />
<img src="assets/img/smilies/zipper.png" onclick="insertSmiley('[;zipper;]')" title="[;zipper;]" />
<img src="assets/img/smilies/like.png" onclick="insertSmiley('[;like;]')" title="[;like;]" />
<img src="assets/img/smilies/dislike.png" onclick="insertSmiley('[;dislike;]')" title="[;dislike;]" />

<img src="assets/img/cutes/10.gif" onclick="insertSmiley('{;10;}')" title="{;10;}" />
<img src="assets/img/cutes/11.gif" onclick="insertSmiley('{;11;}')" title="{;11;}" />
<img src="assets/img/cutes/12.gif" onclick="insertSmiley('{;12;}')" title="{;12;}" />
<img src="assets/img/cutes/13.gif" onclick="insertSmiley('{;13;}')" title="{;13;}" />
<img src="assets/img/cutes/14.gif" onclick="insertSmiley('{;14;}')" title="{;14;}" />
<img src="assets/img/cutes/15.gif" onclick="insertSmiley('{;15;}')" title="{;15;}" />
<img src="assets/img/cutes/16.gif" onclick="insertSmiley('{;16;}')" title="{;16;}" />
<img src="assets/img/cutes/17.gif" onclick="insertSmiley('{;17;}')" title="{;17;}" />
<img src="assets/img/cutes/18.gif" onclick="insertSmiley('{;18;}')" title="{;18;}" />
<img src="assets/img/cutes/19.gif" onclick="insertSmiley('{;19;}')" title="{;19;}" />
<img src="assets/img/cutes/2.gif" onclick="insertSmiley('{;2;}')" title="{;2;}" />
<img src="assets/img/cutes/20.gif" onclick="insertSmiley('{;20;}')" title="{;20;}" />
<img src="assets/img/cutes/21.gif" onclick="insertSmiley('{;21;}')" title="{;21;}" />
<img src="assets/img/cutes/22.gif" onclick="insertSmiley('{;22;}')" title="{;22;}" />
<img src="assets/img/cutes/23.gif" onclick="insertSmiley('{;23;}')" title="{;23;}" />
<img src="assets/img/cutes/24.gif" onclick="insertSmiley('{;24;}')" title="{;24;}" />
<img src="assets/img/cutes/25.gif" onclick="insertSmiley('{;25;}')" title="{;25;}" />
<img src="assets/img/cutes/26.gif" onclick="insertSmiley('{;26;}')" title="{;26;}" />
<img src="assets/img/cutes/27.gif" onclick="insertSmiley('{;27;}')" title="{;27;}" />
<img src="assets/img/cutes/28.gif" onclick="insertSmiley('{;28;}')" title="{;28;}" />
<img src="assets/img/cutes/29.gif" onclick="insertSmiley('{;29;}')" title="{;29;}" />
<img src="assets/img/cutes/3.gif" onclick="insertSmiley('{;3;}')" title="{;3;}" />
<img src="assets/img/cutes/30.gif" onclick="insertSmiley('{;30;}')" title="{;30;}" />
<img src="assets/img/cutes/31.gif" onclick="insertSmiley('{;31;}')" title="{;31;}" />
<img src="assets/img/cutes/32.gif" onclick="insertSmiley('{;32;}')" title="{;32;}" />
<img src="assets/img/cutes/33.gif" onclick="insertSmiley('{;33;}')" title="{;33;}" />
<img src="assets/img/cutes/34.gif" onclick="insertSmiley('{;34;}')" title="{;34;}" />
<img src="assets/img/cutes/35.gif" onclick="insertSmiley('{;35;}')" title="{;35;}" />
<img src="assets/img/cutes/36.gif" onclick="insertSmiley('{;36;}')" title="{;36;}" />
<img src="assets/img/cutes/37.gif" onclick="insertSmiley('{;37;}')" title="{;37;}" />
<img src="assets/img/cutes/38.gif" onclick="insertSmiley('{;38;}')" title="{;38;}" />
<img src="assets/img/cutes/39.gif" onclick="insertSmiley('{;39;}')" title="{;39;}" />
<img src="assets/img/cutes/4.gif" onclick="insertSmiley('{;4;}')" title="{;4;}" />
<img src="assets/img/cutes/40.gif" onclick="insertSmiley('{;40;}')" title="{;40;}" />
<img src="assets/img/cutes/41.gif" onclick="insertSmiley('{;41;}')" title="{;41;}" />
<img src="assets/img/cutes/42.gif" onclick="insertSmiley('{;42;}')" title="{;42;}" />
<img src="assets/img/cutes/43.gif" onclick="insertSmiley('{;43;}')" title="{;43;}" />
<img src="assets/img/cutes/44.gif" onclick="insertSmiley('{;44;}')" title="{;44;}" />
<img src="assets/img/cutes/45.gif" onclick="insertSmiley('{;45;}')" title="{;45;}" />
<img src="assets/img/cutes/46.gif" onclick="insertSmiley('{;46;}')" title="{;46;}" />
<img src="assets/img/cutes/47.gif" onclick="insertSmiley('{;47;}')" title="{;47;}" />
<img src="assets/img/cutes/48.gif" onclick="insertSmiley('{;48;}')" title="{;48;}" />
<img src="assets/img/cutes/49.gif" onclick="insertSmiley('{;49;}')" title="{;49;}" />
<img src="assets/img/cutes/5.gif" onclick="insertSmiley('{;5;}')" title="{;5;}" />
<img src="assets/img/cutes/50.gif" onclick="insertSmiley('{;50;}')" title="{;50;}" />
<img src="assets/img/cutes/51.gif" onclick="insertSmiley('{;51;}')" title="{;51;}" />
<img src="assets/img/cutes/52.gif" onclick="insertSmiley('{;52;}')" title="{;52;}" />
<img src="assets/img/cutes/53.gif" onclick="insertSmiley('{;53;}')" title="{;53;}" />
<img src="assets/img/cutes/54.gif" onclick="insertSmiley('{;54;}')" title="{;54;}" />
<img src="assets/img/cutes/55.gif" onclick="insertSmiley('{;55;}')" title="{;55;}" />
<img src="assets/img/cutes/6.gif" onclick="insertSmiley('{;6;}')" title="{;6;}" />
<img src="assets/img/cutes/7.gif" onclick="insertSmiley('{;7;}')" title="{;7;}" />
<img src="assets/img/cutes/8.gif" onclick="insertSmiley('{;8;}')" title="{;8;}" />
<img src="assets/img/cutes/9.gif" onclick="insertSmiley('{;9;}')" title="{;9;}" />
</div>

</div><!--/shouting-section-->

</form>

<div id="console" class="alert alert-error" style="display:none"></div>

<script type="text/javascript">
function $(a){return document.getElementById(a)}function urlencode(a){a=(a+"").toString();return encodeURIComponent(a).replace(/!/g,"%21").replace(/'/g,"%27").replace(/\(/g,"%28").replace(/\)/g,"%29").replace(/\*/g,"%2A").replace(/%20/g,"+")}function shouts(){clearTimeout(getshout);var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("GET","shouts_gc.php?i="+Math.random(),true);a.onreadystatechange=function(){if(this.readyState==4){if(parseInt(this.responseText)>current_shouts){getshouts();current_shouts=parseInt(this.responseText)}getshout=setTimeout("shouts()",1e3)}};a.send(null)}function getshouts(){var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("GET","get_shouts_gc.php?i="+Math.random(),true);a.onreadystatechange=function(){if(this.readyState==4)$("shoutbox-reload-gc").innerHTML=this.responseText};a.send(null)}function push_shout(){shouting();return false}function shouting(){var a=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");a.open("POST","post_shout_gc.php",true);var b="user="+urlencode($("user").value)+"&"+"shout="+urlencode($("shout").value)+"&"+"color-text="+urlencode($("select-colors").value)+"&"+"antispam="+urlencode($("antispam").value);a.setRequestHeader("Content-type","application/x-www-form-urlencoded");a.setRequestHeader("Content-length",b.length);a.onreadystatechange=function(){if(this.readyState==4){if(!this.responseText)$("shout").value="";else{$("console").style.display="";$("console").innerHTML=this.responseText;setTimeout("$('console').style.display='none';$('console').innerHTML = ''",3e3)}getshouts()}};a.send(b);return true}var current_shouts=0;var getshout=setTimeout("shouts()",1e3)
</script>

<div id="shoutbox-reload-gc"><?php include('get_shouts_gc.php'); ?></div>
<div class="archived-nav"><a href="more_gc.php?page=2" class="label label-inverse arc-btn-tip" title="Show previous shouted messages">View Archived Messages <i class="icon-chevron-right icon-white"></i></a></div>
</div>

<div class="well special-bg"><div id="latest-updates"><?php include('latest_updates.php'); ?></div></div>

<div class="well special-bg"><div id="latest-requests"><?php include('latest_requests.php'); ?></div></div>

        </div><!--/span-->
        <div class="span4">
          <div class="well special-bg">
          <div id="sharerlink-reload"><?php include('sharerlink.php'); ?></div>
          </div><!--/well-->
        </div><!--/span-->
      </div><!--/row-->

<?php include('copyright.php'); ?>

    </div><!--/.fluid-container-->
    
<div class="modal" id="onionClub" style="display:none;">
  <div class="modal-header">
    <button class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
    <h3>Onion Club</h3>
  </div>
  <div class="modal-body onionClub">
<img src="assets/img/onion/aaa.gif" onclick="insertSmiley('{:aaa:}')" title="{:aaa:}" />
<img src="assets/img/onion/aaaa.gif" onclick="insertSmiley('{:aaaa:}')" title="{:aaaa:}" />
<img src="assets/img/onion/advise.gif" onclick="insertSmiley('{:advise:}')" title="{:advise:}" />
<img src="assets/img/onion/agr.gif" onclick="insertSmiley('{:agr:}')" title="{:agr:}" />
<img src="assets/img/onion/ah.gif" onclick="insertSmiley('{:ah:}')" title="{:ah:}" />
<img src="assets/img/onion/aiia.gif" onclick="insertSmiley('{:aiia:}')" title="{:aiia:}" />
<img src="assets/img/onion/aishh.gif" onclick="insertSmiley('{:aishh:}')" title="{:aishh:}" />
<img src="assets/img/onion/angry1.gif" onclick="insertSmiley('{:angry1:}')" title="{:angry1:}" />
<img src="assets/img/onion/angry2.gif" onclick="insertSmiley('{:angry2:}')" title="{:angry2:}" />
<img src="assets/img/onion/bah.gif" onclick="insertSmiley('{:bah:}')" title="{:bah:}" />
<img src="assets/img/onion/ball.gif" onclick="insertSmiley('{:ball:}')" title="{:ball:}" />
<img src="assets/img/onion/bath.gif" onclick="insertSmiley('{:bath:}')" title="{:bath:}" />
<img src="assets/img/onion/bathing.gif" onclick="insertSmiley('{:bathing:}')" title="{:bathing:}" />
<img src="assets/img/onion/bbb.gif" onclick="insertSmiley('{:bbb:}')" title="{:bbb:}" />
<img src="assets/img/onion/bye.gif" onclick="insertSmiley('{:bye:}')" title="{:bye:}" />
<img src="assets/img/onion/cheerleader.gif" onclick="insertSmiley('{:cheerleader:}')" title="{:cheerleader:}" />
<img src="assets/img/onion/coffee.gif" onclick="insertSmiley('{:coffee:}')" title="{:coffee:}" />
<img src="assets/img/onion/cool.gif" onclick="insertSmiley('{:cool:}')" title="{:cool:}" />
<img src="assets/img/onion/cry1.gif" onclick="insertSmiley('{:cry1:}')" title="{:cry1:}" />
<img src="assets/img/onion/cry2.gif" onclick="insertSmiley('{:cry2:}')" title="{:cry2:}" />
<img src="assets/img/onion/cry3.gif" onclick="insertSmiley('{:cry3:}')" title="{:cry3:}" />
<img src="assets/img/onion/depressed.gif" onclick="insertSmiley('{:depressed:}')" title="{:depressed:}" />
<img src="assets/img/onion/dunno.gif" onclick="insertSmiley('{:dunno:}')" title="{:dunno:}" />
<img src="assets/img/onion/erghh.gif" onclick="insertSmiley('{:erghh:}')" title="{:erghh:}" />
<img src="assets/img/onion/erm.gif" onclick="insertSmiley('{:erm:}')" title="{:erm:}" />
<img src="assets/img/onion/frozen.gif" onclick="insertSmiley('{:frozen:}')" title="{:frozen:}" />
<img src="assets/img/onion/gameaddictplz.gif" onclick="insertSmiley('{:gameaddictplz:}')" title="{:gameaddictplz:}" />
<img src="assets/img/onion/gg.gif" onclick="insertSmiley('{:gg:}')" title="{:gg:}" />
<img src="assets/img/onion/good.gif" onclick="insertSmiley('{:good:}')" title="{:good:}" />
<img src="assets/img/onion/graduatingplz.gif" onclick="insertSmiley('{:graduatingplz:}')" title="{:graduatingplz:}" />
<img src="assets/img/onion/greedy.gif" onclick="insertSmiley('{:greedy:}')" title="{:greedy:}" />
<img src="assets/img/onion/grgrgr.gif" onclick="insertSmiley('{:grgrgr:}')" title="{:grgrgr:}" />
<img src="assets/img/onion/grrr.gif" onclick="insertSmiley('{:grrr:}')" title="{:grrr:}" />
<img src="assets/img/onion/haha.gif" onclick="insertSmiley('{:haha:}')" title="{:haha:}" />
<img src="assets/img/onion/happy.gif" onclick="insertSmiley('{:happy:}')" title="{:happy:}" />
<img src="assets/img/onion/happyrun.gif" onclick="insertSmiley('{:happyrun:}')" title="{:happyrun:}" />
<img src="assets/img/onion/heavenlyplz.gif" onclick="insertSmiley('{:heavenlyplz:}')" title="{:heavenlyplz:}" />
<img src="assets/img/onion/hehe.gif" onclick="insertSmiley('{:hehe:}')" title="{:hehe:}" />
<img src="assets/img/onion/hi.gif" onclick="insertSmiley('{:hi:}')" title="{:hi:}" />
<img src="assets/img/onion/hiks.gif" onclick="insertSmiley('{:hiks:}')" title="{:hiks:}" />
<img src="assets/img/onion/hiphaa.gif" onclick="insertSmiley('{:hiphaa:}')" title="{:hiphaa:}" />
<img src="assets/img/onion/hmm.gif" onclick="insertSmiley('{:hmm:}')" title="{:hmm:}" />
<img src="assets/img/onion/hmmhmm.gif" onclick="insertSmiley('{:hmmhmm:}')" title="{:hmmhmm:}" />
<img src="assets/img/onion/hopeless.gif" onclick="insertSmiley('{:hopeless:}')" title="{:hopeless:}" />
<img src="assets/img/onion/hotness.gif" onclick="insertSmiley('{:hotness:}')" title="{:hotness:}" />
<img src="assets/img/onion/huh.gif" onclick="insertSmiley('{:huh:}')" title="{:huh:}" />
<img src="assets/img/onion/huhu.gif" onclick="insertSmiley('{:huhu:}')" title="{:huhu:}" />
<img src="assets/img/onion/hypnosis.gif" onclick="insertSmiley('{:hypnosis:}')" title="{:hypnosis:}" />
<img src="assets/img/onion/idontcare.gif" onclick="insertSmiley('{:idontcare:}')" title="{:idontcare:}" />
<img src="assets/img/onion/imdead.gif" onclick="insertSmiley('{:imdead:}')" title="{:imdead:}" />
<img src="assets/img/onion/injuredplz.gif" onclick="insertSmiley('{:injuredplz:}')" title="{:injuredplz:}" />
<img src="assets/img/onion/kawaii.gif" onclick="insertSmiley('{:kawaii:}')" title="{:kawaii:}" />
<img src="assets/img/onion/kemon.gif" onclick="insertSmiley('{:kemon:}')" title="{:kemon:}" />
<img src="assets/img/onion/khekhe.gif" onclick="insertSmiley('{:khekhe:}')" title="{:khekhe:}" />
<img src="assets/img/onion/knife.gif" onclick="insertSmiley('{:knife:}')" title="{:knife:}" />
<img src="assets/img/onion/kyleoniplz.gif" onclick="insertSmiley('{:kyleoniplz:}')" title="{:kyleoniplz:}" />
<img src="assets/img/onion/lazyonion.gif" onclick="insertSmiley('{:lazyonion:}')" title="{:lazyonion:}" />
<img src="assets/img/onion/lol.gif" onclick="insertSmiley('{:lol:}')" title="{:lol:}" />
<img src="assets/img/onion/loncat2.gif" onclick="insertSmiley('{:loncat2:}')" title="{:loncat2:}" />
<img src="assets/img/onion/love1.gif" onclick="insertSmiley('{:love1:}')" title="{:love1:}" />
<img src="assets/img/onion/love2.gif" onclick="insertSmiley('{:love2:}')" title="{:love2:}" />
<img src="assets/img/onion/macho.gif" onclick="insertSmiley('{:macho:}')" title="{:macho:}" />
<img src="assets/img/onion/miseryplz.gif" onclick="insertSmiley('{:miseryplz:}')" title="{:miseryplz:}" />
<img src="assets/img/onion/nocare.gif" onclick="insertSmiley('{:nocare:}')" title="{:nocare:}" />
<img src="assets/img/onion/nolisten.gif" onclick="insertSmiley('{:nolisten:}')" title="{:nolisten:}" />
<img src="assets/img/onion/nono.gif" onclick="insertSmiley('{:nono:}')" title="{:nono:}" />
<img src="assets/img/onion/nonono.gif" onclick="insertSmiley('{:nonono:}')" title="{:nonono:}" />
<img src="assets/img/onion/omg.gif" onclick="insertSmiley('{:omg:}')" title="{:omg:}" />
<img src="assets/img/onion/onigaspplz.gif" onclick="insertSmiley('{:onigaspplz:}')" title="{:onigaspplz:}" />
<img src="assets/img/onion/onion_club.gif" onclick="insertSmiley('{:onion_club:}')" title="{:onion_club:}" />
<img src="assets/img/onion/onionpanicplz.gif" onclick="insertSmiley('{:onionpanicplz:}')" title="{:onionpanicplz:}" />
<img src="assets/img/onion/onionpinnochioplz.gif" onclick="insertSmiley('{:onionpinnochioplz:}')" title="{:onionpinnochioplz:}" />
<img src="assets/img/onion/onionraceplz.gif" onclick="insertSmiley('{:onionraceplz:}')" title="{:onionraceplz:}" />
<img src="assets/img/onion/onionsoccer1plz.gif" onclick="insertSmiley('{:onionsoccer1plz:}')" title="{:onionsoccer1plz:}" />
<img src="assets/img/onion/oniontantrumplz.gif" onclick="insertSmiley('{:oniontantrumplz:}')" title="{:oniontantrumplz:}" />
<img src="assets/img/onion/onionwoeplz.gif" onclick="insertSmiley('{:onionwoeplz:}')" title="{:onionwoeplz:}" />
<img src="assets/img/onion/peaceyo.gif" onclick="insertSmiley('{:peaceyo:}')" title="{:peaceyo:}" />
<img src="assets/img/onion/penalty.gif" onclick="insertSmiley('{:penalty:}')" title="{:penalty:}" />
<img src="assets/img/onion/pervert.gif" onclick="insertSmiley('{:pervert:}')" title="{:pervert:}" />
<img src="assets/img/onion/phuw.gif" onclick="insertSmiley('{:phuw:}')" title="{:phuw:}" />
<img src="assets/img/onion/pityme.gif" onclick="insertSmiley('{:pityme:}')" title="{:pityme:}" />
<img src="assets/img/onion/pleased.gif" onclick="insertSmiley('{:pleased:}')" title="{:pleased:}" />
<img src="assets/img/onion/punch.gif" onclick="insertSmiley('{:punch:}')" title="{:punch:}" />
<img src="assets/img/onion/ranranruuplz.gif" onclick="insertSmiley('{:ranranruuplz:}')" title="{:ranranruuplz:}" />
<img src="assets/img/onion/roar.gif" onclick="insertSmiley('{:roar:}')" title="{:roar:}" />
<img src="assets/img/onion/runcryplz.gif" onclick="insertSmiley('{:runcryplz:}')" title="{:runcryplz:}" />
<img src="assets/img/onion/sad.gif" onclick="insertSmiley('{:sad:}')" title="{:sad:}" />
<img src="assets/img/onion/scaredplz.gif" onclick="insertSmiley('{:scaredplz:}')" title="{:scaredplz:}" />
<img src="assets/img/onion/shy.gif" onclick="insertSmiley('{:shy:}')" title="{:shy:}" />
<img src="assets/img/onion/slap.gif" onclick="insertSmiley('{:slap:}')" title="{:slap:}" />
<img src="assets/img/onion/sleep.gif" onclick="insertSmiley('{:sleep:}')" title="{:sleep:}" />
<img src="assets/img/onion/smoke.gif" onclick="insertSmiley('{:smoke:}')" title="{:smoke:}" />
<img src="assets/img/onion/stfu.gif" onclick="insertSmiley('{:stfu:}')" title="{:stfu:}" />
<img src="assets/img/onion/stressplz.gif" onclick="insertSmiley('{:stressplz:}')" title="{:stressplz:}" />
<img src="assets/img/onion/studytimeplz.gif" onclick="insertSmiley('{:studytimeplz:}')" title="{:studytimeplz:}" />
<img src="assets/img/onion/tired1.gif" onclick="insertSmiley('{:tired1:}')" title="{:tired1:}" />
<img src="assets/img/onion/tired2.gif" onclick="insertSmiley('{:tired2:}')" title="{:tired2:}" />
<img src="assets/img/onion/tuktuk.gif" onclick="insertSmiley('{:tuktuk:}')" title="{:tuktuk:}" />
<img src="assets/img/onion/uhuh.gif" onclick="insertSmiley('{:uhuh:}')" title="{:uhuh:}" />
<img src="assets/img/onion/vomitplz.gif" onclick="insertSmiley('{:vomitplz:}')" title="{:vomitplz:}" />
<img src="assets/img/onion/wall.gif" onclick="insertSmiley('{:wall:}')" title="{:wall:}" />
<img src="assets/img/onion/wat1.gif" onclick="insertSmiley('{:wat1:}')" title="{:wat1:}" />
<img src="assets/img/onion/wat2.gif" onclick="insertSmiley('{:wat2:}')" title="{:wat2:}" />
<img src="assets/img/onion/wet.gif" onclick="insertSmiley('{:wet:}')" title="{:wet:}" />
<img src="assets/img/onion/whoop.gif" onclick="insertSmiley('{:whoop:}')" title="{:whoop:}" />
<img src="assets/img/onion/wind.gif" onclick="insertSmiley('{:wind:}')" title="{:wind:}" />
<img src="assets/img/onion/yawmm.gif" onclick="insertSmiley('{:yawmm:}')" title="{:yawmm:}" />
<img src="assets/img/onion/yawn1.gif" onclick="insertSmiley('{:yawn1:}')" title="{:yawn1:}" />
<img src="assets/img/onion/yawn2.gif" onclick="insertSmiley('{:yawn2:}')" title="{:yawn2:}" />
<img src="assets/img/onion/yellowcard.gif" onclick="insertSmiley('{:yellowcard:}')" title="{:yellowcard:}" />  
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-inverse" data-dismiss="modal">Close</a>
  </div>
</div>

<div class="modal" id="tuzkiClub" style="display:none;">
  <div class="modal-header">
    <button class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
    <h3>Tuzki</h3>
  </div>
  <div class="modal-body tuzkiClub">
<img src="assets/img/tuzki/icon48_0.gif" onclick="insertSmiley('[:icon48_0:]')" title="[:icon48_0:]" />
<img src="assets/img/tuzki/icon71_0_2.gif" onclick="insertSmiley('[:icon71_0_2:]')" title="[:icon71_0_2:]" />
<img src="assets/img/tuzki/icon73_0_0.gif" onclick="insertSmiley('[:icon73_0_0:]')" title="[:icon73_0_0:]" />
<img src="assets/img/tuzki/icon74_0_0.gif" onclick="insertSmiley('[:icon74_0_0:]')" title="[:icon74_0_0:]" />
<img src="assets/img/tuzki/icon75_0_0.gif" onclick="insertSmiley('[:icon75_0_0:]')" title="[:icon75_0_0:]" />
<img src="assets/img/tuzki/icon76_0_1.gif" onclick="insertSmiley('[:icon76_0_1:]')" title="[:icon76_0_1:]" />
<img src="assets/img/tuzki/icon77_0.gif" onclick="insertSmiley('[:icon77_0:]')" title="[:icon77_0:]" />
<img src="assets/img/tuzki/icon78_0.gif" onclick="insertSmiley('[:icon78_0:]')" title="[:icon78_0:]" />
<img src="assets/img/tuzki/icon79_0.gif" onclick="insertSmiley('[:icon79_0:]')" title="[:icon79_0:]" />
<img src="assets/img/tuzki/icon_121_4.gif" onclick="insertSmiley('[:icon_121_4:]')" title="[:icon_121_4:]" />
<img src="assets/img/tuzki/icon_122_1.gif" onclick="insertSmiley('[:icon_122_1:]')" title="[:icon_122_1:]" />
<img src="assets/img/tuzki/icon_124_1.gif" onclick="insertSmiley('[:icon_124_1:]')" title="[:icon_124_1:]" />
<img src="assets/img/tuzki/tuzki-emoticon-001.gif" onclick="insertSmiley('[:tuzki-emoticon-001:]')" title="[:tuzki-emoticon-001:]" />
<img src="assets/img/tuzki/tuzki-emoticon-002.gif" onclick="insertSmiley('[:tuzki-emoticon-002:]')" title="[:tuzki-emoticon-002:]" />
<img src="assets/img/tuzki/tuzki-emoticon-003.gif" onclick="insertSmiley('[:tuzki-emoticon-003:]')" title="[:tuzki-emoticon-003:]" />
<img src="assets/img/tuzki/tuzki-emoticon-005.gif" onclick="insertSmiley('[:tuzki-emoticon-005:]')" title="[:tuzki-emoticon-005:]" />
<img src="assets/img/tuzki/tuzki-emoticon-006.gif" onclick="insertSmiley('[:tuzki-emoticon-006:]')" title="[:tuzki-emoticon-006:]" />
<img src="assets/img/tuzki/tuzki-emoticon-007.gif" onclick="insertSmiley('[:tuzki-emoticon-007:]')" title="[:tuzki-emoticon-007:]" />
<img src="assets/img/tuzki/tuzki-emoticon-008.gif" onclick="insertSmiley('[:tuzki-emoticon-008:]')" title="[:tuzki-emoticon-008:]" />
<img src="assets/img/tuzki/tuzki-emoticon-009.gif" onclick="insertSmiley('[:tuzki-emoticon-009:]')" title="[:tuzki-emoticon-009:]" />
<img src="assets/img/tuzki/tuzki-emoticon-010.gif" onclick="insertSmiley('[:tuzki-emoticon-010:]')" title="[:tuzki-emoticon-010:]" />
<img src="assets/img/tuzki/tuzki-emoticon-011.gif" onclick="insertSmiley('[:tuzki-emoticon-011:]')" title="[:tuzki-emoticon-011:]" />
<img src="assets/img/tuzki/tuzki-emoticon-012.gif" onclick="insertSmiley('[:tuzki-emoticon-012:]')" title="[:tuzki-emoticon-012:]" />
<img src="assets/img/tuzki/tuzki-emoticon-013.gif" onclick="insertSmiley('[:tuzki-emoticon-013:]')" title="[:tuzki-emoticon-013:]" />
<img src="assets/img/tuzki/tuzki-emoticon-014.gif" onclick="insertSmiley('[:tuzki-emoticon-014:]')" title="[:tuzki-emoticon-014:]" />
<img src="assets/img/tuzki/tuzki-emoticon-015.gif" onclick="insertSmiley('[:tuzki-emoticon-015:]')" title="[:tuzki-emoticon-015:]" />
<img src="assets/img/tuzki/tuzki-emoticon-016.gif" onclick="insertSmiley('[:tuzki-emoticon-016:]')" title="[:tuzki-emoticon-016:]" />
<img src="assets/img/tuzki/tuzki-emoticon-017.gif" onclick="insertSmiley('[:tuzki-emoticon-017:]')" title="[:tuzki-emoticon-017:]" />
<img src="assets/img/tuzki/tuzki-emoticon-018.gif" onclick="insertSmiley('[:tuzki-emoticon-018:]')" title="[:tuzki-emoticon-018:]" />
<img src="assets/img/tuzki/tuzki-emoticon-019.gif" onclick="insertSmiley('[:tuzki-emoticon-019:]')" title="[:tuzki-emoticon-019:]" />
<img src="assets/img/tuzki/tuzki-emoticon-020.gif" onclick="insertSmiley('[:tuzki-emoticon-020:]')" title="[:tuzki-emoticon-020:]" />
<img src="assets/img/tuzki/tuzki-emoticon-021.gif" onclick="insertSmiley('[:tuzki-emoticon-021:]')" title="[:tuzki-emoticon-021:]" />
<img src="assets/img/tuzki/tuzki-emoticon-022.gif" onclick="insertSmiley('[:tuzki-emoticon-022:]')" title="[:tuzki-emoticon-022:]" />
<img src="assets/img/tuzki/tuzki-emoticon-023.gif" onclick="insertSmiley('[:tuzki-emoticon-023:]')" title="[:tuzki-emoticon-023:]" />
<img src="assets/img/tuzki/tuzki-emoticon-024.gif" onclick="insertSmiley('[:tuzki-emoticon-024:]')" title="[:tuzki-emoticon-024:]" />
<img src="assets/img/tuzki/tuzki-emoticon-025.gif" onclick="insertSmiley('[:tuzki-emoticon-025:]')" title="[:tuzki-emoticon-025:]" />
<img src="assets/img/tuzki/tuzki-emoticon-026.gif" onclick="insertSmiley('[:tuzki-emoticon-026:]')" title="[:tuzki-emoticon-026:]" />
<img src="assets/img/tuzki/tuzki-emoticon-027.gif" onclick="insertSmiley('[:tuzki-emoticon-027:]')" title="[:tuzki-emoticon-027:]" />
<img src="assets/img/tuzki/tuzki-emoticon-028.gif" onclick="insertSmiley('[:tuzki-emoticon-028:]')" title="[:tuzki-emoticon-028:]" />
<img src="assets/img/tuzki/tuzki-emoticon-029.gif" onclick="insertSmiley('[:tuzki-emoticon-029:]')" title="[:tuzki-emoticon-029:]" />
<img src="assets/img/tuzki/tuzki-emoticon-030.gif" onclick="insertSmiley('[:tuzki-emoticon-030:]')" title="[:tuzki-emoticon-030:]" />
<img src="assets/img/tuzki/tuzki-emoticon-031.gif" onclick="insertSmiley('[:tuzki-emoticon-031:]')" title="[:tuzki-emoticon-031:]" />
<img src="assets/img/tuzki/tuzki-emoticon-032.gif" onclick="insertSmiley('[:tuzki-emoticon-032:]')" title="[:tuzki-emoticon-032:]" />
<img src="assets/img/tuzki/tuzki-emoticon-033.gif" onclick="insertSmiley('[:tuzki-emoticon-033:]')" title="[:tuzki-emoticon-033:]" />
<img src="assets/img/tuzki/tuzki-emoticon-034.gif" onclick="insertSmiley('[:tuzki-emoticon-034:]')" title="[:tuzki-emoticon-034:]" />
<img src="assets/img/tuzki/tuzki-emoticon-035.gif" onclick="insertSmiley('[:tuzki-emoticon-035:]')" title="[:tuzki-emoticon-035:]" />
<img src="assets/img/tuzki/tuzki-emoticon-036.gif" onclick="insertSmiley('[:tuzki-emoticon-036:]')" title="[:tuzki-emoticon-036:]" />
<img src="assets/img/tuzki/tuzki-emoticon-037.gif" onclick="insertSmiley('[:tuzki-emoticon-037:]')" title="[:tuzki-emoticon-037:]" />
<img src="assets/img/tuzki/tuzki-emoticon-038.gif" onclick="insertSmiley('[:tuzki-emoticon-038:]')" title="[:tuzki-emoticon-038:]" />
<img src="assets/img/tuzki/tuzki-emoticon-039.gif" onclick="insertSmiley('[:tuzki-emoticon-039:]')" title="[:tuzki-emoticon-039:]" />
<img src="assets/img/tuzki/tuzki-emoticon-040.gif" onclick="insertSmiley('[:tuzki-emoticon-040:]')" title="[:tuzki-emoticon-040:]" />
<img src="assets/img/tuzki/tuzki-emoticon-041.gif" onclick="insertSmiley('[:tuzki-emoticon-041:]')" title="[:tuzki-emoticon-041:]" />
<img src="assets/img/tuzki/tuzki-emoticon-042.gif" onclick="insertSmiley('[:tuzki-emoticon-042:]')" title="[:tuzki-emoticon-042:]" />
<img src="assets/img/tuzki/tuzki-emoticon-043.gif" onclick="insertSmiley('[:tuzki-emoticon-043:]')" title="[:tuzki-emoticon-043:]" />
<img src="assets/img/tuzki/tuzki-emoticon-044.gif" onclick="insertSmiley('[:tuzki-emoticon-044:]')" title="[:tuzki-emoticon-044:]" />
<img src="assets/img/tuzki/tuzki-emoticon-045.gif" onclick="insertSmiley('[:tuzki-emoticon-045:]')" title="[:tuzki-emoticon-045:]" />
<img src="assets/img/tuzki/tuzki-emoticon-046.gif" onclick="insertSmiley('[:tuzki-emoticon-046:]')" title="[:tuzki-emoticon-046:]" />
<img src="assets/img/tuzki/tuzki-emoticon-047.gif" onclick="insertSmiley('[:tuzki-emoticon-047:]')" title="[:tuzki-emoticon-047:]" />
<img src="assets/img/tuzki/tuzki-emoticon-048.gif" onclick="insertSmiley('[:tuzki-emoticon-048:]')" title="[:tuzki-emoticon-048:]" />
<img src="assets/img/tuzki/tuzki-emoticon-049.gif" onclick="insertSmiley('[:tuzki-emoticon-049:]')" title="[:tuzki-emoticon-049:]" />
<img src="assets/img/tuzki/tuzki-emoticon-050.gif" onclick="insertSmiley('[:tuzki-emoticon-050:]')" title="[:tuzki-emoticon-050:]" />
<img src="assets/img/tuzki/tuzki-emoticon-051.gif" onclick="insertSmiley('[:tuzki-emoticon-051:]')" title="[:tuzki-emoticon-051:]" />
<img src="assets/img/tuzki/tuzki-emoticon-052.gif" onclick="insertSmiley('[:tuzki-emoticon-052:]')" title="[:tuzki-emoticon-052:]" />
<img src="assets/img/tuzki/tuzki-emoticon-053.gif" onclick="insertSmiley('[:tuzki-emoticon-053:]')" title="[:tuzki-emoticon-053:]" />
<img src="assets/img/tuzki/tuzki-emoticon-054.gif" onclick="insertSmiley('[:tuzki-emoticon-054:]')" title="[:tuzki-emoticon-054:]" />
<img src="assets/img/tuzki/tuzki-emoticon-055.gif" onclick="insertSmiley('[:tuzki-emoticon-055:]')" title="[:tuzki-emoticon-055:]" />
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-inverse" data-dismiss="modal">Close</a>
  </div>
</div>

<div class="modal" id="disclaimer" style="display:none;">
  <div class="modal-header">
    <button class="close" data-dismiss="modal"><i class="icon-remove"></i></button>
    <h3>Ishare InfoCenter</h3>
  </div>
  <div class="modal-body disclaimer-box">
  
<?php include("infocenter.php"); ?>

  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-inverse" data-dismiss="modal">Close</a>
  </div>
</div>
    
<?php include('footer.php'); ?>