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
      <div class="row text-center">
        <div class="col-lg-12 col-md-12 ml-3 mt-3">
          <h1 class="">
            <span style="border-bottom: 3px double;">
              Products
            </span>
          </h1>
        </div>
        <div class=" ml-auto mt-3">
          <a href="./create.products" class="btn btn-primary mb-3 mr-4">Create Products</a>
        </div>
      </div>
      <div class="p-3">
        <table class="table" id="products">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Product</th>
              <th>Price</th>
              <th>Description</th>
              <th>category</th>
              <th>Publish Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($results)) {
              echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['productName'] . "</td>
              <td>" . $row['price'] . "</td>
              <td>" . $row['description'] . "</td>
              <td>" . $row['categoryName'] . "</td>
              <td>" . $row['created_at'] . "</td>
              <td class='td-actions text-right'>
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
                  productID: id
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