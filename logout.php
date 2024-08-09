<?php
session_start();

// Clear session data
$_SESSION = array();

// Destroy the session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destroy the session
session_destroy();

// Redirect to the index page
header("Location: index.html");
exit();
?>
