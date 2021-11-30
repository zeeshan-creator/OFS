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
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="index" class="d-block"><?php
                                        if (isset($_SESSION['name'])) {
                                          echo $_SESSION['name'];
                                        }
                                        ?></a>
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
            <a href="allsub_branches" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Sub Branches </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="restaurantCategories" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Categories </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="products" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Products </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="customers" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Customers </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="orders" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Orders </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="POS" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> POS </p>
            </a>
          </li>

        <?php endif ?>


        <!-- If the user is (sub_branch) show him/her these links -->
        <?php if ($_SESSION['role'] == 'sub_branch') : ?>

          <li class="nav-item">
            <a href="products" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p> Products </p>
            </a>
          </li>

        <?php endif ?>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>