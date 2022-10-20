<header>
  <!-- Header desktop -->
  <div class="container-menu-desktop">
    <div class="topbar">
      <div class="content-topbar container h-100">
        <div class="left-topbar">
          <span class="left-topbar-item flex-wr-s-c">
            <span class="address"></span>&nbsp;|
            <span class="pl-1">
              {{ date("l\, jS F Y") }}
            </span>            
          </span>

          <a href="{{ route('article.about') }}" class="left-topbar-item">
            About
          </a>

          <a href="{{ route('article.contact') }}" class="left-topbar-item">
            Contact
          </a>
        </div>

        <div class="right-topbar">
          <a href="#">
            <span class="fab fa-facebook-f"></span>
          </a>

          <a href="#">
            <span class="fab fa-twitter"></span>
          </a>

          <a href="#">
            <span class="fab fa-pinterest-p"></span>
          </a>

          <a href="#">
            <span class="fab fa-vimeo-v"></span>
          </a>

          <a href="#">
            <span class="fab fa-youtube"></span>
          </a>
        </div>
      </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
      <!-- Logo moblie -->
      <div class="logo-mobile">
        <a href="{{ route('article.index') }}"><img src="{{ asset('posting/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
      </div>

      <!-- Button show menu -->
      <div class="btn-show-menu-mobile hamburger hamburger--squeeze m-r--8">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
      <ul class="topbar-mobile">
        <li class="left-topbar">
          <span class="left-topbar-item flex-wr-s-c">
            <span class="address2"></span>&nbsp;|
            <span class="pl-1">
              {{ date("l\, jS F Y") }}
            </span> 
          </span>
        </li>

        <li class="left-topbar">
          <a href="#" class="left-topbar-item">
            About
          </a>

          <a href="#" class="left-topbar-item">
            Contact
          </a>
        </li>

        <li class="right-topbar">
          <a href="#">
            <span class="fab fa-facebook-f"></span>
          </a>

          <a href="#">
            <span class="fab fa-twitter"></span>
          </a>

          <a href="#">
            <span class="fab fa-pinterest-p"></span>
          </a>

          <a href="#">
            <span class="fab fa-vimeo-v"></span>
          </a>

          <a href="#">
            <span class="fab fa-youtube"></span>
          </a>
        </li>
      </ul>

      <ul class="main-menu-m">
        <li>
          <a href="{{ route('article.index') }}">Home</a>
        </li>

        @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
        <li>
          <a href="{{ route('article.category', [$category['slug']]) }}">{{ $category['name'] }}</a>
          <ul class="sub-menu-m">
            @foreach (App\Models\SubCategory::where('category_id', $category['id'])->get() as $subcategory)
            <li><a href="{{ route('article.subcategory', [$subcategory['id']]) }}">{{ $subcategory['subname'] }}</a></li>
            @endforeach
          </ul>

          <span class="arrow-main-menu-m">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
          </span>
        </li>
        @endforeach
      </ul>
    </div>

    <!--  -->
    <div class="wrap-logo no-banner container">
      <!-- Logo desktop -->
      <div class="logo">
        <a href="{{ route('article.index') }}"><img src="{{ asset('posting/images/icons/logo-01.png') }}" alt="LOGO"></a>
      </div>
    </div>

    <!--  -->
    <div class="wrap-main-nav">
      <div class="main-nav">
        <!-- Menu desktop -->
        <nav class="menu-desktop">
          <a class="logo-stick" href="{{ route('article.index') }}">
            <img src="{{ asset('posting/images/icons/logo-01.png') }}" alt="LOGO">
          </a>

          <ul class="main-menu justify-content-center">
            <li class="{{ (isset($title) && $title == 'Home') ? 'main-menu-active' : 'main-menu' }}">
              <a href="{{ route('article.index') }}">Home</a>
            </li>
            @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
            <li class="main-menu">
              <a href="{{ route('article.category', [$category['slug']]) }}">{{ $category['name'] }}</a>
              <ul class="sub-menu">
                @foreach (App\Models\SubCategory::where('category_id', $category['id'])->orderBy('subname', 'asc')->get() as $subcategory)
                <li><a href="{{ route('article.subcategory', [$subcategory['id']]) }}">{{ $subcategory['subname'] }}</a></li>
                @endforeach
              </ul>
            </li>
            @endforeach
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>