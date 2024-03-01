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
          'icon' => 'fa fa-chart-line',
          'show' => true
        ],
        'user' => [
          'url' => route('admin.user.index'),
          'icon' => 'fa fa-user-circle',
          'show' => isAdmin()
        ],
        'capital' => [
          'icon' => 'fa fa-store',
          'show' => true,
          'url' => '#',
          'sub-menu' => [
            'category' => [
              'url' => route('admin.category.index'),
              'show' => isAdmin()
            ],
            'product' => [
              'url' => route('admin.product.index'),
              'show' => true
            ],
          ]
        ]
      ];
      ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <?php $current_url = url()->current(); ?>
          @foreach ($menus as $label => $item)
            @unless ($item['show'])
              @continue
            @endunless
          <?php $subMenus = array_key_exists('sub-menu', $item) ? array_column($item['sub-menu'],'url') : [];?>
          <li class="nav-item">
            <a href="{{ $item['url'] }}" @class(['nav-link', 'active' => ($current_url == $item['url'] || in_array($current_url, $subMenus))])>
              <i class="nav-icon {{ $item['icon'] }}"></i>
              <p>
                {{ ucwords($label) }}
                @if($subMenus)
                <i class="right fas fa-angle-left"></i>
                @endif
              </p>
            </a>
            @if ($subMenus)
              @unless ($item['show'])
                @continue
              @endunless
            <ul class="nav nav-treeview">
              @foreach ($item['sub-menu'] as $subMenuLabel => $subMenu)
              <li class="nav-item">
                <a href="{{ $subMenu['url'] }}" @class(['nav-link', 'active' => ($current_url == $subMenu['url'])])>
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