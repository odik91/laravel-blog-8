@extends('bloging.layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="container">
  <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
    <div class="f2-s-1 p-r-30 m-tb-6">
      <a href="{{ route('article.index') }}" class="breadcrumb-item f1-s-3 cl9">
        Home
      </a>

      <a href="{{ route('article.category', [$post->getCategory['slug']]) }}" class="breadcrumb-item f1-s-3 cl9">
        {{ $post->getCategory['name'] }}
      </a>

      <a href="{{ route('article.subcategory', [$post['sub_category_id']]) }}" class="breadcrumb-item f1-s-3 cl9">
        {{ $post->getSubcategory['subname'] }}
      </a>

      <span class="breadcrumb-item f1-s-3 cl9">
        {{ $post['title'] }}
      </span>
    </div>

    <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
      <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Search">
      <button class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
        <i class="zmdi zmdi-search"></i>
      </button>
    </div>
  </div>
</div>

<!-- Content -->
<section class="bg0 p-b-140 p-t-10">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8 p-b-30">
        <div class="p-r-10 p-r-0-sr991">
          <!-- Blog Detail -->
          <div class="p-b-70">
            <a href="#" class="f1-s-10 cl2 hov-cl10 trans-03 text-uppercase">
              {{ $post->getCategory['name'] }}
            </a>

            <h3 class="f1-l-3 cl2 p-b-16 p-t-33 respon2">
              {{ ucfirst($post['title']) }}
            </h3>

            <div class="flex-wr-s-s p-b-40">
              <span class="f1-s-3 cl8 m-r-15">
                <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                  by {{ $post->getUser['name'] }}
                </a>

                <span class="m-rl-3">-</span>

                <span>
                  {{ date_format(date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9))), "D, d M Y") }}
                </span>
              </span>

              <span class="f1-s-3 cl8 m-r-15">
                {{ $post['views'] }} Views
              </span>

              <a href="#comment" class="f1-s-3 cl8 hov-cl10 trans-03 m-r-15">
                {{ count(App\Models\Comment::where('post_id', $post['id'])->get()) }} Comment
              </a>
            </div>

            <div class="wrap-pic-max-w p-b-30">
              <img src="{{ asset('image/post-image/' . $post['image']) }}" alt="IMG">
            </div>

            <div class="article-content">
              {!! $post['content'] !!}
            </div>

            <!-- Share -->
            <div class="flex-s-s">
              <span class="f1-s-12 cl5 p-t-1 m-r-15">
                Share:
              </span>

              <div class="flex-wr-s-s size-w-0">
                {{-- <a href="https://www.facebook.com/share.php?u={{ route('article.view', [$post['slug']]) }}"
                  class="dis-block f1-s-13 cl0 bg-facebook borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                  <i class="fab fa-facebook-f m-r-7"></i>
                  Facebook
                </a>

                <a href="https://twitter.com/intent/tweet?text=&url={{ route('article.view', [$post['slug']]) }}"
                  class="dis-block f1-s-13 cl0 bg-twitter borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                  <i class="fab fa-twitter m-r-7"></i>
                  Twitter
                </a>

                <a href="#"
                  class="dis-block f1-s-13 cl0 bg-google borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                  <i class="fab fa-google-plus-g m-r-7"></i>
                  Google+
                </a>

                <a href="#"
                  class="dis-block f1-s-13 cl0 bg-pinterest borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                  <i class="fab fa-pinterest-p m-r-7"></i>
                  Pinterest
                </a> --}}
                <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=600d8a3d8bb33e00116e6fef&product=inline-share-buttons" async="async"></script>
                <div class="sharethis-inline-share-buttons"></div>
                {{-- <p class='text-center'>
                  <a target='_blank' href="https://www.facebook.com/share.php?u={{ route('article.view', [$post['slug']]) }}">
                  <img src='https://www.matthewb.id.au/social/facebook.png' alt='Facebook'/></a>
                  <a target='_blank' href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('article.view', [$post['slug']]) }}">
                  <img src='https://www.matthewb.id.au/social/linkedin.png' alt='Linked In'/></a>
                  <a target='_blank' href="https://delicious.com/save?url={{ route('article.view', [$post['slug']]) }}">
                  <img src='https://www.matthewb.id.au/social/delicious.png' alt='Delicious'/></a>
                  <a target='_blank' href="https://www.reddit.com/submit?url={{ route('article.view', [$post['slug']]) }}">
                  <img src='https://www.matthewb.id.au/social/reddit.png' alt='Reddit'/></a>
                  <a target='_blank' href="https://twitter.com/intent/tweet?text=&url={{ route('article.view', [$post['slug']]) }}">
                  <img src='https://www.matthewb.id.au/social/twitter.png' alt='Tweet' /></a>
                </p> --}}
              </div>
            </div>
          </div>

          <!-- Leave a comment -->
          <div>
            <h4 class="f1-l-4 cl3 p-b-12">
              Leave a Comment
            </h4>

            <p class="f1-s-13 cl8 p-b-40">
              Your email address will not be published. Required fields are marked *
            </p>

            <form method="POST" action="{{ route('article.store') }}">
              @csrf
              <div class="mb-2">
                <textarea class="bo-1-rad-3 bocl13 size-a-15 f1-s-13 cl5 plh6 p-rl-18 p-tb-14 @error('msg') is-invalid @enderror" name="msg"
                  placeholder="Comment..." required>{{ old('msg') }}</textarea>
                @error('msg')
                  <span class="f1-s-13 cl5 plh6 p-rl-18 text-danger" role="alert">
                    <small>{{ $message }}</small>
                  </span>
                @enderror
              </div>

              <div class="mb-2">
                <input class="bo-1-rad-3 bocl13 size-a-16 f1-s-13 cl5 plh6 p-rl-18 m-b-20 @error('name') is-invalid @enderror" type="text" name="name"
                placeholder="Name*" required value="{{ old('name') }}">
                @error('name')
                  <span class="f1-s-13 cl5 plh6 p-rl-18 text-danger" role="alert">
                    <small>{{ $message }}</small>
                  </span>
                @enderror
              </div>

              <div class="mb-2">
                <input class="bo-1-rad-3 bocl13 size-a-16 f1-s-13 cl5 plh6 p-rl-18 @error('email') is-invalid @enderror" type="email" name="email"
                placeholder="Email*" required value="{{ old('email') }}">
                <span class="f1-s-13 cl5 plh6 p-rl-18">
                  <small>We will keep your email privacy</small>
                </span>
                @error('email')
                <span class="f1-s-13 cl5 plh6 p-rl-18 text-danger" role="alert">
                  <small>{{ $message }}</small>
                </span>
                @enderror
              </div>
              <input type="hidden" name="postId" value="{{ $post['id'] }}">

              <button type="submit" class="size-a-17 bg2 borad-3 f1-s-12 cl0 hov-btn1 trans-03 p-rl-15 m-t-10">
                Post Comment
              </button>
            </form>
          </div>

          <!-- comment lists -->
          <div class="mt-5" id="comment">
            <hr>
            <div class="hov-cl10 trans-03 text-right">
              Comments ({{ count(App\Models\Comment::where('post_id', $post['id'])->get()) }})
            </div>
            <hr>

            @foreach (App\Models\Comment::where('post_id', $post['id'])->get() as $comment)
            <div class="container mt-3 p-0">
              <div>
                <div class="border rounded-top main-bg">
                  <div class="d-flex flex-row bd-highlight justify-content-between">
                    <div class="contaier">
                      <div class="row ml-2">
                        <div class="col-md-6 py-2 px-2">
                          <div class="p-2 bd-highlight size-w-1 wrap-pic-w hov1 trans-03" style="width: 50px;">
                            <img src="{{ asset('image/thV0Y6HLBFbYxvlbPPHZlx76Q9LRfDfFjaJG4ang.png') }}" alt="">                        
                          </div>
                        </div>
                        <div class="col-md-6 align-self-center pl-0 text-light">
                          {{ ucfirst($comment['name']) }}
                        </div>
                      </div>
                    </div>
                    <div class="pr-4 bd-highlight align-self-center">
                      <small class="text-light">
                        {{ date_format(date_create($comment['created_at']),"D, d M Y, H:i A") }}
                      </small>
                    </div>
                  </div>
                </div>
                <div class="add-shadow border-top">
                  <p class="pt-4 px-4">
                    {{ $comment['comment'] }}
                  </p>
                  <div class="d-flex flex-row bd-highlight justify-content-between px-3">
                    <div class="p-2">
                      <small class="hov-cl10">replay ({{ count(App\Models\ReplayComment::where('comment_id', $comment['id'])->get()) }})</small>
                    </div>
                    <div class="p-2 bd-highlight align-self-center">                      
                      <button class="btn btn-sm bo-all-1 bocl11 cl6 hov-btn1 trans-03" data-target="#replyModal{{ $comment['id'] }}" data-toggle="modal">
                        Reply
                      </button>
                      <!-- Modal -->
                      <div class="modal fade" id="replyModal{{ $comment['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Reply comment</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ route('article.replay') }}" method="POST">
                              @csrf
                              <div class="modal-body">                              
                                <input type="hidden" name="commentId" value="{{ $comment['id'] }}">
                                <div class="form-group">
                                  <textarea name="replay" class="form-control" cols="30" rows="5" placeholder="Leave a comment*" required>{{ old('replay') }}</textarea>
                                </div>
                                <div class="form-group">
                                  <input type="text" name="name" class="form-control" placeholder="Name*" required value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                  <input type="email" name="email" class="form-control" placeholder="Email*" required value="{{ old('email') }}">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn main-bg text-light">Send</button>
                              </div>
                            </form>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>                 
                  <!-- reply -->
                  <div  id="commentReply">
                    @foreach (App\Models\ReplayComment::where('comment_id', $comment['id'])->orderBy('created_at', 'desc')->get() as $replay)
                    <div class="ml-5 mr-2 pb-4">                    
                      <div class="add-shadow-resposne border-top">
                        <div class="border rounded-top">
                          <div class="d-flex flex-row bd-highlight justify-content-between">
                            <div class="contaier">
                              <div class="row ml-2">
                                <div class="col-md-6 py-2 px-2">
                                  <div class="p-2 bd-highlight size-w-1 wrap-pic-w hov1 trans-03" style="width: 50px;">
                                    <img src="{{ asset('image/thV0Y6HLBFbYxvlbPPHZlx76Q9LRfDfFjaJG4ang.png') }}" alt="">                        
                                  </div>
                                </div>
                                <div class="col-md-6 align-self-center p-2">
                                  {{ ucfirst($replay['name']) }}
                                </div>
                              </div>
                            </div>
                            <div class="pr-4 bd-highlight align-self-center">
                              <small>
                                {{ date_format(date_create($replay['created_at']),"D, d M Y, H:i A") }}
                              </small>
                            </div>
                          </div>
                        </div>
                        <p class="p-4">
                          {{ ucfirst($replay['replay']) }}
                        </p>                     
                      </div>
                    </div>                        
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            @endforeach

            {{-- <div class="container mt-3 p-0">
              <div>
                <div class="border rounded-top main-bg">
                  <div class="d-flex flex-row bd-highlight justify-content-between">
                    <div class="contaier">
                      <div class="row ml-2">
                        <div class="col-md-6 py-2 px-2">
                          <div class="p-2 bd-highlight size-w-1 wrap-pic-w hov1 trans-03" style="width: 50px;">
                            <img src="{{ asset('image/thV0Y6HLBFbYxvlbPPHZlx76Q9LRfDfFjaJG4ang.png') }}" alt="">                        
                          </div>
                        </div>
                        <div class="col-md-6 align-self-center p-2">
                          user
                        </div>
                      </div>
                    </div>
                    <div class="pr-4 bd-highlight align-self-center">
                      <small class="text-light">December 17, 2020, 10:21 AM</small>
                    </div>
                  </div>
                </div>
                <div class="add-shadow border-top">
                  <p class="pt-4 px-4">
                    Vivamus venenatis suscipit leo, nec vehicula justo tristique sit amet. Sed congue, erat non fringilla dignissim, arcu nisl sagittis est, vitae lobortis tortor dolor viverra leo. Vivamus tempor facilisis dui sed viverra. Donec convallis imperdiet quam.
                  </p>
                  <div class="d-flex flex-row bd-highlight justify-content-between px-3">
                    <div class="p-2">
                      <small class="hov-cl10">replay (2)</small>
                    </div>
                    <div class="p-2 bd-highlight align-self-center">                      
                      <button id="replay1" class="btn btn-sm bo-all-1 bocl11 cl6 hov-btn1 trans-03">
                        Replay
                      </button>
                    </div>
                  </div>
                  <hr>                 
                  <!-- replay -->
                  <div class="ml-5 mr-2 pb-4">                    
                    <div class="add-shadow-resposne border-top">
                      <div class="border rounded-top">
                        <div class="d-flex flex-row bd-highlight justify-content-between">
                          <div class="contaier">
                            <div class="row ml-2">
                              <div class="col-md-6 py-2 px-2">
                                <div class="p-2 bd-highlight size-w-1 wrap-pic-w hov1 trans-03" style="width: 50px;">
                                  <img src="{{ asset('image/thV0Y6HLBFbYxvlbPPHZlx76Q9LRfDfFjaJG4ang.png') }}" alt="">                        
                                </div>
                              </div>
                              <div class="col-md-6 align-self-center p-2">
                                user
                              </div>
                            </div>
                          </div>
                          <div class="pr-4 bd-highlight align-self-center">
                            <small class="text-light">December 17, 2020, 10:21 AM</small>
                          </div>
                        </div>
                      </div>
                      <p class="p-4">
                        Vivamus venenatis suscipit leo, nec vehicula justo tristique sit amet. Sed congue, erat non fringilla dignissim, arcu nisl sagittis est, vitae lobortis tortor dolor viverra leo. Vivamus tempor facilisis dui sed viverra. Donec convallis imperdiet quam.
                      </p>                     
                    </div>
                  </div>
                  <div class="ml-5 mr-2 pb-4">                    
                    <div class="add-shadow-resposne border-top">
                      <div class="border rounded-top">
                        <div class="d-flex flex-row bd-highlight justify-content-between">
                          <div class="contaier">
                            <div class="row ml-2">
                              <div class="col-md-6 py-2 px-2">
                                <div class="p-2 bd-highlight size-w-1 wrap-pic-w hov1 trans-03" style="width: 50px;">
                                  <img src="{{ asset('image/thV0Y6HLBFbYxvlbPPHZlx76Q9LRfDfFjaJG4ang.png') }}" alt="">                        
                                </div>
                              </div>
                              <div class="col-md-6 align-self-center p-2">
                                user
                              </div>
                            </div>
                          </div>
                          <div class="pr-4 bd-highlight align-self-center">
                            <small class="text-light">December 17, 2020, 10:21 AM</small>
                          </div>
                        </div>
                      </div>
                      <p class="p-4">
                        Vivamus venenatis suscipit leo, nec vehicula justo tristique sit amet. Sed congue, erat non fringilla dignissim, arcu nisl sagittis est, vitae lobortis tortor dolor viverra leo. Vivamus tempor facilisis dui sed viverra. Donec convallis imperdiet quam.
                      </p>                     
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
          </div>        
          
        </div>
      </div>

      <!-- Sidebar -->
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
    line-height: 1,8px;
    padding-bottom: 25px;
    text-align: justify;
  }

  .article-content h2 {
    line-height: 1,8px;
    padding-bottom: 25px;
    text-align: center;
    font-weight: 600;    
  }

  .add-shadow {
    box-shadow: 2px 10px 18px -6px rgba(0,0,0,0.54);
    -webkit-box-shadow: 2px 10px 18px -6px rgba(0,0,0,0.54);
    -moz-box-shadow: 2px 10px 18px -6px rgba(0,0,0,0.54);
  }

  .add-shadow-resposne {
    box-shadow: 1px 4px 18px -4px rgba(0,0,0,0.54);
    -webkit-box-shadow: 1px 4px 18px -4px rgba(0,0,0,0.54);
    -moz-box-shadow: 1px 4px 18px -4px rgba(0,0,0,0.54);
  }
  .main-bg {
    background-color: #17b978;
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  $(function () {
    @if (Session::has('message'))
      $(document).ready(function() {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: "{!! Session::get('message') !!}",
          showConfirmButton: false,
          timer: 1500
        })
      });
    @endif
  });  
</script>
@endpush