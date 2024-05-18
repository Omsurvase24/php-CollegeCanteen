<?php
ob_start();
session_start();

$_SESSION = [];

session_destroy();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

setcookie('cookie_name', '', time() - 3600, '/');

header('Location: index.php');
exit;

ob_end_flush();
