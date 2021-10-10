<?php
ob_start();
session_start();

if (!isset($_SESSION['name'])) {
   // header("Location: login");
   echo '<script>window.location.href = "login";</script>';
   exit();
}
ob_end_flush();
