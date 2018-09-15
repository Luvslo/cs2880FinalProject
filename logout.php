<?php

if(!session_start()) {
    header("Location: error.php");
    exit;
}

// Unset all session variables
$_SESSION = array();

// remove cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 1,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();


// Redirect to login
header("Location: login.php");
exit;
?>