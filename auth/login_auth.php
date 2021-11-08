<?php
ob_start();
session_start();
require('./config/db.php');

$db;


if (!isset($_SESSION['name'])) {
   // header("Location: login");
   echo '<script>window.location.href = "login";</script>';
   exit();
}

if (isset($_SESSION['name'])) {
   if ($_SESSION['role'] == "admin") {
      $db = 'admin';
   }
   if ($_SESSION['role'] == "sub_branch") {
      $db = 'sub_restaurants';
   }
   if ($_SESSION['role'] == "main_branch") {
      $db = 'restaurants';
   }

   $id = $_SESSION['id'];
   $query = "SELECT * FROM $db WHERE `id`= '$id'";
   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

   if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);

      if ($row['name'] != $_SESSION['name']) {
         $_SESSION['name'] = $row['name'];
      }
      if ($row['role'] != $_SESSION['role']) {
         $_SESSION['role'] = $row['role'];
      }
      if ($row['active_status'] != $_SESSION['active_status']) {
         echo '<script>window.location.href = "logout";</script>';
         exit();
      }
   } else {
      $query = "SELECT * FROM restaurants WHERE `id`= '$id'";
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

      if ($result) {
         $row = mysqli_fetch_assoc($result);

         if ($row['name'] != $_SESSION['name']) {
            $_SESSION['name'] = $row['name'];
         }
         if ($row['role'] != $_SESSION['role']) {
            $_SESSION['role'] = $row['role'];
         }
         if ($row['active_status'] != $_SESSION['active_status']) {
            echo '<script>window.location.href = "logout";</script>';
            exit();
         }
      }
   }
}




function sessionalteration()
{
}
ob_end_flush();
