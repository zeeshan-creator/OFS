<?php
include './auth/login_auth.php';
include './auth/!=main_branch_auth.php';

include("./includes/restaurants/categories/code.fetchCategories.php");

?>

<!DOCTYPE html>
<html lang="en">

<!-- Including header -->
<?php include './partials/head.php' ?>
<style>
   #restaurantCategories_filter,
   #restaurantCategories_filter input,
   #restaurantCategories_length,
   #restaurantCategories_length select,

   #restaurantCategories_info,
   #restaurantCategories_paginate a {
      color: white !important;
   }

   #restaurantCategories_paginate span a,
   #restaurantCategories_length select option {
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
                  <a href="./create.restaurantsCategory" class="btn btn-primary mb-3">Create Category</a>
               </div>
            </div>
            <table class="table" id="restaurantCategories">
               <thead>
                  <tr class="text-center">
                     <th>#</th>
                     <th>Category</th>
                     <th>Description</th>
                     <th>Created at</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $count = 1;
                  while ($row = mysqli_fetch_assoc($results)) {
                     echo "<tr class='text-center'>
              <td class='text-center'>" . $count . " </td>
              <td>" . $row['category_name'] . "</td>
              <td>" . $row['category_desc'] . "</td>
              <td>" . $row['created_at'] . "</td>
              <td class='td-actions text-right'>
               <!-- <button type='button' rel='tooltip' title='Details' class='btn btn-info btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-single-02'></i>
                </button> -->
                <a href='update.restaurantCategories?id=" . $row['id'] . "' type='button' rel='tooltip' title='Edit' class='btn btn-success btn-link btn-icon btn-sm'>
                  <i class='tim-icons icon-settings'></i>
                </a>
                <button type='button' rel='tooltip' id='delete-restaurant' title='Delete'
                s onclick='deleterestaurantCategory(" . $row['id'] . ")' class='btn btn-danger btn-link btn-icon btn-sm'>
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
         $('#restaurantCategories').DataTable({
            "order": [
               [0, "desc"]
            ]
         });
      });

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