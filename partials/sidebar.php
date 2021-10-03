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
      <a href="" class="simple-text logo-normal ml-5">
        Dashboard
      </a>
    </div>
    <ul class="nav">
      <li class="active">
        <a href="./index">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a href="./icons">
          <i class="tim-icons icon-atom"></i>
          <p>Icons</p>
        </a>
      </li>
      <li>
        <a href="./maps">
          <i class="tim-icons icon-pin"></i>
          <p>Maps</p>
        </a>
      </li>
      <li>
        <a href="./notifications">
          <i class="tim-icons icon-bell-55"></i>
          <p>Notifications</p>
        </a>
      </li>
      <li>
        <a href="./user">
          <i class="tim-icons icon-single-02"></i>
          <p>User Profile</p>
        </a>
      </li>
      <li>
        <a href="./tables">
          <i class="tim-icons icon-puzzle-10"></i>
          <p>Table List</p>
        </a>
      </li>
      <li>
        <a href="./typography">
          <i class="tim-icons icon-align-center"></i>
          <p>Typography</p>
        </a>
      </li>
    </ul>
  </div>
</div>