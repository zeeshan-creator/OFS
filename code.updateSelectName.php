<?php
ob_start();
include './auth/login_auth.php';
include './auth/==admin_auth.php';


if (isset($_POST['ID'])) {
   $id = mysqli_real_escape_string($conn, $_POST['ID']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
}
if ($id > 0) {
   // Check record exists
   $date = date('Y-m-d H:i:s');
   $checkRecord = mysqli_query($conn, "UPDATE `deal_selects` SET `select_name` = '$name', `updated_at` = '$date' WHERE `id` = " . $id);
   $totalrows = mysqli_num_rows($checkRecord);

   if ($totalrows > 0) {
      echo 1;
      exit;
   } else {
      echo 0;
      exit;
   }
}

echo 0;
exit;

ob_end_flush();
