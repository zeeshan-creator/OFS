<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';


include("./includes/restaurants/social_media_links/code.Link.php");

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
            <h3 class="card-title">Create Link</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter a Name" id="name" required>
                  <div class="invalid-feedback">
                    Please enter a name
                  </div>
                </div>

                <div class="col-md-12 mb-3">
                  <label for="link">Link</label>
                  <input class="form-control" name="link" placeholder="Enter link" id="link" required>
                  <div class="invalid-feedback">
                    Please enter a link
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">Create</button>
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

  </div>
  <!-- /.content-wrapper -->


  <!-- Including footer -->
  <?php include './partials/footer.php' ?>
  <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

</body>

</html>