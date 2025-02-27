<?php
// Unset all session values 
$_SESSION = array();

// get session parameters 
$params = session_get_cookie_params();

// Delete the actual cookie. 
setcookie(
    session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
);

// Destroy session 
session_destroy();
echo '<meta http-equiv="refresh" content="0;url=' . safer($site["site_url"]) . 'abma/auth/login" />';
