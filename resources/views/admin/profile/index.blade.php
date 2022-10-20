@extends('admin.layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Profile</a></li>
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

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                  src="{{ asset('image/profile/' . auth()->user()->image) }}" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ ucwords(auth()->user()->name) }}</h3>

              <p class="text-muted text-center">{{ ucwords(auth()->user()->getRole->name) }}</p>

              <a href="{{ route('profile.edit', [auth()->user()->id]) }}" class="btn btn-block btn-primary">Edit Profile</a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fas fa-book mr-1"></i> Current Role</strong>

              <p class="text-muted">
                {{ ucwords(auth()->user()->getRole->name) }}
              </p>

              <hr>

              <strong><i class="fas fa-calendar-alt mr-1"></i> Register date</strong>

              <p class="text-muted">
                @php
                $date = date_create(substr(auth()->user()->created_at, 0, (strlen(auth()->user()->created_at) - 9)));
                echo date_format($date, "D, d M Y");
                @endphp
              </p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><span class="nav-link">User Information</span></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fas fa-id-card mr-1"></i> Name</strong>
              <p class="text-muted">
                {{ ucwords(auth()->user()->name) }}
              </p>

              <hr>

              <strong><i class="fas fa-user-circle mr-1"></i> Username</strong>
              <p class="text-muted">
                {{ auth()->user()->username }}
              </p>

              <hr>

              <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
              <p class="text-muted">
                {{ auth()->user()->email }}
              </p>

              <hr>

              <strong><i class="fas fa-map mr-1"></i> Address</strong>
              <p class="text-muted">
                {{ ucwords(auth()->user()->address) }}
              </p>

              <hr>

              <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
              <p class="text-muted">
                {{ auth()->user()->phone }}
              </p>

              <hr>
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
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
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });
</script>
@endpush