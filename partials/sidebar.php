<div class="sidebar">
  <div class="opac" style="width: 100%; height:100%;">
  </div>
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
      <?php
      if ($_SESSION['role'] == 'admin') {
        echo '<li class="">
        <a href="allrestaurants">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>restaurants</p>
        </a>
      </li>';
      }
      ?>

    </ul>
  </div>
</div>