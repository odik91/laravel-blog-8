@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
        <div class="col-md-3">
          <a href="mailbox.html" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

          <div class="card">
            @include('admin.message.sidebar')
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <form action="{{ route('message.sendingMulty') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post"></form>
                <div class="form-group to">
                  To:&nbsp;
                  <span id="target">
                  @foreach ($receivers as $receiver)
                    <button name="del" class="btn btn-sm btn-outline-dark receiver{{ $receiver['id'] }}" onclick='removeTo(".receiver{{ $receiver->id }}");'>{{ $receiver['email'] }} <i class="far fa-window-close"></i></button>
                    <input type="hidden" name="receivers[]" value="{{ $receiver['email'] }}" class="receiver{{ $receiver['id'] }}">
                  @endforeach
                  </span>
                </div>
                <div class="form-group">
                  <input class="form-control @error('subject') is-invalid @enderror" placeholder="Subject:" name="subject" required>

                  @error('subject')
                    <span class="error invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                  <textarea id="compose-textarea" class="form-control @error('message') is-invalid @enderror" style="height: 300px" name="message" required></textarea>

                  @error('message')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <a href="#" class="btn btn-default todrafts"><i class="fas fa-pencil-alt"></i> Draft</a>
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </form>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('addon-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
<!-- summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('addon-script')
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/dist/js/demo.js') }}"></script>
<!-- Toaster -->
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- page script -->
<script>
  $(function () {
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif

  // Summernote
    $('#compose-textarea').summernote({
      placeholder: 'Write your article here',
      tabsize: 4,
      height: 300,
      toolbar: [
        ['style', ['style']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['insert', [ 'picture', 'link', 'video', 'table']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      callbacks: {
        onImageUpload: function(image) {
          uploadImage(image[0]);
        },
        onMediaDelete : function(target) {
          deleteImage(target[0].src);
        }
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
          $('#compose-textarea').summernote("insertImage", url);
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
        data: {src: src},
        type: "POST",
        url: "{{ route('ajax.delete') }}",
        cache: false,
        success: (response) => {
          console.log(response);
        }
      });
    }
  });

  function removeTo(item) {
    event.preventDefault();
    if ($("button[name='del']").length > 1) {
      $("input").remove(item);
      $(item).remove();
    }
  }

  let id = 0;
  $('.todrafts').click(() => {
    // console.log("clicked");
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let to = [];
    if ($("#target > input").length > 0) {
      for (let i = 0; i < $("#target > input").length; i++) {
        to.push($('input[name="receivers[]"]')[i].value);
      }
    }

    console.log(to);

    $.ajax({
      url: "{{ route('message.drafts') }}",
      type: "POST",
      data: {
        receivers : to,
        subject : $('input[name=subject]').val(),
        message : $('#compose-textarea').val(),
        id: id
      },
      dataType: 'json',
      success: (response) => {
        console.log(response);
        id = response['id'];

        if (response['status'] == 'success') {
          toastr.success(response['message']);
          $('.inbox').html(response['inbox']);
          $('.drafts').html(response['drafts']);
        } else {
          toastr.warning("Something went wrong");
        }
      }
    });
  });

</script>
@endpush