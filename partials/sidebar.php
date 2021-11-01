<div class="sidebar">
  <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a class="simple-text logo-normal ml-5">
        Dashboard
      </a>
    </div>
    <ul class="nav">
      <li class="">
        <a href="index">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- If the user is admin show him/her these links -->
      <?php if ($_SESSION['role'] == 'admin') : ?>
        <li class="">
          <a href="allrestaurants">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>Restaurants</p>
          </a>
        </li>
        <li class="">
          <a href="allsub_branches">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>Sub Branches</p>
          </a>
        </li>
      <?php endif ?>

      <!-- If the user is restaurant(main_branch) show him/her these links -->
      <?php if ($_SESSION['role'] == 'main_branch') : ?>
        <li class="">
          <a href="allsub_branches">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>Sub Branches</p>
          </a>
        </li>
        <li class="">
          <a href="restaurantCategories">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>Categories</p>
          </a>
        </li>
        <li class="">
          <a href="products">
            <i class="tim-icons icon-chart-pie-36"></i>
            <p>Products</p>
          </a>
        </li>
      <?php endif ?>
    </ul>
  </div>
</div>