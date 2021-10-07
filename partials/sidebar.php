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
      <li class="
        <?php
        echo $activeNav;
        ?>
      ">
        <a href="./index">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="
        <?php
        echo $activeNav;
        ?>
      ">
        <a href="./allbranches">
          <i class="tim-icons icon-chart-pie-36"></i>
          <p>Branches</p>
        </a>
      </li>
    </ul>
  </div>
</div>