<?php
function ssl_encrypt($pass, $data) {

    $salt = substr(md5(mt_rand(), true), 8);

    $key = md5($pass . $salt, true);
    $iv = md5($key . $pass . $salt, true);

    $ct = mcrypt_encrypt (MCRYPT_RIJNDAEL_128, $key, $data, 
                          MCRYPT_MODE_CBC, $iv);

    return base64_encode('Salted__' . $salt . $ct);
}

function ssl_decrypt($pass, $data) {

    $data = base64_decode($data);
    $salt = substr($data, 8, 8);
    $ct = substr($data, 16);

    $key = md5($pass . $salt, true);
    $iv = md5($key . $pass . $salt, true);

    $pt = mcrypt_decrypt (MCRYPT_RIJNDAEL_128, $key, $ct, 
                          MCRYPT_MODE_CBC, $iv);

    return $pt;
}
?>