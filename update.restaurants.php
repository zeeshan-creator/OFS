<?php

include './auth/login_auth.php';
include './auth/!=admin_auth.php';


include("./includes/restaurants/code.updateRestaurants.php");

if (!isset($_GET['id'])) {
  echo '<script>window.location.href = "allrestaurants";</script>';
  exit();
}

if (isset($_GET['id'])) {
  $id = trim($_GET['id']);

  $restaurant_query = "SELECT * FROM restaurants WHERE id='$id' LIMIT 1";
  $result = mysqli_query($conn, $restaurant_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $name = $row["name"];
    $phone = $row["phone"];
    $email = $row["email"];
    $password = $row["password"];
    $role = $row["role"];
    $active_status = $row["active_status"];
  } else {
    // URL doesn't contain valid id. Redirect to allrestaurants
    // header("location: allrestaurants");
    echo '<script>window.location.href = "allrestaurants";</script>';
    exit();
  }
}
ob_end_flush();

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
            <h3 class="card-title">Edit Restaurant</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <input type="hidden" name="restaurantId" value="<?php echo $id; ?>">
                <div class=" col-md-6 mb-3">
                  <label for="restaurantname">restaurant name</label>
                  <input type="text" class="form-control" value="<?php echo $name; ?>" name="restaurantName" min="3" max="15" placeholder="Enter restaurant Name" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" value="<?php echo $phone; ?>" name="restaurantPhone" placeholder="Enter restaurant phone number" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant phone number (min=11, max=13)
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantEmail">restaurant E-Mail</label>
                  <input type="email" class="form-control" value="<?php echo $email; ?>" name="restaurantEmail" max="55" placeholder="Enter restaurant Email" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant Email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantPassword">restaurant Password</label>
                  <input type="text" class="form-control" value="<?php echo $password; ?>" name="restaurantPassword" min="6" max="16" placeholder="Enter restaurant password" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="roleSelect">Role</label>
                  <select class="form-control" id="roleSelect" name="role" required>
                    <?php
                    if ($role == "main_branch") {
                      echo '<option value="main_branch" selected>Main branch</option>
                                    <option value="sub_branch" >Sub branch</option>';
                    }
                    if ($role == "sub_branch") {
                      echo '<option value="sub_branch" selected>Sub branch</option>
                                    <option value="main_branch">Main branch</option>';
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="roleSelect">Active Status</label>
                  <select class="form-control" id="roleSelect" name="active_status" required>
                    <?php
                    if ($active_status == "active") {
                      echo '<option value="active" selected>Active</option>
                                          <option value="inactive">Inactive</option>';
                    }
                    if ($active_status == "inactive") {
                      echo '<option value="inactive" selected>Inactive</option>
                                       <option value="active">Active</option>';
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">Save</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Discard</button>
          </div>

          </form>

          <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
              'use strict';
              window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();

            // GO BACK 
            function goBack() {
              window.history.back();
            }
          </script>
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