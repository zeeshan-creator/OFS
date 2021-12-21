<?php
ob_start();

// initializing variables
$size_name;
$active_status;
$restaurant_Id = $_SESSION['id'];

// Sample 3d arr
// $sampleArr = array(
//    array(
//       'monday' => array(
//          'value' => '1',
//          'start' => '12:00 AM',
//          'end' => '07:35 AM'
//       )
//    )
// );

$timings = array();
$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // receive all input values from the form

   $Monday = isset($_POST['Monday']) ? $_POST['Monday'] : null;
   $MondayStartTime = isset($_POST['MondayStartTime']) ? $_POST['MondayStartTime'] : null;
   $MondayEndTime = isset($_POST['MondayEndTime']) ? $_POST['MondayEndTime'] : null;
   array_push($timings, array($days[0] => array('value' => $Monday, 'start' => $MondayStartTime, 'end' => $MondayEndTime)));

   $Tuesday = isset($_POST['Tuesday']) ? $_POST['Tuesday'] : null;
   $TuesdayStartTime = isset($_POST['TuesdayStartTime']) ? $_POST['TuesdayStartTime'] : null;
   $TuesdayEndTime = isset($_POST['TuesdayEndTime']) ? $_POST['TuesdayEndTime'] : null;
   array_push($timings, array($days[1] => array('value' => $Tuesday, 'start' => $TuesdayStartTime, 'end' => $TuesdayEndTime)));

   $Wednesday = isset($_POST['Wednesday']) ? $_POST['Wednesday'] : null;
   $WednesdayStartTime = isset($_POST['WednesdayStartTime']) ? $_POST['WednesdayStartTime'] : null;
   $WednesdayEndTime = isset($_POST['WednesdayEndTime']) ? $_POST['WednesdayEndTime'] : null;
   array_push($timings, array($days[2] => array('value' => $Wednesday, 'start' => $WednesdayStartTime, 'end' => $WednesdayEndTime)));

   $Thursday = isset($_POST['Thursday']) ? $_POST['Thursday'] : null;
   $ThursdayStartTime = isset($_POST['ThursdayStartTime']) ? $_POST['ThursdayStartTime'] : null;
   $ThursdayEndTime = isset($_POST['ThursdayEndTime']) ? $_POST['ThursdayEndTime'] : null;
   array_push($timings, array($days[3] => array('value' => $Thursday, 'start' => $ThursdayStartTime, 'end' => $ThursdayEndTime)));

   $Friday = isset($_POST['Friday']) ? $_POST['Friday'] : null;
   $FridayStartTime = isset($_POST['FridayStartTime']) ? $_POST['FridayStartTime'] : null;
   $FridayEndTime = isset($_POST['FridayEndTime']) ? $_POST['FridayEndTime'] : null;
   array_push($timings, array($days[4] => array('value' => $Friday, 'start' => $FridayStartTime, 'end' => $FridayEndTime)));

   $Saturday = isset($_POST['Saturday']) ? $_POST['Saturday'] : null;
   $SaturdayStartTime = isset($_POST['SaturdayStartTime']) ? $_POST['SaturdayStartTime'] : null;
   $SaturdayEndTime = isset($_POST['SaturdayEndTime']) ? $_POST['SaturdayEndTime'] : null;
   array_push($timings, array($days[5] => array('value' => $Saturday, 'start' => $SaturdayStartTime, 'end' => $SaturdayEndTime)));

   $Sunday = isset($_POST['Sunday']) ? $_POST['Sunday'] : null;
   $SundayStartTime = isset($_POST['SundayStartTime']) ? $_POST['SundayStartTime'] : null;
   $SundayEndTime = isset($_POST['SundayEndTime']) ? $_POST['SundayEndTime'] : null;
   array_push($timings, array($days[6] => array('value' => $Sunday, 'start' => $SundayStartTime, 'end' => $SundayEndTime)));


   foreach ($timings as $x) {
      foreach ($days as $day) {
         $val = $x[$day]['value'];
         $start = $x[$day]['start'];
         $end = $x[$day]['end'];

         $query = "UPDATE `restaurant_timings` SET 
         `value` = '$val', 
         `start` = '$start',
         `end` = '$end'
         WHERE `restaurant_id` = $restaurant_Id AND `day` = '$day'";
         $results = mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
   }

   if ($results) {
      $id;
      if (isset($_GET['branchId'])) {
         $id = trim($_GET['branchId']);
         if ($_SESSION['role'] == 'admin') {
            header("location: restaurantDetails?id=$id");
            exit();
         }
      }
      echo '<script>window.location.href = "restaurant_timing";</script>';
      exit();
   }
}
