<?php 
define('DB_HOST', 'elearning.sourcecodesonline.com'); 
define('DB_NAME', 'bookdtore'); 
define('DB_USER','youngson'); 
define('DB_PASSWORD','0243185804'); 

// $DATABASE_HOST = 'localhost';
// $DATABASE_USER = 'id13820805_flipit';
// $DATABASE_PASS = 'Pa$$w0rdyoungson';
// $DATABASE_NAME = 'id13820805_bookstore';

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(); 
$db=mysqli_select_db($con,DB_NAME) or die(); 
?>