<?php
ob_start();
session_start();

if (!isset($_SESSION['name'])) {
   header("Location: login");
   exit();
}
ob_end_flush();
