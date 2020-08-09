<?php
// ##########################################################
// # this code is unsafe, don't allow external access to it #
// ##########################################################
$ipAddress = $_SERVER['REMOTE_ADDR'];
if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
    echo "HTTP_X_FORWARDED_FOR";
    $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
}

if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
    exit();
} else {
    if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) {
        exit();
    } else {
        putenv('LC_ALL=C.UTF-8');
        putenv('LANG=C.UTF-8');
        if (isset($_POST["cmd"])) {            
            if (strpos($_POST["cmd"], ';') !== false || strpos($_POST["cmd"], '|') !== false || strpos($_POST["cmd"], '&') !== false) {
                exit();
            } else {
                $output = shell_exec('/usr/local/bin/miiocli fanp5 --ip INSERT_DEVICE_IP_HERE --token INSERT_TOKEN_HERE ' . $_POST['cmd']);
                echo $output;
            }
            exit();
        }
    }
}
?>