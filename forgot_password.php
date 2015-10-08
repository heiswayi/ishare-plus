<?php
session_start();
include('header.php');
function renderForm($error)
{
?>

<div class="container" style="margin-top:70px;">

<div class="row">

    <div class="span8" style="margin:0 auto 0 auto;float:none;">
        <div class="well no-radius special-bg">
<?php
if ($error == '' && isset($_SESSION['profileUpdate']) == 'Success') {
echo '<div class="alert alert-block alert-success" id="success">';
  echo '<a class="close" data-dismiss="alert" href="#"><i class="icon-remove"></i></a>';
  echo '<h4 class="alert-heading">Success!</h4>';
  echo 'Your reset password was successfully sent to your email. <a href="login.php" style="font-weight:bold;">You may now login!</a>';
echo '</div>';
echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'success\').style.display=\'none\';$(\'success\').innerHTML = \'\'",5e3)</script>';
unset($_SESSION['profileUpdate']);
}
else if ($error != '') {
        echo '<div id="console" class="alert alert-error">' . $error . '</div>';
        echo '<script type="text/javascript">function $(a){return document.getElementById(a)} var hideerr = setTimeout("$(\'console\').style.display=\'none\';$(\'console\').innerHTML = \'\'",5e3)</script>';
    }
?>

<div class="register-box table-borderz" style="padding:20px;">
 <form class="form-horizontal" action="" method="post">
 <legend>Request for Reset Password</legend>
  <fieldset>
  <div style="margin:0 auto 20px auto;">
 Enter your valid email address that you used in registering your account profile. The reset password will be sent to your email. After you got your reset password, login with that reset password and go to Edit Profile and change your password for anew. Thank you!
 </div>
    <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" class="input-xlarge" placeholder="Email" name="email" value="" maxlength="100"></div>
        <input type="submit" class="btn btn-primary" name="send" value="Submit">
        <a class="btn" href="login.php">Cancel</a>
  </fieldset>
</form>
</div>

</div><!--/well-->
</div><!--/span-->

</div><!--/row-->

<?php include('copyright.php'); ?>

</div><!--/.fluid-container-->

<?php

include('footer.php');

}

include('includes.php');
include('settings.php');

function generatePassword ($length = 8)  {
            // start with a blank password
            $password = "";
            // define possible characters - any character in this string can be
            // picked for use in the password, so if you want to put vowels back in
            // or add special characters such as exclamation marks, this is where
            // you should do it
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            // we refer to the length of $possible a few times, so let's grab it now
            $maxlength = strlen($possible);
            // check for length overflow and truncate if necessary
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            // set up a counter for how many characters are in the password so far
            $i = 0; 
            // add random characters to $password until $length is reached
            while ($i < $length) { 
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, $maxlength-1), 1);
                // have we already used this character in $password?
                if (!strstr($password, $char)) { 
                      // no, so it's OK to add it onto the end of whatever we've already got...
                      $password .= $char;
                      // ... and increase the counter by one
                      $i++;
                }
            }
            // done!
            return $password;
}

if (isset($_POST['send'])) {
    $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
    
    $callUserData = mysql_query("SELECT * FROM i_users WHERE email='$email'") or die(mysql_error());
    $initUserData = mysql_fetch_array($callUserData);
    $check_email = $initUserData['email'];
    
    if ($email == '') {
        $error = '<strong>ERROR:</strong> Please fill the blank!';
        renderForm($error);
    } else if ($email !== $check_email) {
        $error = '<strong>ERROR:</strong> Email address you entered is not exist!';
        renderForm($error);
    } else {
        
        $resetPassword = generatePassword();
        $md5resetpassword = md5($resetPassword);
        mysql_query("UPDATE i_users SET passwd='$md5resetpassword' WHERE email='$email'") or die(mysql_error());
        
        $to = $email;
        $subject = "Password Reset @ .ISHARE";
        $message = "Your reset password @ .ISHARE is: [ ".$resetPassword." ]";
        $from = "ISHARE@email.eng.usm.my";
        $headers = "From:" . $from;
        
        mail($to,$subject,$message,$headers);
        
        $_SESSION['profileUpdate'] = 'Success'; 
        header('Location: forgot_password.php');
    }
    
} else { renderForm(''); }

?>