<?php
ob_start();
session_start();
require('./config/db.php');

$zoneID;
$deliveryZoneID;

if (isset($_POST['action']) && $_POST['action'] == "addToZone") {
   $areaID = trim($_POST['areaID']);
   $deliveryZoneID = trim($_POST['deliveryZoneID']);

   $query = "INSERT INTO `zone_area`(`area_id`, `delivery_zone_id`) VALUES($areaID, $deliveryZoneID) ";
   $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
   if ($result) {
      echo 1;
   } else {
      echo 0;
   }
}
