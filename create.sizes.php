<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/sizes/code.Size.php");
$id;
if (isset($_GET['branchId'])) {
  if ($_SESSION['role'] == 'admin') {
    $id = trim($_GET['branchId']);
  } else {
    echo '<script>window.location.href = "sizes";</script>';
    exit();
  }
} else {
  $id = $_SESSION['id'];
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
            <h3 class="card-title">Create Size</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <div class="col-lg-6 mb-3">
                  <label for="sizename">Size name</label>
                  <input type="text" class="form-control float-left" name="sizeName" min="3" max="15" placeholder="Enter size Name" id="sizename" required>
                  <div class="invalid-feedback">
                    Please enter a size name
                  </div>
                </div>
                <div class="col-lg-6 mt-4">
                  <button class="btn btn-primary float-right" type="submit">ADD</button>
                </div>
              </div>
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

  <script>
    Dropzone.discover();
  </script>

</body>

</html>