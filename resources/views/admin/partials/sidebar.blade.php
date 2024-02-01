  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <?php
      $menus = [
        'dashboard' => [
          'url' => route('admin.dashboard'),
          'active-by' => 'dashboard',
          'icon' => 'fa fa-chart-line'
        ],
        'user' => [
          'url' => route('admin.user.index'),
          'active-by' => 'user',
          'icon' => 'fa fa-user-circle'
        ],
        'capital' => [
          'icon' => 'fa fa-store',
          'sub-menu' => [
            'category' => [
              'url' => route('admin.category.index'),
              'active-by' => 'category'
            ],
            'product' => [
              'url' => route('admin.product.index'),
              'active-by' => 'product'
            ],
          ]
        ]
      ];
      ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          @foreach ($menus as $label => $item)
          <?php $hasSubMenu = array_key_exists('sub-menu', $item); ?>
          <li class="nav-item">
            <a href="{{ !$hasSubMenu ? $item['url'] : '#' }}" @class(['nav-link', 'active' => (!$hasSubMenu && is_int(strpos(url()->current(),$item['active-by'])))])>
              <i class="nav-icon {{ $item['icon'] }}"></i>
              <p>
                {{ ucwords($label) }}
                @if($hasSubMenu)
                <i class="right fas fa-angle-left"></i>
                @endif
              </p>
            </a>
            @if ($hasSubMenu)
            <ul class="nav nav-treeview">
              @foreach ($item['sub-menu'] as $subMenuLabel => $subMenu)
              <li class="nav-item">
                <a href="{{ $subMenu['url'] }}" @class(['nav-link', 'active' => (!$hasSubMenu && is_int(strpos(url()->current(),$subMenu['active-by'])))])>
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ ucwords($subMenuLabel) }}</p>
                </a>
              </li>
              @endforeach
            </ul>
            @endif
          </li>
          @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>