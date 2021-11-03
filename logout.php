<?php

session_start();//start new seesion
session_destroy();//destroy the session
header("location: login.php");//reddirect to login page
exit;
?>