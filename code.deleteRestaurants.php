<?php
ob_start();
include './auth/login_auth.php';
include './auth/!=admin_auth.php';


require('./config/db.php');

$id = 0;

if (isset($_POST['id'])) {
   $id = mysqli_real_escape_string($conn, $_POST['id']);
}
if ($id > 0) {

   // Check record exists
   $checkRecord = mysqli_query($conn, "SELECT * FROM restaurants WHERE id=" . $id);
   $totalrows = mysqli_num_rows($checkRecord);

   if ($totalrows > 0) {
      $query = "SELECT `logo` FROM restaurants WHERE id = " . $id;
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);
      $file = "includes/restaurants/logos/" . $row['logo'];
      unlink($file);

      // Delete record
      $query = "DELETE FROM restaurants WHERE id=" . $id;
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
