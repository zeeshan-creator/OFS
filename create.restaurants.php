<?php
include './auth/login_auth.php';
include './auth/admin_auth.php';

include("./includes/restaurants/code.createrestaurants.php");
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
                  <div class="col-md-6 mb-3">
                    <label for="Branchname">Branch name</label>
                    <input type="text" class="form-control" name="branchName" min="3" max="15" placeholder="Enter branch Name" id="Branchname" required>
                    <div class="invalid-feedback">
                      Please enter a Branch name
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" name="branchPhone" placeholder="Enter branch phone number" id="phone" required>
                    <div class="invalid-feedback">
                      Please enter a Branch phone number (min=11, max=13)
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="branchEmail">Branch E-Mail</label>
                    <input type="email" class="form-control" name="branchEmail" max="55" placeholder="Enter branch Email" id="Branchname" required>
                    <div class="invalid-feedback">
                      Please enter a Branch Email
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="branchPassword">Branch Password</label>
                    <input type="text" class="form-control" name="branchPassword" min="6" max="16" placeholder="Enter branch password" id="phone" required>
                    <div class="invalid-feedback">
                      Please enter a Branch password
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