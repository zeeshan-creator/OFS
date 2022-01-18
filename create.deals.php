<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/deals/code.Deal.php");
?>

<!DOCTYPE html>
<html lang="en">

<!-- Including Header -->
<?php include './partials/head.php' ?>
<style>
  .redAsterick:after {
    content: " *";
    color: red;
  }
</style>

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

                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                  <div class="col-md-5 mb-3 ">
                    <label for="photo" class="d-block redAsterick">Deal Image</label>
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
                    <div class=" col-lg-6 mb-3">
                      <label for="dealName" class="redAsterick">Deal name</label>
                      <input type="text" class="form-control" name="dealName" min="3" max="15" placeholder="Enter deal Name" id="dealName" required>
                      <div class="invalid-feedback">
                        Please enter a deal name
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="price" class="redAsterick">price</label>
                      <input type="number" class="form-control" name="dealPrice" placeholder="Enter deal price" id="price" required>
                      <div class="invalid-feedback">
                        Please enter a deal price
                      </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                      <label for="description" class="redAsterick">Deal description</label>
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