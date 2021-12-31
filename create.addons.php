<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/addon_products/code.Addon.php");

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
            <h3 class="card-title">Create Addon</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
              <div class="col-md-5 mb-3 ">
                <label for="photo" class="d-block">Addon Image</label>
                <div class="d-flex">
                  <img src="" style="width: 100px;" class="elevation-2 d-none" id="logo" alt="product Image">
                  <div class="col-md-12 mb-3">
                    <input type="file" class="form-control-file ml-4 mt-4 border rounded p-1" name="photo" accept='image/*' onchange="readURL(this)" id="photo" required>
                    <div class="invalid-feedback">
                      Please select a product image
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class=" col-md-6 mb-4">
                  <label for="name">Addon name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter addon Name" id="name" required>
                  <div class="invalid-feedback">
                    Please enter a addon name
                  </div>
                </div>
                <div class=" col-md-6 mb-4">
                  <label for="price">Price</label>
                  <input type="number" class="form-control" name="price" placeholder="Enter addon Name" id="price" required>
                  <div class="invalid-feedback">
                    Please enter a addon price
                  </div>
                </div>
                <div class=" col-md-12 mb-4">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" name="description" placeholder="Enter addon description" id="description" required>
                  <div class="invalid-feedback">
                    Please enter a addon description
                  </div>
                </div>

              </div>

              <button class="btn btn-primary float-right" type="submit">Save</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Discard</button>
          </div>

          </form>

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
    function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function(e) {
          var logo = document.getElementById("logo");
          logo.setAttribute("src", e.target.result);
          logo.classList.remove("d-none");
        };
        reader.readAsDataURL(input.files[0]);
      }
    };
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

  <script>
    Dropzone.discover();
  </script>

</body>

</html>