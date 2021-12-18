<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';
include("./includes/restaurants/delivery_setting/code.updateDeliverySettings.php");

$id = $_SESSION['id'];

$restaurant_query = "SELECT * FROM `delivery_settings` WHERE `restaurant_id` = '$id'";
$result = mysqli_query($conn, $restaurant_query);
$row = mysqli_fetch_assoc($result);

if ($row) {
  // Retrieve individual field value
  $min_delivery = $row["min_delivery"];
  $min_pickup = $row["min_pickup"];
  $min_dineIn = $row["min_dineIn"];
  $packaging_charges = $row["packaging_charges"];
  $delivery_charges = $row["delivery_charges"];
  $free_delivery_over = $row["free_delivery_over"];
  $tax = $row['tax'];
  $delivery_time = $row['delivery_time'];
}
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
            <h3 class="card-title">Delivery Setting</h3>
          </div>
          <div class="card-body">
            <form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

              <div class="form-row">
                <input type="hidden" name="restaurantId" value="<?php echo $id; ?>">

                <div class=" col-md-6 mb-3">
                  <label for="min_delivery">Minimum Delivery Order Price</label>
                  <input type="text" class="form-control" value="<?php echo $min_delivery; ?>" name="min_delivery" placeholder="Enter Minimum Order Delivery Price" id="min_delivery">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="min_pickup">Minimum pickup Order Price</label>
                  <input type="number" class="form-control" value="<?php echo $min_pickup; ?>" name="min_pickup" placeholder="Enter restaurant min_pickup number" id="min_pickup">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="min_dineIn">Minimum Dine-In Order Price</label>
                  <input type="text" class="form-control" value="<?php echo $min_dineIn; ?>" name="min_dineIn" max="55" placeholder="Enter restaurant min_dineIn" id="min_dineIn">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="packaging_charges">Packaging Charges</label>
                  <input type="text" class="form-control" value="<?php echo $packaging_charges; ?>" name="packaging_charges" placeholder="Enter restaurant packaging_charges" id="packaging_charges">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="delivery_charges">Delivery Charges</label>
                  <input type="text" class="form-control" value="<?php echo $delivery_charges; ?>" name="delivery_charges" placeholder="Enter delivery_charges" id="delivery_charges">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="free_delivery_over">Free Delivery Over</label>
                  <small>(minimum order price for free delivery)</small>
                  <input type="number" class="form-control" value="<?php echo $free_delivery_over; ?>" name="free_delivery_over" placeholder="Enter free delivery over" id="free_delivery_over">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="tax">Per Order Tax</label>
                  <small>(Percentage)</small>
                  <input type="text" class="form-control" value="<?php echo $tax; ?>" name="tax" placeholder="Enter tax amount" id="tax">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="delivery_time">Minimum Delivery Time</label>
                  <small>(minutes)</small>
                  <input type="text" class="form-control" value="<?php echo $delivery_time; ?>" name="delivery_time" placeholder="Enter delivery time" id="delivery_time">
                </div>

              </div>

              <button class="btn btn-primary float-right" type="submit">Save</button>
            </form>
          </div>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>