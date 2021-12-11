<?php
ob_start();
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';

require('./config/db.php');

$id = 0;

if (isset($_POST['id'])) {
   $id = mysqli_real_escape_string($conn, $_POST['id']);
}
if ($id > 0) {
   // Check record exists
   $checkRecord = mysqli_query($conn, "SELECT * FROM offers WHERE id=" . $id);
   $totalrows = mysqli_num_rows($checkRecord);

   if ($totalrows > 0) {
      // Delete record
      $query = "DELETE FROM offers WHERE id=" . $id;
      $result = mysqli_query($conn, $query);
      if ($result) {
         echo 1;
      }
      exit;
   } else {
      echo 0;
      exit;
   }
}

echo 0;
exit;

ob_end_flush();
