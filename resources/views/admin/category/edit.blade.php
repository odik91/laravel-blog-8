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
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category</a></li>
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
              <h3 class="card-title">Category Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('categories.update', $category['id']) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method("PATCH")
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Category name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    placeholder="Enter category name" value="{{ $category['name'] }}">
                  @error('name')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" cols="30" rows="3">{{ $category['description'] }}</textarea>
                  @error('name')
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
                        accept="image/*">
                      <label class="custom-file-label" for="image">{{ $category['image'] }}</label>
                    </div>
                    @error('image')
                    <span class="error invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="mt-2 image">
                    <img src="{{ asset('image/' . $category['image']) }}" class="img-thumnail" width="75">
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
<!-- /.content-wrapper -->
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

  $(function() {
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });

</script>
@endpush