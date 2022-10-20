@extends('bloging.layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Breadcrumb -->
<div class="container">
  <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
    <div class="f2-s-1 p-r-30 m-tb-6">
      <a href="{{ route('article.index') }}" class="breadcrumb-item f1-s-3 cl9">
        Home
      </a>

      <a href="{{ route('article.category', [$category['slug']]) }}" class="breadcrumb-item f1-s-3 cl9">
        {{ $category['name'] }}
      </a>

      <span class="breadcrumb-item f1-s-3 cl9">
        {{ $title }}
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

<!-- Page heading -->
<div class="container p-t-4 p-b-40">
  <h2 class="f1-l-1 cl2">
    Article List
  </h2>
</div>

<!-- Post -->
<section class="bg0 p-b-55">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8 p-b-80">
        <div class="p-r-10 p-r-0-sr991">
          <div class="m-t--40 p-b-40" id="latestPost">
            @if (count($postCategories) > 0)
              @foreach ($postCategories as $postCategory)
              <!-- Item post -->
              <div class="flex-wr-sb-s p-t-40 p-b-15 how-bor2">
                <a href="{{ route('article.view', [$postCategory['slug']]) }}" class="size-w-8 wrap-pic-w hov1 trans-03 w-full-sr575 m-b-25">
                  <img src="{{ asset('image/post-image/' . $postCategory['image']) }}" alt="IMG">
                </a>

                <div class="size-w-9 w-full-sr575 m-b-25">
                  <h5 class="p-b-12">
                    <a href="{{ route('article.view', [$postCategory['slug']]) }}" class="f1-l-1 cl2 hov-cl10 trans-03 respon2">
                      {{ ucfirst($postCategory['title']) }}
                    </a>
                  </h5>

                  <div class="cl8 p-b-18">
                    <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                      By {{ ucwords($postCategory->getUser['name']) }}
                    </a>

                    <span class="f1-s-3 m-rl-3">
                      -
                    </span>

                    <span class="f1-s-3">
                      {{ date_format(date_create(substr($postCategory['created_at'], 0, (strlen($postCategory['created_at']) - 9))), "D, d M Y") }}
                    </span>
                  </div>

                  <p class="f1-s-1 cl6 p-b-24">
                    {!! strip_tags(substr($postCategory['content'], 0, 150)) !!}...
                  </p>

                  <a href="{{ route('article.view', [$postCategory['slug']]) }}" class="f1-s-1 cl9 hov-cl10 trans-03">
                    Read More
                    <i class="m-l-2 fa fa-long-arrow-alt-right"></i>
                  </a>
                </div>
              </div>
              @endforeach
            @else 
            <div class="flex-wr-sb-s p-t-40 p-b-15 how-bor2">
              <h3>No Post Yet...</h3>
            </div>
            @endif
          </div>

          @if (count(App\Models\Post::where('category_id', $category['id'])->orderBy('created_at', 'desc')->get()) > 7)
          <button id="loadMore" class="flex-c-c size-a-13 bo-all-1 bocl11 f1-m-6 cl6 hov-btn1 trans-03">
            Load More
          </button>
          @endif
        </div>
      </div>

      @include('bloging.layouts.sidebar2')
    </div>
  </div>
</section>
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
<style>
  .article-content p {
    line-height: 1, 8px;
    padding-bottom: 25px;
    text-align: justify;
  }

  .article-content h2 {
    line-height: 1, 8px;
    padding-bottom: 25px;
    text-align: center;
    font-weight: 600;
  }
</style>
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

      $.ajax({
        url: "{{ route('article.loadDataCategory') }}",
        type: 'POST',
        data: {
          offset: setOffset,
          limit: setLimit,
          category: {{ $id }}
        },
        dataType: 'json',
        success: (response) => {
          $.each(response, (key, value) => {
            $('#latestPost').append(
              "<div class=\"flex-wr-sb-s p-t-40 p-b-15 how-bor2\"> <a href=\"../../article/" + value["slug"] + "/view\" class=\"size-w-8 wrap-pic-w hov1 trans-03 w-full-sr575 m-b-25\"> <img src=\"{{ asset('post') }}/" + value["image"] + "\" alt=\"IMG\"></a><div class=\"size-w-9 w-full-sr575 m-b-25\"><h5 class=\"p-b-12\"><a href=\"../../article/" + value["slug"] + "/view\" class=\"f1-l-1 cl2 hov-cl10 trans-03 respon2\">" + value["title"] + "</a></h5><div class=\"cl8 p-b-18\"><a href=\"#\" class=\"f1-s-4 cl8 hov-cl10 trans-03\">" + value["author"] + "</a><span class=\"f1-s-3 m-rl-3\"> - </span> <span class=\"f1-s-3\"> " + value["created_at"] + " </span></div><p class=\"f1-s-1 cl6 p-b-24\">" + value["content"] + "...</p><a href=\"../../article/" + value["slug"] + "/view\" class=\"f1-s-1 cl9 hov-cl10 trans-03\">Read More<i class=\"m-l-2 fa fa-long-arrow-alt-right\"></i></a></div></div>"
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