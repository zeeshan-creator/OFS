<?php
include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/offers/code.offer.php");
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
            <h3 class="card-title">Create Offer</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <div class="row">
              <div class="col-lg-12">

                <form method="POST" class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class=" col-lg-6 mb-3">
                      <label for="offer_name">Offer Name</label>
                      <input type="text" class="form-control" name="offer_name" min="3" max="15" placeholder="Enter offer name" id="offer_name" required>
                      <div class="invalid-feedback">
                        Please enter a offer name
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="offer_percentage">Offer Percentage</label>
                      <input type="number" class="form-control" name="offer_percentage" placeholder="Enter offer percentage" id="offer_percentage" required>
                      <div class="invalid-feedback">
                        Please enter a offer percentage
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="offer_message">Offer Message</label>
                      <textarea rows="1" type="text" class="form-control" name="offer_message" placeholder="Enter offer message" id="offer_message" required></textarea>
                      <div class="invalid-feedback">
                        Please enter a offer message
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="order_over">On Orders Over (<span style="font-weight: lighter;"> optional, default is 0</span>)</label>
                      <input type="number" class="form-control" name="order_over" placeholder="Enter minimum order price" id="order_over">
                      <div class="invalid-feedback">
                        Please enter a price
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="valid_from">Offer From</label>
                      <input type="date" class="form-control" name="valid_from" placeholder="Enter offer start date" id="valid_from" required>
                      <div class="invalid-feedback">
                        Please enter a offer start date
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <label for="valid_till">Offer Till</label>
                      <input type="date" class="form-control" name="valid_till" placeholder="Enter offer end date" id="valid_till" required disabled>
                      <div class="invalid-feedback">
                        Please enter a offer end date
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
    $(function() {
      var dtToday = new Date();
      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();
      if (month < 10)
        month = '0' + month.toString();
      if (day < 10)
        day = '0' + day.toString();

      var minDate = year + '-' + month + '-' + day;
      $('#valid_from').attr('min', minDate);
      $("#valid_from").change(function() {
        var date = new Date($('#valid_from').val());
        var newDate = date.toString('yyyy-MM-dd');

        $("#valid_till").prop("disabled", false);
        $('#valid_till').attr('min', convert(newDate));

        function convert(newDate) {
          var date = new Date(newDate),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
          return [date.getFullYear(), mnth, day].join("-");
        }
      });
    });

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