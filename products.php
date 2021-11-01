<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';

include("./includes/restaurants/products/code.fetchProducts.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including header -->
<?php include './partials/head.php' ?>
<style>
   #products_filter,
   #products_filter input,
   #products_length,
   #products_length select,

   #products_info,
   #products_paginate a {
      color: white !important;
   }

   #products_paginate span a,
   #products_length select option {
      color: black !important;
   }

   tbody tr {
      background: none !important;
   }
</style>

<body class="" style="color: white">
   <div class="wrapper">
      <?php
      // $activeNav = "active";
      ?>
      <!-- Including sidebar -->
      <?php include './partials/sidebar.php' ?>

      <div class="main-panel">
         <!-- Navbar -->
         <!-- Including nav -->

         <?php include './partials/nav.php' ?>
         <!-- End Navbar -->
         <div class="content">
            <div class="row">
               <div class="col-lg-3 col-md-3">
                  <a href="./create.products" class="btn btn-primary mb-3">Add Product</a>
               </div>
            </div>
            <table class="table" id="products">
               <thead>
                  <tr class="text-center">
                     <th>#</th>
                     <th>Product</th>
                     <th>Price</th>
                     <th>Description</th>
                     <th>category</th>
                     <th>Publish</th>
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
               <!-- <button type='button' rel='tooltip' title='Details' class='btn btn-info btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-single-02'></i>
                </button> -->
                <a href='update.products?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-settings'></i>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleteproducts(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-simple-remove'></i>
                </button>
              </td>
            </tr>";
                     $count++;
                  }
                  ?>
               </tbody>
            </table>
         </div>

         <!-- Including footer -->
         <?php include './partials/footer.php' ?>

      </div>
   </div>
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