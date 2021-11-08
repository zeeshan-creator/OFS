<?php

include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';


include("./includes/sub_branch/code.updateSub_branch.php");
if (!isset($_GET['id'])) {
  echo '<script>window.location.href = "allsub_branches";</script>';
  exit();
}

if (isset($_GET['id'])) {
  $id = trim($_GET['id']);

  $restaurant_query = "SELECT * FROM sub_restaurants WHERE id='$id' LIMIT 1";
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
    $main_branch = $row["main_branch"];
  } else {
    echo '<script>window.location.href = "allsub_branches";</script>';
    exit();
  }
}
ob_end_flush();

$restaurant_query = "SELECT id,name, email FROM restaurants";
$result = mysqli_query($conn, $restaurant_query);

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
        <div class="card">
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
                    Please enter a restaurant phone number
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
                  <!-- <select class="form-control" id="roleSelect" name="role" required>
                                 <?php
                                  // if ($role == "main_branch") {
                                  //    echo '<option value="main_branch" selected>Main branch</option>
                                  //    <option value="sub_branch" >Sub branch</option>';
                                  // }
                                  // if ($role == "sub_branch") {
                                  //    echo '<option value="sub_branch" selected>Sub branch</option>
                                  //    <option value="sub_branch">Main branch</option>';
                                  // }
                                  ?>
                              </select> -->
                  <input type="hidden" name="role" value="<?php echo $role ?>">
                  <p class="rounded" style="color:grey;border: 1px solid #2b3553; padding: 6px 0px 6px 10px; border-radius:"><?php echo $role; ?></p>
                  <div class="invalid-feedback">
                    Please enter a Role
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
                    Please enter a active status
                  </div>
                </div>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                  <div class="col-md-6 mb-3">
                    <label for="roleSelect">Main branch</label>
                    <select class="form-control" id="roleSelect" name="main_branch" required>
                      <?php
                      while ($row = mysqli_fetch_array($result)) {
                        if ($row['id'] == $main_branch) {
                          # code...
                          echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . " (" . $row['email'] . ")" . "</option>";
                          continue;
                        }
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . " (" . $row['email'] . ")" . "</option>";  // displaying data in option menu
                      }
                      ?>
                    </select>
                    <div class="invalid-feedback">
                      Please enter a restaurant Main branch
                    </div>
                  </div>
                <?php endif ?>
                <?php if ($_SESSION['role'] == 'main_branch') : ?>
                  <input type="hidden" name="main_branch" value="<?php echo $main_branch ?>">
                <?php endif ?>
              </div>

              <button class="btn btn-primary float-right" type="submit">Submit form</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Cancel</button>
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