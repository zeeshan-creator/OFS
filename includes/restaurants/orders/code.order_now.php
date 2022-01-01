<?php

ob_start();
session_start();
require('config/db.php');

if (!isset($_GET['id']) || $_GET['id'] == '' || $_GET['id'] == null) {
   echo '<script>window.location.href = "index";</script>';
}
