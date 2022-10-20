@extends('admin.layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Profile Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('profile.update', [auth()->user()->id]) }}" method="post"
              enctype="multipart/form-data">
              @csrf
              @method("PATCH")
              <div class="card-body">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    placeholder="Enter email" value="{{ $data['email'] }}">
                  @error('email')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" name="address" id="address" cols="30"
                    rows="5">{{ $data['address'] }}</textarea>
                  @error('address')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="phone">Phone number</label>
                  <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                    placeholder="Enter phone number" value="{{ $data['phone'] }}">
                  @error('phone')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="image">Upload image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image"
                        accept="image/*" id="image">
                      <label class="custom-file-label" for="image">{{ $data['image'] }}</label>
                    </div>
                    @error('image')
                    <span class="error invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="mt-2 image" id="currImage">
                    <img src="{{ asset('image/profile/' . $data['image']) }}" class="img-thumnail"
                      width="75">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection

@push('addon-css')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
@endpush

@push('addon-script')
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/dist/js/demo.js') }}"></script>

<!-- Toaster -->
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });

  $('#image').on('change', () => {
    if (typeof(FileReader) != "undefined") {
      let image_holder = $('#currImage');
      image_holder.empty();

      let reader = new FileReader();
      reader.onload = (e) => {
        $("<img />", {
          "src" : e.target.result,
          "class" : "img-thumnail",
          "width" : 75
        }).appendTo(image_holder);
      }
      image_holder.show();
      reader.readAsDataURL(event.target.files[0])
    } else {
      console.log('This browser does not support FileReader.');
    }
  });
  // $('#image').change(() => {
  //   $('#currImage').src = URL.createObjectURL(event.target.files[0]);
  // })

  $(function() {
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });

</script>
@endpush