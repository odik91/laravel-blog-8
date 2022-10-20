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
            <li class="breadcrumb-item"><a href="{{ route('message.index') }}">Message</a></li>
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
          <a href="{{ route('message.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>
          @include('admin.message.sidebar')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Read Mail</h3>

              <div class="card-tools">
                @php
                  $pos = array_search($message['id'], $ids);
                  $next = $ids[$pos + 1];                  
                  $prev = 0;
                  if ($pos == 0) {
                    $prev = $message['id'];
                  } else {
                    $prev = $ids[$pos - 1];
                  }
                @endphp
                <a href="{{ route('message.read', $prev) }}" class="btn btn-tool" data-toggle="tooltip" title="Previous"><i
                    class="fas fa-chevron-left"></i></a>
                <a href="{{ route('message.read', $next) }}" class="btn btn-tool" data-toggle="tooltip" title="Next"><i
                    class="fas fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5>{{ $message['subject'] }}</h5>
                <h6>From:<b> {{ ucwords($message['name']) }}</b> &lt;{{ $message['email'] }}&gt;
                  <span class="mailbox-read-time float-right">
                    {{ date_format(date_create(substr($message['created_at'], 0, (strlen($message['created_at']) - 9))), "D, d M Y") }}
                  </span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <form action="{{ route('message.deleteing', [$message['id']]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                    title="Delete">
                      <i class="far fa-trash-alt"></i>
                    </button>
                  </form>
                  <form action="{{ route('message.reply') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idReply[]" value="{{ $message['id'] }}">
                    <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply"><i class="fas fa-reply"></i></button>
                  </form>
                  <a href="{{ route('message.forward', [$message['id']]) }}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                    title="Forward">
                    <i class="fas fa-share"></i></a>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fas fa-print"></i></button>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message p-3">
                {!! ucfirst($message['message']) !!}
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
                <div class="btn-group">
                  <form action="{{ route('message.reply') }}" method="POST" class="pr-2">
                    @csrf
                    <input type="hidden" value="{{ $message['id'] }}" name="idReply[]">
                    <button type="submit" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                  </form>
                  <a href="{{ route('message.forward', [$message['id']]) }}" class="btn btn-default"><i class="fas fa-share"></i> Forward</a>
                </div>
              </div>
              <div class="btn-group">
                <form action="{{ route('message.deleteing', [$message['id']]) }}" method="post" class="pr-2">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
                <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });
</script>
@endpush