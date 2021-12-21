<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/timings/code.fetchTime.php");
include("./includes/restaurants/timings/code.updateTime.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>

<body class="hold-transition sidebar-mini sidebar-collapse">

   <div class="wrapper">

      <!-- Navbar -->
      <?php include './partials/nav.php' ?>
      <!-- End Navbar -->


      <!-- Main Sidebar Container -->
      <?php include './partials/sidebar.php' ?>
      <!-- END Sidebar Container -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

         <div class="row m-1">
            <div class="card card-info w-100 p-2">
               <div class="card-header">
                  <h3 class="card-title">Restaurant Timings</h3>
               </div>

               <div class="card-body">
                  <form action="" method="post">
                     <div class="d-flex flex-column">

                        <?php while ($row = mysqli_fetch_assoc($restaurant_timings)) { ?>
                           <div class="">
                              <div class="d-flex flex-row my-2">
                                 <div style="font-size: larger;">
                                    <input type="checkbox" id="<?php echo $row['day'] ?>" <?php echo $row['value'] == 1 ? 'checked' : '' ?> value="1" name="<?php echo $row['day'] ?>">
                                    <label for="<?php echo $row['day'] ?>" class="px-2">
                                       <?php echo $row['day'] ?>
                                    </label>
                                 </div>
                                 <div class="">
                                    <input type="time" name="<?php echo $row['day'] ?>StartTime" value="<?= date("H:i", strtotime($row['start'])); ?>" class="form-control">
                                 </div>
                                 <div class="px-2 mt-1" style="font-size: larger;">
                                    TO
                                 </div>
                                 <div class="">
                                    <input type="time" name="<?php echo $row['day'] ?>EndTime" value="<?= date("H:i", strtotime($row['end'])); ?>" class="form-control" id="">
                                 </div>
                              </div>
                           </div>
                        <?php } ?>

                     </div>
                     <input type="submit" value="Save" class="btn btn-info">
                  </form>
               </div>
            </div>
         </div>

      </div>
      <!-- /.content-wrapper -->


      <!-- Including footer -->
      <?php include './partials/footer.php' ?>
      <?php ob_end_flush(); ?>

      <Script>
         // 
      </Script>
   </div>
   <!-- ./wrapper -->

</body>

</html>