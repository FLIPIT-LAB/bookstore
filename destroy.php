<?php
session_start();
unset($_SESSION['user']);
session_destroy();
header("location: index.php?Message=" . "You have been logged out!!");
?>

