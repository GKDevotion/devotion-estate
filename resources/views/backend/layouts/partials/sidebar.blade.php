 <!-- sidebar menu area start -->
 @php
    $usr = Auth::guard('admin')->user();
    $adminMenuArr = getAdminSideMenu();
    //Cache::remember('adminMenuArr', 60, function () {
    //    return getAdminSideMenu();
    //});
 @endphp

<style>
    /* === SIDEBAR BASE === */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 260px;
      background: #fff;
      color: #ab8134;
      transition: all 0.3s ease;
      z-index: 1000;
      overflow-y: auto;
    }

    .sidebar.collapsed { width: 70px; }

    .sidebar .logo {
      text-align: center;
      padding: 15px 0;
    }

    .sidebar .logo img {
      max-width: 140px;
      transition: all 0.3s;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      color: #ab8134;
      padding: 12px 20px;
      text-decoration: none;
      font-size: 15px;
      transition: 0.3s;
    }

    .sidebar ul li a:hover {
      background: #ab8134;
      border-radius: 6px;
    }

    /* === SUBMENU === */
    .sidebar ul ul {
      padding-left: 20px;
      display: none;
    }

    .sidebar ul li.open > ul {
      display: block;
    }

    .sidebar ul ul li a {
      font-size: 14px;
      padding: 10px 20px;
    }

    /* === MAIN CONTENT === */
    .main-content {
      /* margin-left: 260px; */
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    /* === TOGGLE BUTTON (Mobile Only) === */
    .toggle-btn {
      position: fixed;
      top: 15px;
      left: 20px;
      font-size: 26px;
      color: #ab8134;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      z-index: 1100;
      display: none; /* hide by default */
    }

    /* === MOBILE BEHAVIOR === */
    @media (max-width: 992px) {
      .sidebar {
        left: -260px;
      }
      .sidebar.active {
        left: 260px;
      }
      .main-content {
        margin-left: 0 !important;
      }

      .toggle-btn {
        display: block; /* show only on tablet/mobile */
      }

      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 900;
      }

      .overlay.active {
        display: block;
      }
    }
  </style>

<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{url('public/img/devotion-trusted-real-estate.png')}}" />
    </div>
    <ul class="metismenu" id="menu">
        @foreach ($adminMenuArr as $menu)

            @if( $menu->childArr->isEmpty() || $menu->class_name != "/" )
                @if ( $usr->can( $menu->group_name.'.view' ) )
                    <li class="{{ Route::is( 'admin.dashboard' ) ? 'active' : '' }}">
                        <a href="{{ route( 'admin.dashboard' ) }}">
                            <i class="ti-dashboard"></i>
                            <span>{{$menu->name}}</span>
                        </a>
                    </li>
                @endif
            @elseif( !$menu->childArr->isEmpty() || $menu->class_name == "/" )

                @php
                    $parentArr = [];

                    foreach ($menu->childArr as $cmenu){
                        $parents = [
                            'admin.'.$cmenu->group_name.'.index',
                            'admin.'.$cmenu->group_name.'.view',
                            'admin.'.$cmenu->group_name.'.edit',
                            'admin.'.$cmenu->group_name.'.create'
                        ];

                        $parentArr[] = $parents;
                    }

                    $isActive = "";
                    if( in_array( Route::currentRouteName(), $parentArr ) ){
                        $isActive = "active";
                    }
                @endphp

                <li class="{{$menu->slug}}">
                    <a href="javascript:void(0)" aria-expanded="true">
                        <i class="{{$menu->icon}}"></i>
                        <span> {{$menu->name}} </span>
                    </a>

                    <ul class="collapse {{Route::currentRouteName()}}">
                        <?php
                        $count = 0;
                        ?>
                        @foreach ($menu->childArr as $cmenu)
                                @if ($usr->can($cmenu->group_name.'.view'))
                                <li class="{{ Route::is('admin.'.$cmenu->group_name.'.index') || Route::is('admin.'.$cmenu->group_name.'.edit') ? 'active' : '' }}">
                                    <a href="{{ route('admin.'.$cmenu->group_name.'.index') }}">
                                        <i class="{{$cmenu->icon}}"></i>
                                        <span>{{$cmenu->name}}</span>
                                    </a>
                                </li>
                                <?php
                                    $count++;
                                ?>
                            @endif
                        @endforeach

                        <?php
                            if( $count == 0 ){
                                echo '<script>$(".'.$menu->slug.'").remove();</script>';
                            }
                        ?>
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<!-- sidebar menu area end -->

<!-- Toggle Button -->
<div class="toggle-btn" id="toggleBtn"><i class="bi bi-list"></i></div>

<!-- Overlay (for mobile) -->
<div class="overlay" id="overlay"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleBtn');
    const overlay = document.getElementById('overlay');

    // Sidebar toggle (desktop/mobile)
    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth <= 992) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
        }
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    // Multilevel menu toggle
    document.querySelectorAll('.dropdown-toggle').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const parentLi = link.parentElement;
            parentLi.classList.toggle('open');
        });
    });
</script>
