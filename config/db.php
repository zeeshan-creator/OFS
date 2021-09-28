<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'engroup');
define('DB_PASSWORD', 'Bu#m(DqY4uSQ');


/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($conn === false) {
   die("ERROR: Could not connect. " . mysqli_connect_error());
}
