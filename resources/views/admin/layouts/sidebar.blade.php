<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('template/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('image/profile/' . auth()->user()->image) }}" class="img-circle elevation-2"
          alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ ucwords(auth()->user()->name) }}</a>
      </div>
    </div>

    <!-- Dev Sidebar Menu -->
    @if (strtolower(auth()->user()->getRole['name']) === 'developer')
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @php
            $checkCat = App\Models\Submenus::where('title', $title)->first();
            $data = '';
            if (count(App\Models\Submenus::where('title', $title)->get()) > 0) {
                $data = $checkCat['menu_id'];
            }
            $menus = App\Models\Menu::orderBy('id', 'asc')->get();
          @endphp
          @foreach ($menus as $menu)
            <li
              class="nav-item {{ count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0 ? 'has-treeview' : '' }}{{ $data == $menu['id'] ? ' menu-open' : '' }}">
              <a href="{{ $menu['route'] == 'none' ? '#' : route("$menu->route") }}"
                class="nav-link {{ $data == $menu['id'] || $menu['menu'] == $title ? 'active' : '' }}">
                <i class="nav-icon {{ $menu['icon'] }}"></i>
                <p>
                  {{ $menu['menu'] }}
                  @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                    <i class="fas fa-angle-left right"></i>
                  @endif
                </p>
              </a>

              @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                <ul class="nav nav-treeview">
                  @php
                    $availables = App\Models\Submenus::where('title', 'like', '%view ' . $menu['menu'] . '%')
                        ->orWhere('title', 'like', $menu['menu'] . ' view%')
                        ->get();
                  @endphp
                  @foreach ($availables as $available)
                    <li class="nav-item">
                      <a href="{{ route("$available->route") }}"
                        class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          {{ ucwords($available['title']) }}
                          <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                        </p>
                      </a>
                    </li>
                  @endforeach
                  @php
                    $availables = App\Models\Submenus::where('title', 'like', '%create ' . $menu['menu'] . '%')
                        ->orWhere('title', 'like', $menu['menu'] . ' create%')
                        ->get();
                  @endphp
                  @foreach ($availables as $available)
                    <li class="nav-item">
                      <a href="{{ route("$available->route") }}"
                        class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          {{ ucwords($available['title']) }}
                          <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                        </p>
                      </a>
                    </li>
                  @endforeach
                  @php
                    $availables = App\Models\Submenus::where('title', 'like', '%trash ' . $menu['menu'] . '%')
                        ->orWhere('title', 'like', $menu['menu'] . ' trash%')
                        ->get();
                  @endphp
                  @foreach ($availables as $available)
                    <li class="nav-item">
                      <a href="{{ route("$available->route") }}"
                        class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          {{ ucwords($available['title']) }}
                          <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                        </p>
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </nav>
    @else
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @php
            $checkCat = App\Models\Submenus::where('title', $title)->first();
            $data = '';
            if (count(App\Models\Submenus::where('title', $title)->get()) > 0) {
                $data = $checkCat['menu_id'];
            }
          @endphp
          <!-- menu item -->
          @foreach (App\Models\Permission::where('role_id', auth()->user()->role_id)->get() as $permission)
            @php
              $menu_id = explode(',', $permission['menu_id']);
              $menus = App\Models\Menu::whereIn('id', $menu_id)->get();
            @endphp
            @foreach ($menus as $menu)
              <li
                class="nav-item {{ count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0 ? 'has-treeview' : '' }}{{ $data == $menu['id'] ? ' menu-open' : '' }}">
                <a href="{{ $menu['route'] == 'none' ? '#' : route("$menu->route") }}"
                  class="nav-link {{ $data == $menu['id'] || $menu['menu'] == $title ? 'active' : '' }}">
                  <i class="nav-icon {{ $menu['icon'] }}"></i>
                  <p>
                    {{ $menu['menu'] }}
                    @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                      <i class="fas fa-angle-left right"></i>
                    @endif
                  </p>
                </a>
                @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                  <ul class="nav nav-treeview">
                    @if (isset($permission['name'][$menu['id']]['view']))
                      @php
                        $availables = App\Models\Submenus::where('title', 'like', '%view ' . $menu['menu'] . '%')
                            ->orWhere('title', 'like', $menu['menu'] . ' view%')
                            ->get();
                      @endphp
                      @foreach ($availables as $available)
                        <li class="nav-item">
                          <a href="{{ route("$available->route") }}"
                            class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                              {{ ucwords($available['title']) }}
                              <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                            </p>
                          </a>
                        </li>
                      @endforeach
                    @endif
                    @if (isset($permission['name'][$menu['id']]['create']))
                      @php
                        $availables = App\Models\Submenus::where('title', 'like', '%create ' . $menu['menu'] . '%')
                            ->orWhere('title', 'like', $menu['menu'] . ' create%')
                            ->get();
                      @endphp
                      @foreach ($availables as $available)
                        <li class="nav-item">
                          <a href="{{ route("$available->route") }}"
                            class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                              {{ ucwords($available['title']) }}
                              <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                            </p>
                          </a>
                        </li>
                      @endforeach
                    @endif
                    @if (isset($permission['name'][$menu['id']]['trash']))
                      @php
                        $availables = App\Models\Submenus::where('title', 'like', '%trash ' . $menu['menu'] . '%')
                            ->orWhere('title', 'like', $menu['menu'] . ' trash%')
                            ->get();
                      @endphp
                      @foreach ($availables as $available)
                        <li class="nav-item">
                          <a href="{{ route("$available->route") }}"
                            class="nav-link {{ strtolower($available['title']) == strtolower($title) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                              {{ ucwords($available['title']) }}
                              <span class="right"><i class="{{ $available['icon'] }}"></i></span>
                            </p>
                          </a>
                        </li>
                      @endforeach
                    @endif
                  </ul>
                @endif
              </li>
            @endforeach
          @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    @endif

    <!-- test debug -->
    {{-- <div class="container">
      @php
        $checkCat = App\Models\Submenus::where('title', $title)->first();
        $data = '';
        if (count(App\Models\Submenus::where('title', $title)->get()) > 0) {
            $data = $checkCat['menu_id'];
        }
        $menus = App\Models\Menu::orderBy('id', 'asc')->get();
      @endphp
      @foreach ($menus as $menu)
        <ul class="text-white">
          <li>
            <div>{{ $menu['menu'] }}</div>
            <ul>
              @php
                $availables = App\Models\Submenus::where('title', 'like', '%view ' . $menu['menu'] . '%')
                    ->orWhere('title', 'like', $menu['menu'] . 'view%')
                    ->get();
              @endphp
              @foreach ($availables as $available)
                <li>{{ ucwords($available['title']) }}</li>
              @endforeach
              @php
                $availables = App\Models\Submenus::where('title', 'like', '%create ' . $menu['menu'] . '%')
                    ->orWhere('title', 'like', $menu['menu'] . 'create%')
                    ->get();
              @endphp
              @foreach ($availables as $available)
                <li>{{ ucwords($available['title']) }}</li>
              @endforeach
            </ul>
          </li>
        </ul>
      @endforeach
    </div> --}}

  </div>
  <!-- /.sidebar -->
</aside>
