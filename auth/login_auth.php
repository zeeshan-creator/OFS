<?php
ob_start();
if (!isset($_SESSION['name'])) {
   header("Location: login");
   exit();
}
ob_end_flush();
