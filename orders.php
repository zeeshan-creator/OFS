<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/orders/code.fetchOrders.php");
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

      <div class="row">
        <div class="col-lg-5 ml-3 mt-4 mb-2">
          <h1 class="">
            <span style="border-bottom: 3px double black;">
              Order
            </span>
          </h1>
        </div>
      </div>
      <div class="p-3">
        <table class="table" id="orders">
          <thead>
            <tr class="text-center">
              <th>Order ID</th>
              <th>Order Type</th>
              <th>Customer Name</th>
              <th>Customer Phone</th>
              <th>Customer Email</th>
              <th>Date & Time</th>
              <th>Amount</th>
              <th>Status</th>

              <?php if ($_SESSION['role'] == 'main_branch') : ?>
                <!-- <th>Active Status</th> -->
              <?php endif ?>
              <!-- <?php if ($_SESSION['role'] == 'sub_branch') : ?>
                <th>Availability</th>
              <?php endif ?> -->

              <?php if ($_SESSION['role'] == 'main_branch') : ?>
                <th>Actions</th>
              <?php endif ?>
            </tr>
          </thead>
          <tbody class="w" id="orders_tbody">
            <?php
            while ($row = mysqli_fetch_assoc($orders)) {
              echo "<tr class='text-center'>
              <td>" . $row['id'] . "</td>
              <td>" . $row['order_type'] . "</td>
              <td>" . $row['customer_name'] . "</td>
              <td>" . $row['customer_phone'] . "</td>
              <td>" . $row['customer_email'] . "</td>
              <td>" . $row['order_date'] . " " . $row['order_time'] .  "</td>
              <td>" . $row['total_price'] . "</td>
              <td>" . $row['current_status'] . "</td>";

              if ($_SESSION['role'] == 'main_branch') {
                echo "<td class='td-actions text-right'>
                          <a href='orderDetails?orderID=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-info btn-link btn-icon btn-sm'>
                            <span style='color:white;'>
                              <i class='fas fa-info-circle'></i>
                            </span>
                          </a>
                        </td>
                      </tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

    <script>
      $(document).ready(function() {
        setInterval(function() {
          jQuery.ajax({
            url: 'includes/restaurants/orders/code.loadOrder.php',
            success: function(response) {
              $('#orders_tbody').html(response);

            },
          });
        }, 1000);
        $('#orders').DataTable({
          "lengthChange": false,
          "bInfo": false,
          "order": [
            [0, "desc"]
          ]
        });
      });
    </script>

  </div>
  <!-- ./wrapper -->

</body>

</html>