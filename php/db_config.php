<?php
// Database configuration for InfinityFree
define('DB_SERVER', 'sql308.infinityfree.com');
define('DB_USERNAME', 'if0_39769042');
define('DB_PASSWORD', 'oKmeuT550pRuW');
define('DB_NAME', 'if0_39769042_contact');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>