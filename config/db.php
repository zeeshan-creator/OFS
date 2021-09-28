<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'engroup_root');
define('DB_PASSWORD', 'aeZ-hzEtsceX');
define('DB_NAME', 'engroup_OFS');


/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
   die("ERROR: Could not connect. " . mysqli_connect_error());
}
