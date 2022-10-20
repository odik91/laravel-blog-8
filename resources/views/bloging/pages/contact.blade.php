@extends('bloging.layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="container">
  <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
    <div class="f2-s-1 p-r-30 m-tb-6">
      <a href="{{ route('article.index') }}" class="breadcrumb-item f1-s-3 cl9">
        Home
      </a>

      <span class="breadcrumb-item f1-s-3 cl9">
        {{ $title }}
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
<!-- Page heading -->
<div class="container p-t-4 p-b-40">
  <h2 class="f1-l-1 cl2">
    Contact Us
  </h2>
</div>

<!-- Content -->
<section class="bg0 p-b-60">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-8 p-b-80">
        <div class="p-r-10 p-r-0-sr991">
          <form method="POST" action="{{ route('article.sendMessage') }}">
            @csrf
            <div class="form-group">
              <input class="bo-1-rad-3 bocl13 size-a-19 f1-s-13 cl5 plh6 p-rl-18 m-b-20" type="text" name="name" placeholder="Name*" value="{{ old('name') }}" required>
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-group">
              <input class="bo-1-rad-3 bocl13 size-a-19 f1-s-13 cl5 plh6 p-rl-18 m-b-20" type="text" name="email" placeholder="Email*" value="{{ old('email') }}" required>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            
            <div class="form-group">
              <input class="bo-1-rad-3 bocl13 size-a-19 f1-s-13 cl5 plh6 p-rl-18 m-b-20" type="text" name="subject" placeholder="Subject*" value="{{ old('subject') }}" required>
              @error('subject')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-group">
              <textarea class="bo-1-rad-3 bocl13 size-a-15 f1-s-13 cl5 plh6 p-rl-18 p-tb-14 m-b-20" name="msg" placeholder="Your Message" required>{{ old('msg') }}</textarea>
              @error('msg')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <button class="size-a-20 bg2 borad-3 f1-s-12 cl0 hov-btn1 trans-03 p-rl-15 m-t-20">
              Send
            </button>
          </form>
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