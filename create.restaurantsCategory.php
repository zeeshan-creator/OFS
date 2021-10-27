<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';


include("./includes/restaurants/categories/code.restaurantCategories.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including header -->
<?php include './partials/head.php' ?>


<body class="">
  <div class="wrapper">

    <!-- Including sidebar -->
    <?php include './partials/sidebar.php' ?>


    <div class="main-panel">
      <!-- Navbar -->
      <!-- Including nav -->

      <?php include './partials/nav.php' ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <?php include('./errors.php'); ?>
              <form method="POST" class="needs-validation" novalidate>
                <div class="form-row">
                  <div class="col-md-12 mb-6">
                    <label for="categoryName">Category name</label>
                    <input type="text" class="form-control" name="categoryName" min="3" max="15" placeholder="Enter Category Name" id="categoryName" required>
                    <div class="invalid-feedback">
                      Please enter a Category name
                    </div>
                  </div>

                  <div class="col-md-12 mb-6">
                    <label for="description">Description</label>
                    <textarea rows="5" cols="10" class="form-control" name="categoryDesc" placeholder="Enter description" id="description" required></textarea>
                    <div class="invalid-feedback">
                      Please enter a description
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary float-right" type="submit">Submit form</button>
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

    <!-- Including footer -->
    <?php include './partials/footer.php' ?>

  </div>
  </div>

</body>

</html>