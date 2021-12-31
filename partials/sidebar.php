<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">OFS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
        if ($_SESSION['role'] == 'admin') {
          echo '<img src="docs/assets/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">';
          goto exiit;
        }

        if ($_SESSION['role'] == 'main_branch') {
          $query = "SELECT logo,name FROM `restaurants` WHERE `id`= " . $_SESSION['id'];
        }

        if ($_SESSION['role'] == 'sub_branch') {
          $query = "SELECT * FROM `sub_restaurants` where id= " . $_SESSION['id'];
          $results = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($results);
          $query = "SELECT logo,name FROM `restaurants` WHERE `id`= " . $row['main_branch'];
        }

        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);

        if ($row['logo'] == '' && $row['logo'] == null) {
          echo '<img src="docs/assets/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">';
        }
        if ($row['logo'] != '' && $row['logo'] != null) {
          echo ' <img src="includes/restaurants/logos/' . $row['logo'] . '" class="img-circle elevation-2" alt="User Image">';
        }
        exiit:
        ?>
      </div>
      <div class="info">
        <a href="index" class="d-block">
          <?php
          if ($_SESSION['role'] == 'admin') {
            $query = "SELECT name FROM `admin` WHERE `id`= " . $_SESSION['id'];
          }
          if ($_SESSION['role'] == 'main_branch') {
            $query = "SELECT name FROM `restaurants` WHERE `id`= " . $_SESSION['id'];
          }
          if ($_SESSION['role'] == 'sub_branch') {
            $query = "SELECT name FROM `sub_restaurants` WHERE `id`= " . $_SESSION['id'];
          }

          $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          $row = mysqli_fetch_assoc($result);

          if ($row['name'] != '' && $row['name'] != null) {
            echo $row['name'];
          } else {
            echo 'NO NAME';
          }
          ?>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- If the user is admin show him/her these links -->
        <?php if ($_SESSION['role'] == 'admin') : ?>

          <li class="nav-item">
            <a href="allrestaurants" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Restaurants </p>
            </a>
          </li>

        <?php endif ?>

        <!-- If the user is restaurant(main_branch) show him/her these links -->
        <?php if ($_SESSION['role'] == 'main_branch') : ?>


          <li class="nav-item">
            <a href="index" class="nav-link">
              <i class="nav-icon fad fa-chart-line"></i>
              <p> Dashboard </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="allsub_branches" class="nav-link">
              <i class="nav-icon fad fa-code-branch"></i>
              <p> Sub Branches </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="orders" class="nav-link">
              <i class="nav-icon fad fa-arrow-to-left"></i>
              <p> Orders </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="POS" class="nav-link">
              <i class="nav-icon fas fa-stream "></i>
              <p> Point Of Sale </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fad fa-chart-pie"></i>
              <p>
                Catalogues
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              </ul>
          </li> -->

          <li class="nav-item">
            <a href="sizes" class="nav-link">
              <i class="nav-icon fad fa-sort-amount-up-alt"></i>
              <p> Sizes </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="restaurantCategories" class="nav-link">
              <i class="nav-icon fad fa-th"></i>
              <p> Categories </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="products" class="nav-link">
              <i class="nav-icon fad fa-burger-soda"></i>
              <p> Products </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="addon_products" class="nav-link">
              <i class="nav-icon fad fa-plus"></i>
              <p> Addon Products </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="deals" class="nav-link">
              <i class="nav-icon fad fa-utensils"></i>
              <p> Deals </p>
            </a>
          </li>

          <li class=" nav-item">
            <a href="offers" class="nav-link">
              <i class="nav-icon fad fa-gift"></i>
              <p> Offers </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="customers" class="nav-link">
              <i class="nav-icon fad fa-user-tie"></i>
              <p> Customers </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="social_media_links" class="nav-link">
              <i class="nav-icon fab fa-facebook"></i>
              <p> Social Media Links</p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fad fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            </ul>
          </li> -->

          <li class="nav-item">
            <a href="settings" class="nav-link">
              <i class="nav-icon fad fa-user-circle"></i>
              <p> Profile </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="delivery_setting" class="nav-link">
              <i class="nav-icon fad fa-biking-mountain"></i>
              <p> Delivery Setting </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="restaurant_timing" class="nav-link">
              <i class="nav-icon fad fa-clock"></i>
              <p> Restaurant Timing </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="branchSettings" class="nav-link">
              <i class="nav-icon fad fa-sliders-h"></i>
              <p> Branch Setting </p>
            </a>
          </li>

          <li class="nav-item">
            <a target="_blank" href="order_now?id=<?php echo $_SESSION['id'] ?>" class="nav-link">
              <i class="nav-icon fad fa-sliders-h"></i>
              <p> Order Now </p>
            </a>
          </li>


        <?php endif ?>

        <!-- If the user is (sub_branch) show him/her these links -->
        <?php if ($_SESSION['role'] == 'sub_branch') : ?>

          <li class="nav-item">
            <a href="products" class="nav-link">
              <i class="nav-icon fad fa-burger-soda"></i>
              <p> Products </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="deals" class="nav-link">
              <i class="nav-icon fad fa-utensils"></i>
              <p> Deals </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="POS" class="nav-link">
              <i class="nav-icon fas fa-stream "></i>
              <p> POS </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="Orders" class="nav-link">
              <i class="nav-icon fad fa-arrow-to-left"></i>
              <p> Orders </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="branchSettings" class="nav-link">
              <i class="nav-icon fad fa-sliders-h"></i>
              <p> Branch Setting </p>
            </a>
          </li>

        <?php endif ?>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>