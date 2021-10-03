<?php
session_start();
unset($_SESSION["name"]);
// unset($_SESSION['user_last_name']);
// unset($_SESSION['user_email_address']);
// unset($_SESSION['user_gender']);
// unset($_SESSION['user_image']);
// unset($_SESSION["success"]);
header("Location:login");
