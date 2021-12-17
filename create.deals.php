<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.Deal.php");
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
            <h3 class="card-title">Create Deal</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <div class="row">
              <div class="col-lg-12">

                <form method="POST" class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class=" col-lg-6 mb-3">
                      <label for="dealName">Deal name</label>
                      <input type="text" class="form-control" name="dealName" min="3" max="15" placeholder="Enter deal Name" id="dealName" required>
                      <div class="invalid-feedback">
                        Please enter a deal name
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="price">price</label>
                      <input type="number" class="form-control" name="dealPrice" placeholder="Enter deal price" id="price" required>
                      <div class="invalid-feedback">
                        Please enter a deal price
                      </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                      <label for="description">Deal description</label>
                      <textarea rows="1" type="text" class="form-control" name="dealDesc" placeholder="Enter deal description" id="description" required></textarea>
                      <div class="invalid-feedback">
                        Please enter a deal description
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-primary float-right mb-4" type="submit">ADD</button>



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