@extends('bloging.layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container">
  <div class="bg0 flex-wr-sb-c p-rl-20 p-tb-8">
    <div class="f2-s-1 p-r-30 size-w-0 m-tb-6 flex-wr-s-c">
      <span class="text-uppercase cl2 p-r-8">
        Trending Now:
      </span>

      <span class="dis-inline-block cl6 slide100-txt pos-relative size-w-0" data-in="fadeInDown" data-out="fadeOutDown">
        @foreach (App\Models\Post::orderBy('views', 'desc')->limit('4')->get() as $post)
        <span class="dis-inline-block slide100-txt-item animated visible-false">
          {{ substr($post['title'], 0, 70) }}...
        </span>
        @endforeach
      </span>
    </div>

    <form action="{{ route('article.search') }}" method="GET">
      <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
        <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Search">
        <button type="submit" class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
          <i class="zmdi zmdi-search"></i>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Feature post -->
<section class="bg0">
  <div class="container">
    <div class="row m-rl--1">
      @foreach (App\Models\Post::orderBy('created_at', 'desc')->limit(6)->get() as $post)
      <div class="col-sm-6 col-lg-4 p-rl-1 p-b-2">
        <div class="bg-img1 size-a-12 how1 pos-relative"
          style="background-image: url({{ asset('image/post-image/' . $post['image']) }});">
          <a href="{{ route('article.view', [$post['slug']]) }}" class="dis-block how1-child1 trans-03"></a>

          <div class="flex-col-e-s s-full p-rl-25 p-tb-11">
            <a href="{{ route('article.category', [$post->getCategory['slug']]) }}"
              class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
              {{ $post->getCategory['name'] }}
            </a>

            <h3 class="how1-child2 m-t-10">
              <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-m-1 cl0 hov-cl10 trans-03">
                {{ $post['title'] }}
              </a>
            </h3>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>

<!-- Post -->
<section class="bg0 p-t-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="p-b-20">
          <!-- Computer -->
          <div class="p-b-20">
            <div class="how2 how2-cl1 flex-sb-c m-r-10 m-r-0-sr991">
              <h3 class="f1-m-2 cl12 tab01-title">
                Computer
              </h3>


              <a href="{{ url('blog/article/category/computer') }}" class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                View all
                <i class="fs-12 m-l-5 fa fa-caret-right"></i>
              </a>
            </div>

            <div class="row p-t-35">
              <div class="col-sm-6 p-r-25 p-r-15-sr991">
                <!-- Item post -->
                @foreach (App\Models\Post::where('category_id', 1)->orderBy('created_at', 'desc')->limit(1)->get() as $post)
                <div class="m-b-30">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="wrap-pic-w hov1 trans-03">
                    <img src="{{ asset('image/post-image/' . $post['image']) }}" alt="IMG">
                  </a>

                  <div class="p-t-20">
                    <h5 class="p-b-5">
                      <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                        {{ $post['title'] }}
                      </a>
                    </h5>

                    <span class="cl8">
                      <a href="{{ route('article.subcategory', [$post['sub_category_id']]) }}" class="f1-s-4 cl8 hov-cl10 trans-03">
                        {{ $post->getSubcategory['subname'] }}
                      </a>

                      <span class="f1-s-3 m-rl-3">
                        -
                      </span>

                      <span class="f1-s-3">
                        @php
                          $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                          echo date_format($date, "D, d M Y");
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>                  
                @endforeach
              </div>

              <div class="col-sm-6 p-r-25 p-r-15-sr991">
                @foreach (App\Models\Post::where('category_id', 1)->orderBy('created_at', 'desc')->offset(1)->limit(3)->get() as $post)
                <!-- Item post -->
                <div class="flex-wr-sb-s m-b-30">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="size-w-1 wrap-pic-w hov1 trans-03">
                    <img src="{{ asset('image/post-image/' . $post['image']) }}"
                      alt="{{ $post['image'] }}">
                  </a>

                  <div class="size-w-2">
                    <h5 class="p-b-5">
                      <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-s-5 cl3 hov-cl10 trans-03">
                        {{ ucfirst($post['title']) }}
                      </a>
                    </h5>

                    <span class="cl8">
                      <a href="{{ route('article.subcategory', [$post['sub_category_id']]) }}" class="f1-s-6 cl8 hov-cl10 trans-03">
                        {{ $post->getSubcategory['subname'] }}
                      </a>

                      <span class="f1-s-3 m-rl-3">
                        -
                      </span>

                      <span class="f1-s-3">
                        @php
                          $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                          echo date_format($date, "D, d M Y");
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Gadget and tablet -->
          <div class="row">
            @foreach (App\Models\Category::whereNotIn('id', [1, 6])->get() as $category)
            <!-- item -->
            <div class="col-sm-6 p-r-25 p-r-15-sr991 p-b-25">
              <div class="how2 how2-cl2 flex-sb-c m-b-35">
                <h3 class="f1-m-2 cl13 tab01-title">
                  {{ ucfirst($category['name']) }}
                </h3>
                <a href="{{ route('article.category', [$category['slug']]) }}" class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                  View all
                  <i class="fs-12 m-l-5 fa fa-caret-right"></i>
                </a>
              </div>

              @if (count(App\Models\Post::where('category_id', $category['id'])->orderBy('created_at', 'desc')->get()) > 0)
                @foreach (App\Models\Post::where('category_id', $category['id'])->orderBy('created_at', 'desc')->limit(1)->get() as $post)
                <!-- Main Item post -->
                <div class="m-b-30">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="wrap-pic-w hov1 trans-03">
                    <img src="{{ asset('image/post-image/' . $post['image']) }}" alt="IMG">
                  </a>

                  <div class="p-t-20">
                    <h5 class="p-b-5">
                      <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                        {{ ucfirst($post['title']) }}
                      </a>
                    </h5>

                    <span class="cl8">
                      <a href="{{ route('article.category', [$post['sub_category_id']]) }}" class="f1-s-4 cl8 hov-cl10 trans-03">
                        {{ $post->getSubcategory['subname'] }}
                      </a>

                      <span class="f1-s-3 m-rl-3">
                        -
                      </span>

                      <span class="f1-s-3">
                        @php
                          $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                          echo date_format($date, "D, d M Y");
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>       
                @endforeach

                @foreach (App\Models\Post::where('category_id', $category['id'])->orderBy('created_at', 'desc')->offset(1)->limit(3)->get() as $post)
                  <!-- Item post -->
                  <div class="flex-wr-sb-s m-b-30">
                    <a href="{{ route('article.view', [$post['slug']]) }}" class="size-w-1 wrap-pic-w hov1 trans-03">
                      <img src="{{ asset('image/post-image/' . $post['image']) }}"
                        alt="{{ $post['image'] }}">
                    </a>

                    <div class="size-w-2">
                      <h5 class="p-b-5">
                        <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-s-5 cl3 hov-cl10 trans-03">
                          {{ ucfirst($post['title']) }}
                        </a>
                      </h5>

                      <span class="cl8">
                        <a href="{{ route('article.category', [$post['sub_category_id']]) }}" class="f1-s-6 cl8 hov-cl10 trans-03">
                          {{ $post->getSubcategory['subname'] }}
                        </a>

                        <span class="f1-s-3 m-rl-3">
                          -
                        </span>

                        <span class="f1-s-3">
                          @php
                            $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                            echo date_format($date, "D, d M Y");
                          @endphp
                        </span>
                      </span>
                    </div>
                  </div>
                @endforeach
              @else 
                <h3>No post yet</h3>
              @endif
            </div>              
            @endforeach
          </div>

          <!-- Laptop -->
          <div class="p-b-20">
            <div class="how2 how2-cl1 flex-sb-c m-r-10 m-r-0-sr991">
              <h3 class="f1-m-2 cl12 tab01-title">
                Laptop
              </h3>


              <a href="{{ url('blog/article/category/laptop') }}" class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                View all
                <i class="fs-12 m-l-5 fa fa-caret-right"></i>
              </a>
            </div>

            <div class="row p-t-35">
              <div class="col-sm-6 p-r-25 p-r-15-sr991">
                <!-- Item post -->
                @foreach (App\Models\Post::where('category_id', 6)->orderBy('created_at', 'desc')->limit(1)->get() as $post)
                <div class="m-b-30">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="wrap-pic-w hov1 trans-03">
                    <img src="{{ asset('image/post-image/' . $post['image']) }}" alt="IMG">
                  </a>

                  <div class="p-t-20">
                    <h5 class="p-b-5">
                      <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                        {{ $post['title'] }}
                      </a>
                    </h5>

                    <span class="cl8">
                      <a href="{{ route('article.subcategory', [$post['sub_category_id']]) }}" class="f1-s-4 cl8 hov-cl10 trans-03">
                        {{ $post->getSubcategory['subname'] }}
                      </a>

                      <span class="f1-s-3 m-rl-3">
                        -
                      </span>

                      <span class="f1-s-3">
                        @php
                          $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                          echo date_format($date, "D, d M Y");
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>                  
                @endforeach
              </div>

              <div class="col-sm-6 p-r-25 p-r-15-sr991">
                @foreach (App\Models\Post::where('category_id', 6)->orderBy('created_at', 'desc')->offset(1)->limit(3)->get() as $post)
                <!-- Item post -->
                <div class="flex-wr-sb-s m-b-30">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="size-w-1 wrap-pic-w hov1 trans-03">
                    <img src="{{ asset('image/post-image/' . $post['image']) }}"
                      alt="{{ $post['image'] }}">
                  </a>

                  <div class="size-w-2">
                    <h5 class="p-b-5">
                      <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-s-5 cl3 hov-cl10 trans-03">
                        {{ ucfirst($post['title']) }}
                      </a>
                    </h5>

                    <span class="cl8">
                      <a href="{{ route('article.subcategory', [$post['sub_category_id']]) }}" class="f1-s-6 cl8 hov-cl10 trans-03">
                        {{ $post->getSubcategory['subname'] }}
                      </a>

                      <span class="f1-s-3 m-rl-3">
                        -
                      </span>

                      <span class="f1-s-3">
                        @php
                          $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                          echo date_format($date, "D, d M Y");
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('bloging.layouts.sidebar2')
    </div>
  </div>
</section>

<!-- Banner -->
<div class="container m-b-15">
  <div class="flex-c-c">
    <a href="#">
      <img class="max-w-full" src="{{ asset('posting/images/banner-01.jpg') }}" alt="IMG">
    </a>
  </div>
</div>

<!-- Latest -->
<section class="bg0 p-t-50 p-b-90">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8 p-b-50">
        <div class="p-r-10 p-r-0-sr991">
          <div class="how2 how2-cl4 flex-s-c">
            <h3 class="f1-m-2 cl3 tab01-title">
              Latest Articles
            </h3>
          </div>

          <div class="p-b-40" id="latestPost">
            @foreach (App\Models\Post::orderBy('created_at', 'desc')->limit(7)->get() as $post)
            <!-- Item post -->
            <div class="flex-wr-sb-s p-t-40 p-b-15 how-bor2">
              <a href="{{ route('article.view', [$post['slug']]) }}"
                class="size-w-8 wrap-pic-w hov1 trans-03 w-full-sr575 m-b-25">
                <img src="{{ asset('image/post-image/' . $post['image']) }}" alt="IMG">
              </a>
              <div class="size-w-9 w-full-sr575 m-b-25">
                <h5 class="p-b-12">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-l-1 cl2 hov-cl10 trans-03 respon2">
                    {{ ucfirst($post['title']) }}
                  </a>
                </h5>

                <div class="cl8 p-b-18">
                  <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                    {{ ucfirst($post->getUser['name']) }}
                  </a>

                  <span class="f1-s-3 m-rl-3">
                    -
                  </span>

                  <span class="f1-s-3">
                    @php
                      $date = date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9)));
                      echo date_format($date, "D, d M Y");
                    @endphp
                  </span>
                </div>

                <p class="f1-s-1 cl6 p-b-24">
                  {!! strip_tags(substr($post['content'], 0, 150)) !!}...
                </p>

                <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-s-1 cl9 hov-cl10 trans-03">
                  Read More
                  <i class="m-l-2 fa fa-long-arrow-alt-right"></i>
                </a>
              </div>
            </div>
            @endforeach
          </div>

          @if (count(App\Models\Post::orderBy('created_at', 'desc')->get()) > 7)
          <button class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 hov-btn1 trans-03" id="loadMore">
            Load More
          </button>              
          @endif
        </div>
      </div>

      <div class="col-md-10 col-lg-4 p-b-50">
        <div class="p-l-10 p-rl-0-sr991">
          <!-- Banner -->
          <div class="flex-c-s">
            <a href="#">
              <img class="max-w-full" src="{{ asset('posting/images/banner-03.jpg') }}" alt="IMG">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Video 01-->
<div class="modal fade" id="modal-video-01" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" data-dismiss="modal">
    <div class="close-mo-video-01 trans-0-4" data-dismiss="modal" aria-label="Close">&times;</div>

    <div class="wrap-video-mo-01">
      <div class="video-mo-01">
        {{-- <iframe src="https://www.youtube.com/embed/wJnBTPUQS5A?rel=0" allowfullscreen></iframe> --}}
      </div>
    </div>
  </div>
</div>
@endsection

@push('addon-css')
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
  href="{{ asset('posting/fonts/fontawesome-5.0.8/css/fontawesome-all.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
  href="{{ asset('posting/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/css/util.min.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('posting/css/main.css') }}">
<!--===============================================================================================-->
@endpush

@push('addon-script')
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('posting/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('posting/js/main.js') }}"></script>

<script>
  $(document).ready(() => {
    let offset = 7;
    let limit = 14;
    $('#loadMore').click(() => {
      document.cookie = "offset=" + offset; 
      document.cookie = "limit=" + limit; 
      var cookieValue = document.cookie.split(';');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      let setOffset = cookieValue[0].substring(7);
      let setLimit = cookieValue[1].substring(7);
      console.log(setOffset);
      console.log(setLimit);

      $.ajax({
        url: "{{ route('article.loadData') }}",
        type: 'POST',
        data: {
          offset: setOffset,
          limit: setLimit
        },
        dataType: 'json',
        success: (response) => {
          console.log(response);
          $.each(response, (key, value) => {
            $('#latestPost').append(
              "<div class=\"flex-wr-sb-s p-t-40 p-b-15 how-bor2\"> <a href=\"./article/" + value["slug"] + "/view\" class=\"size-w-8 wrap-pic-w hov1 trans-03 w-full-sr575 m-b-25\"> <img src=\"../post/" + value["image"] + "\" alt=\"IMG\"></a><div class=\"size-w-9 w-full-sr575 m-b-25\"><h5 class=\"p-b-12\"><a href=\"./article/" + value["slug"] + "/view\" class=\"f1-l-1 cl2 hov-cl10 trans-03 respon2\">" + value["title"] + "</a></h5><div class=\"cl8 p-b-18\"><a href=\"#\" class=\"f1-s-4 cl8 hov-cl10 trans-03\">" + value["author"] + "</a><span class=\"f1-s-3 m-rl-3\"> - </span> <span class=\"f1-s-3\"> " + value["created_at"] + " </span></div><p class=\"f1-s-1 cl6 p-b-24\">" + value["content"] + "...</p><a href=\"./article/" + value["slug"] + "/view\" class=\"f1-s-1 cl9 hov-cl10 trans-03\">Read More<i class=\"m-l-2 fa fa-long-arrow-alt-right\"></i></a></div></div>"
            );
          });

          offset += 7;
          limit += 14;
        }
      });
    });
  })
</script>
@endpush