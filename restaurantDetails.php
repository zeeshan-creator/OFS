<?php ob_start();

include './auth/login_auth.php';
include './auth/!=admin_auth.php';

include("./includes/restaurants/code.updateRestaurants.php");

if (!isset($_GET['id'])) {
  echo '<script>window.location.href = "allrestaurants";</script>';
  exit();
}

if (isset($_GET['id'])) {
  $id = trim($_GET['id']);

  $restaurant_query = "SELECT * FROM restaurants WHERE id='$id' LIMIT 1";
  $result = mysqli_query($conn, $restaurant_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $name = $row["name"];
    $phone = $row["phone"];
    $email = $row["email"];
    $password = $row["password"];
    $role = $row["role"];
    $active_status = $row["active_status"];

    $sub_branch_query = "SELECT * FROM sub_restaurants WHERE main_branch = '$id'";
    $sub_branches = mysqli_query($conn, $sub_branch_query) or die(mysqli_error($conn));

    $category_query = "SELECT * FROM categories WHERE restaurant_id = '$id'";
    $categories = mysqli_query($conn, $category_query) or die(mysqli_error($conn));

    $product_query = "SELECT products.id, products.name as productName, categories.category_name as categoryName, products.description, products.price, products.photo, products.item_availability, products.active_status, products.created_at, products.updated_at FROM `products` JOIN categories on products.category_id = categories.id WHERE restaurant_id = '$id'";
    $products = mysqli_query($conn, $product_query) or die(mysqli_error($conn));
  } else {
    echo '<script>window.location.href = "allrestaurants";</script>';
    exit();
  }
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
            <h3 class="card-title">Edit Restaurant</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" novalidate>
              <div class="form-row">
                <input type="hidden" name="restaurantId" value="<?php echo $id; ?>">
                <div class=" col-md-6 mb-3">
                  <label for="restaurantname">restaurant name</label>
                  <input type="text" class="form-control" value="<?php echo $name; ?>" name="restaurantName" min="3" max="15" placeholder="Enter restaurant Name" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" value="<?php echo $phone; ?>" name="restaurantPhone" placeholder="Enter restaurant phone number" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant phone number (min=11, max=13)
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantEmail">restaurant E-Mail</label>
                  <input type="email" class="form-control" value="<?php echo $email; ?>" name="restaurantEmail" max="55" placeholder="Enter restaurant Email" id="restaurantname" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant Email
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="restaurantPassword">restaurant Password</label>
                  <input type="text" class="form-control" value="<?php echo $password; ?>" name="restaurantPassword" min="6" max="16" placeholder="Enter restaurant password" id="phone" required>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="roleSelect">Role</label>
                  <select class="form-control" id="roleSelect" name="role" required>
                    <?php
                    if ($role == "main_branch") {
                      echo '<option value="main_branch" selected>Main branch</option>
                                    <option value="sub_branch" >Sub branch</option>';
                    }
                    if ($role == "sub_branch") {
                      echo '<option value="sub_branch" selected>Sub branch</option>
                                    <option value="main_branch">Main branch</option>';
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Please enter a restaurant password
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="roleSelect">Active Status</label>
                  <select class="form-control" id="roleSelect" name="active_status" required>
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
                    Please enter a restaurant password
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">Submit form</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="goBack()">Cancel</button>
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

      <!-- SUB BRANCHES -->
      <div class="row mt-5 text-center">
        <div class="col-lg-12 col-md-12 ml-3 mt-3">
          <h1 class="">
            <span style="border-bottom: 3px double;">
              SUB-BRANCHES
            </span>
          </h1>
        </div>
        <div class=" ml-auto mt-3">
          <a href="./create.sub_branch" class="btn btn-primary mb-3 mr-4">Create Sub Branch</a>
        </div>
      </div>
      <div class="p-3">
        <table class="table" id="sub_branches">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>Phone</th>
              <th>Role</th>
              <th>Active Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($sub_branches)) {
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['name'] . "</td>
              <td>" . $row['email'] . "</td>
              <td>" . $row['password'] . "</td>
              <td>" . $row['phone'] . "</td>
              <td>" . $row['role'] . "</td>
              <td>" . $row['active_status'] . "</td>
              <td class='td-actions text-right'>
                <a href='update.sub_branch?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                 <span style='color:white;'>
                    <i class='far fa-edit'></i>
                  </span>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleteSub_branch(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='fas fa-trash-alt'></i>
                  </span>
                </button>
              </td>
            </tr>";
              $count++;
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- CATEGORIES -->
      <div class="row mt-5  text-center">
        <div class="col-lg-12 col-md-12 ml-3 mt-3">
          <h1 class="">
            <span style="border-bottom: 3px double;">
              CATEGORIES
            </span>
          </h1>
        </div>
      </div>
      <div class="p-3">

        <table class="table" id="categories">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>category name</th>
              <th>Description</th>
              <th>Published</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            $productsIndex = 0;
            while ($row = mysqli_fetch_assoc($categories)) {
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['category_name'] . "</td>
              <td>" . $row['category_desc'] . "</td>
              <td>" . $row['created_at'] . "</td>
              <td class='td-actions text-right'>
                <a href='update.restaurantCategories?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                 <span style='color:white;'>
                    <i class='far fa-edit'></i>
                  </span>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleterestaurantCategory(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='fas fa-trash-alt'></i>
                  </span>
                </button>
              </td>
            </tr>";
              $count++;
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- products -->
      <div class="row mt-5  text-center">
        <div class="col-lg-12 col-md-12 ml-3 mt-3">
          <h1 class="">
            <span style="border-bottom: 3px double;">
              PRODUCTS
            </span>
          </h1>
        </div>
      </div>
      <div class="p-3">

        <table class="table" id="products">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Product</th>
              <th>price</th>
              <th>Category</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($products)) {
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['productName'] . "</td>
              <td>" . $row['price'] . "</td>
              <td>" . $row['categoryName'] . "</td>
              <td>" . $row['description'] . "</td>
              <td class='td-actions text-right'>
                <a href='update.restaurantCategories?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                 <span style='color:white;'>
                    <i class='far fa-edit'></i>
                  </span>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleterestaurantCategory(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <span style='color:white;'>
                    <i class='fas fa-trash-alt'></i>
                  </span>
                </button>
              </td>
            </tr>";
              $count++;
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>
    <!-- /.content-wrapper -->


    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->


  <script>
    $(document).ready(function() {
      $('#sub_branches').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    $(document).ready(function() {
      $('#categories').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    $(document).ready(function() {
      $('#products').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deleteSub_branch(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
            $.ajax({
                url: 'code.deleteSub_branch',
                type: 'POST',
                data: {
                  subRestaurantId: id
                },
              })
              .done(function(response) {
                if (response == 1) {
                  Swal.fire('Deleted!', "Records deleted", "success");
                }
                if (response == 0) {
                  Swal.fire('INVALID ID!', "Something went wrong", "error");
                }
                location.reload();
              })
              .fail(function() {
                swal('Oops...', 'Something went wrong!', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }

    function deleterestaurantCategory(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
            $.ajax({
                url: 'code.deleteRestaurantCategory',
                type: 'POST',
                data: {
                  categoryID: id
                },
              })
              .done(function(response) {
                if (response == 1) {
                  Swal.fire('Deleted!', "Records deleted", "success");
                }
                if (response == 0) {
                  Swal.fire('INVALID ID!', "Something went wrong", "error");
                }
                location.reload();
              })
              .fail(function() {
                swal('Oops...', 'Something went wrong!', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }
  </script>
</body>

</html>