<?php

include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';

include("./includes/restaurants/sizes/code.updateSize.php");

if (!isset($_GET['sizeID'])) {
  echo '<script>window.location.href = "sizes";</script>';
  exit();
}

if (isset($_GET['sizeID'])) {
  $id = trim($_GET['sizeID']);

  $size_query = "SELECT * FROM sizes WHERE id='$id' LIMIT 1";
  $result = mysqli_query($conn, $size_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $id = $row["id"];
    $size_name = $row["size"];
    $active_status = $row["active_status"];
  } else {
    // URL doesn't contain valid id. Redirect to sizes
    echo '<script>window.location.href = "sizes";</script>';
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
            <h3 class="card-title">Edit Sizes</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <input type="hidden" name="sizeId" value="<?php echo $id; ?>">
                <div class=" col-md-12 mb-4">
                  <label for="size_name">sizes name</label>
                  <input type="text" class="form-control" value="<?php echo $size_name; ?>" name="size_name" placeholder="Enter size Name" id="size_name" required>
                  <div class="invalid-feedback">
                    Please enter a size name
                  </div>
                </div>
                <div class="col-md-12 mb-4">
                  <label for="activeStatus">Active Status</label>
                  <select class="form-control" id="activeStatus" name="active_status" required>
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