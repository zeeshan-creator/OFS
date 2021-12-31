<?php
ob_start();
include './auth/login_auth.php';
include './auth/==admin_auth.php';


$areaID = 0;

if (isset($_POST['areaID'])) {
   $areaID = mysqli_real_escape_string($conn, $_POST['areaID']);
   $deliveryZoneID = mysqli_real_escape_string($conn, $_POST['deliveryZoneID']);
}

if ($areaID > 0) {
   // Check record exists
   $checkRecord = mysqli_query($conn, "SELECT * FROM `zone_area` WHERE `area_id` = $areaID AND `delivery_zone_id` = $deliveryZoneID ");
   $totalrows = mysqli_num_rows($checkRecord);

   if ($totalrows > 0) {
      // Delete record
      $query = "DELETE FROM zone_area WHERE `area_id` = $areaID AND `delivery_zone_id` = $deliveryZoneID";
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
