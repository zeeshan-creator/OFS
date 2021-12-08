<?php
include './auth/login_auth.php';
include './auth/==admin_auth.php';
include("./includes/restaurants/products/code.fetchProducts.php");

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

      <div class="row">
        <div class="col-lg-5 ml-3 mt-4 mb-2">
          <h1 class="">
            <span style="border-bottom: 3px double black;">
              Products
            </span>
          </h1>
        </div>

        <?php if ($_SESSION['role'] == 'main_branch') : ?>
          <div class="col-lg-6 ml-auto mt-4 p-4">
            <a href="./create.products" class="btn btn-primary float-right">Add Products</a>
          </div>
        <?php endif ?>

      </div>
      <div class="p-3">
        <table class="table" id="products">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Image</th>
              <th>Product</th>
              <th>Price</th>
              <th>Description</th>
              <th>category</th>
              <?php if ($_SESSION['role'] == 'main_branch') : ?>
                <th>Active Status</th>
              <?php endif ?>
              <!-- <?php if ($_SESSION['role'] == 'sub_branch') : ?>
                <th>Availability</th>
              <?php endif ?> -->
              <?php if ($_SESSION['role'] == 'main_branch') : ?>
                <th>Actions</th>
              <?php endif ?>
            </tr>
          </thead>
          <tbody class="w">
            <?php
            $count = 1;
            $feildName;
            if ($_SESSION['role'] == 'main_branch') {
              $feildName = 'active_status';
            }

            while ($row = mysqli_fetch_assoc($products)) {
              echo "<tr class='text-center'>
              <td>" . $count . " </td>
              <td style='width:10%;'><img src='includes/restaurants/products/product_imgs/" . $row['photo'] . "' class='img-fluid img-thumbnail' alt='error'></td>
              <td>" . $row['productName'] . "</td>
              <td>" . $row['price'] . "</td>
              <td>" . $row['description'] . "</td>
              <td>" . $row['categoryName'] . "</td>";

              if ($_SESSION['role'] == 'main_branch') {
                echo "<td>" . $row[$feildName] . "</td>";
                echo "<td class='td-actions text-right'>
                          <a href='update.products?productID=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                            <span style='color:white;'>
                              <i class='far fa-edit'></i>
                            </span>
                          </a>
                          <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                          s onclick='deleteproducts(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                            <span style='color:white;'>
                              <i class='fas fa-trash-alt'></i>
                            </span>
                          </button>
                        </td>
                      </tr>";
              }
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
      $('#products').DataTable({
        "order": [
          [0, "desc"]
        ]
      });
    });

    function deleteproducts(id) {
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
                url: 'code.deleteProduct',
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
  </script>
</body>

</html>