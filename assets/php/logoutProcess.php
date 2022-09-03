<?php
session_start();

session_destroy();

session_start();

if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']); 
    unset($_COOKIE['password']);
    setcookie("username", "", time()-3600);
    setcookie("password", "", time()-3600);
}

header("location: ../../index.php");
?>