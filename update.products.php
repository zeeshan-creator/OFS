<?php

include './auth/login_auth.php';
include './auth/==sub_branch_auth.php';
include("./includes/restaurants/products/code.updateProduct.php");
include("includes/restaurants/products/code.Size.php");


if (!isset($_GET['productID'])) {
  echo '<script>window.location.href = "products";</script>';
  exit();
}

if (isset($_GET['productID'])) {
  $productID = trim($_GET['productID']);

  $product_query = "SELECT * FROM products WHERE id='$productID' LIMIT 1";
  $result = mysqli_query($conn, $product_query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Retrieve individual field value
    $name = $row["name"];
    $price = $row["price"];
    $photo = $row["photo"];
    $description = $row["description"];
    $categoryID = $row["category_id"];
    $item_availability = $row["item_availability"];
    $active_status = $row["active_status"];
  } else {
    echo '<script>window.location.href = "products";</script>';
    exit();
  }
}
ob_end_flush();

$id;
if (isset($_GET['branchId'])) {
  if ($_SESSION['role'] == 'admin') {
    $id = trim($_GET['branchId']);
  } else {
    echo '<script>window.location.href = "restaurantDetails";</script>';
    exit();
  }
} else {
  $id = $_SESSION['id'];
}

$category_query = "SELECT id,category_name FROM categories WHERE restaurant_id = " . $id;
$categories = mysqli_query($conn, $category_query);

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
            <h3 class="card-title">Edit Product</h3>
          </div>
          <div class="card-body">
            <?php include('./errors.php'); ?>
            <form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
              <div class="col-md-5 mb-3 ">
                <label for="product_image" class="d-block">Product Logo</label>
                <input type="hidden" name="oldImage" value="<?php echo $photo; ?>">
                <div class="d-flex">
                  <img src="includes/restaurants/products/product_imgs/<?php echo $photo; ?>" style="width: 100px;" class="elevation-2" id="product_image" alt="Product Image">
                  <div class="col-md-12 mb-3">
                    <input type="file" class="form-control-file ml-4 mt-4 border rounded p-1" name="newImage" accept='image/*' onchange="readURL(this)" id="newImage">
                    <div class="invalid-feedback">
                      Please select a Product product_image
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <input type="hidden" name="productID" value="<?php echo $productID; ?>">
                <div class=" col-md-6 mb-3">
                  <label for="productname">Product name</label>
                  <input type="text" class="form-control" value="<?php echo $name; ?>" name="productName" min="3" max="15" placeholder="Enter product Name" id="productname" required>
                  <div class="invalid-feedback">
                    Please enter a product name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="price">price</label>
                  <input type="number" class="form-control" value="<?php echo $price; ?>" name="price" placeholder="Enter product price" id="price" required>
                  <div class="invalid-feedback">
                    Please enter a product price
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="description">Product description</label>
                  <textarea rows="1" rows="1" type="text" class="form-control" name="description" placeholder="Enter Product description" id="description" required><?php echo $description; ?></textarea>
                  <div class="invalid-feedback">
                    Please enter a Product description
                  </div>
                </div>
                <div class="col-md-6 mb-3">
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
                <div class="col-md-6 mb-3">
                  <label for="itemavailabilitySELECT">Item availability</label>
                  <select class="form-control" id="itemavailabilitySELECT" name="item_availability" required>
                    <?php
                    if ($item_availability == "available") {
                      echo '<option value="available" selected>Available</option>
                                          <option value="not_available">not Available</option>';
                    }
                    if ($item_availability == "not_available") {
                      echo '<option value="not_available" selected>Not Available</option>
                                       <option value="available">Available</option>';
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Please enter a item availability
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="categoriesSelect">Category</label>
                  <select class="form-control" id="categoriesSelect" name="category" required>
                    <option selected disabled>Select A category</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($categories)) {
                      if ($row['id'] == $categoryID) {
                        echo "<option selected value='" . $row['id'] . "'>" . $row['category_name'] .  "</option>";
                        continue;
                      }
                      echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                      // displaying data in option menu
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Please select a category
                  </div>
                </div>
              </div>
              <button class="btn btn-primary float-right" type="submit">Save</button>
              <button class="btn btn-danger mr-3 float-right" type="button" onclick="window.history.back()">Discard</button>

              <br>
              <div class="row">
                <div class="col-lg-5 ml-3 mt-4 mb-2">
                  <h1 class="">
                    <span style="border-bottom: 3px double black;">
                      Sizes
                    </span>
                  </h1>
                </div>

                <div class="col-lg-6 ml-auto mt-4 p-4">
                  <a class="btn btn-primary float-right" data-toggle="modal" data-target="#addSizes">Add Sizes</a>
                </div>
              </div>

              <div class="p-1">
                <table class="table" id="sizes">
                  <thead>
                    <tr class="text-center">
                      <th>#</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Publish Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="w">
                    <?php
                    $count = 1;
                    $feildName;
                    if ($_SESSION['role'] == 'main_branch') {
                      $feildName = 'active_status';
                    }
                    include("./includes/restaurants/Products/code.fetchSizesToProduct.php");
                    while ($row = mysqli_fetch_assoc($sizes)) {
                      echo "<tr class='text-center'>
              <td>" . $count . " </td>
              <td>" . $row['size'] . "</td>
              <td>" . $row['price'] . "</td>
              <td>" . $row['created_at'] . "</td>
              <td class='td-actions text-right'>
                    <a href='update.sizes?sizeID=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                      <span style='color:white;'>
                        <i class='far fa-edit'></i>
                      </span>
                    </a>
                    <button type='button' rel='tooltip' id='delete-sizes' title='Delete'
                    s onclick='deletesizes(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
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

          </form>


        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->

    <!-- addSizes  -->
    <div class="modal fade" id="addSizes">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Sizes</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
              <div class="form-row">
                <div class="col-lg-12 mb-3">
                  <input type="hidden" name="action" value="addSize">
                  <input type="hidden" name="productID" value="<?php echo $_GET['productID'] ?>">
                  <label for="sizename">Size name</label>
                  <input type="text" class="form-control float-left" name="sizeName" placeholder="Enter size name" id="sizename" required>
                  <div class="invalid-feedback">
                    Please enter a size name
                  </div>
                </div>
                <div class="col-lg-12 mb-3">
                  <label for="price">Price</label>
                  <input type="text" class="form-control float-left" name="price" placeholder="Enter price" id="price" required>
                  <div class="invalid-feedback">
                    Please enter a price
                  </div>
                </div>
                <div class="col-lg-12 ">
                  <button class="btn btn-primary float-right" type="submit">ADD</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal -->

    <!-- Including footer -->
    <?php include './partials/footer.php' ?>
    <?php ob_end_flush(); ?>

  </div>
  <!-- ./wrapper -->

  <script>
    $(document).ready(function() {
      $('#sizes').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deletesizes(id) {
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
                url: 'code.deleteSize',
                type: 'POST',
                data: {
                  id: id
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

    function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function(e) {
          document.querySelector("#product_image").setAttribute("src", e.target.result);
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

    // GO BACK 
    function goBack() {
      window.history.back();
    }
  </script>


</body>

</html>