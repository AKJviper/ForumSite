<?php
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
session_start();

session_unset();
session_destroy();

header("location: /Forum/index.php");
exit;
?>