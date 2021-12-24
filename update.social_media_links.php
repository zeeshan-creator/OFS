<?php

include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';

include("./includes/restaurants/social_media_links/code.updateLink.php");

if (!isset($_GET['id'])) {
  echo '<script>window.location.href = "social_media_links";</script>';
  exit();
}

if (isset($_GET['id'])) {
  $id = trim($_GET['id']);

  $social_media_links_query = "SELECT * FROM social_media_links WHERE id='$id' LIMIT 1";
  $result = mysqli_query($conn, $social_media_links_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $id = $row["id"];
    $name = $row["name"];
    $link = $row["link"];
    $active_status = $row["active_status"];
  } else {
    // URL doesn't contain valid id. Redirect to social_media_links
    echo '<script>window.location.href = "social_media_links";</script>';
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
            <h3 class="card-title">Edit Category</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <input type="hidden" name="linkID" value="<?php echo $id; ?>">
                <div class=" col-md-12 mb-4">
                  <label for="name">Category name</label>
                  <input type="text" class="form-control" value="<?php echo $name; ?>" name="name" placeholder="Enter Category Name" id="name" required>
                  <div class="invalid-feedback">
                    Please enter a category name
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
                <div class="col-md-12 mb-4">
                  <label for="link">Category description</label>
                  <input type="text" class="form-control" value="<?php echo $link; ?>" name="link" placeholder="Enter category description" id="link" required>
                  <div class="invalid-feedback">
                    Please enter category description
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

</body>

</html>