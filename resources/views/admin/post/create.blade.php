@extends('admin.layouts.master')
@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
              <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Post</a></li>
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
                <h3 class="card-title">Post Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Post title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                      id="title" placeholder="Enter post title" value="{{ old('title') }}">
                    @error('title')
                      <span class="error invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="description">Category</label>
                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                      <option selected disabled>Select category</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                      @endforeach
                    </select>
                    @error('category')
                      <span class="error invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="description">Subategory</label>
                    <select name="subcategory" id="subcategory"
                      class="form-control @error('subcategory') is-invalid @enderror">
                      <option selected disabled>Select subcategory</option>
                    </select>
                    @error('subcategory')
                      <span class="error invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="picture">Upload header image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input @error('picture') is-invalid @enderror"
                          name="picture" accept="image/*">
                        <label class="custom-file-label" for="picture">Choose image</label>
                      </div>
                      @error('picture')
                        <span class="error invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="article">Post article</label>
                    <div class="input-group">
                      <div style="width: 100%">
                        <textarea
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                          class="textarea @error('article') is-invalid @enderror" name="article" id="article"></textarea>
                      </div>
                      @error('article')
                        <span class="error invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              {{-- <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data" id="testImage">
              @csrf
              <input type="file" name="image" id="" accept="image/*">
              <button type="submit">test</button>
            </form> --}}
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
  <!-- summernote -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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

  <!-- Summernote -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}
  <script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      bsCustomFileInput.init();
    });


    $(function() {
      @if (Session::has('message'))
        $(document).ready(function() {
          toastr.success("{!! Session::get('message') !!}")
        });
      @endif

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
      });

      let elem = "select[name='category']";
      $(elem).on('change', (e) => {
        let catId = $(elem).val();
        if (catId) {
          $.ajax({
            url: '/admin/ajax-subcategories/' + catId,
            type: "GET",
            dataType: 'json',
            success: (data) => {
              $("select[name='subcategory']").empty()
              $("select[name='subcategory']").append(
                "<option value='' selected disabled>Select subcategories</option>")
              $.each(data, (key, value) => {
                $("select[name='subcategory']").append("<option value='" + key + "'>" + value +
                  "</option>");
              });
            }
          });
        } else {
          $("select[name='subcategory']").empty()
        }
      })

      // Summernote
      $('.textarea').summernote({
        placeholder: 'Write your article here',
        tabsize: 4,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['insert', ['picture', 'link', 'video', 'table']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
          // onImageUpload: function(image) {
          //   uploadImage(image[0]);
          // },
          // onMediaDelete: function(target) {
          //   deleteImage(target[0].src);
          // }
          onImageUploadError: function(msg) {
            alert("File terlalu besar melebihi 1 MB tidak dapat diupload")
          },
        }
      });

      function uploadImage(image) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          }
        });
        var data = new FormData();
        data.append("image", image);

        $.ajax({
          url: "{{ route('ajax.upload') }}",
          cache: false,
          contentType: false,
          processData: false,
          data: data,
          type: "POST",
          success: function(url) {
            $('#article').summernote("insertImage", url);
          },
          error: function(data) {
            console.log(data);
          }
        });
      }

      function deleteImage(src) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          data: {
            src: src
          },
          type: "POST",
          url: "{{ route('ajax.delete') }}",
          cache: false,
          success: (response) => {
            console.log(response);
          }
        });
      }
    });
  </script>
@endpush
