<div class="sidebar">
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $navLi = $('li');

        $('li').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
        })

      })
    });
  </script>
  <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="javascript:void(0)" class="simple-text logo-mini">
        CT
      </a>
      <a href="javascript:void(0)" class="simple-text logo-normal">
        Creative Tim
      </a>
    </div>
    <ul class="nav">
      <li class="active">
        <a href="./index.php">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a href="./icons.php">
          <i class="tim-icons icon-atom"></i>
          <p>Icons</p>
        </a>
      </li>
      <li>
        <a href="./maps.php">
          <i class="tim-icons icon-pin"></i>
          <p>Maps</p>
        </a>
      </li>
      <li>
        <a href="./notifications.php">
          <i class="tim-icons icon-bell-55"></i>
          <p>Notifications</p>
        </a>
      </li>
      <li>
        <a href="./user.php">
          <i class="tim-icons icon-single-02"></i>
          <p>User Profile</p>
        </a>
      </li>
      <li>
        <a href="./tables.php">
          <i class="tim-icons icon-puzzle-10"></i>
          <p>Table List</p>
        </a>
      </li>
      <li>
        <a href="./typography.php">
          <i class="tim-icons icon-align-center"></i>
          <p>Typography</p>
        </a>
      </li>
    </ul>
  </div>
</div>