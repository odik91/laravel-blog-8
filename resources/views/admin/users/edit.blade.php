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
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <form action="{{ route('users.update', [$user['id']]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method("PATCH")
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">General Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Enter name" name="name" value="{{ $user['name'] }}">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    placeholder="Enter username" name="username" value="{{ $user['username'] }}">
                  @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                    placeholder="Enter address" name="address">{{ $user['address'] }}</textarea>
                  @error('address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    placeholder="Enter phone number" name="phone" value="{{ $user['phone'] }}">
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                        id="exampleInputFile" name="image">
                      <label class="custom-file-label" for="exampleInputFile">{{ ($user['image']) ? "$user->image" : "Choose image" }}</label>
                    </div>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- right column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Main Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    placeholder="Enter email" value="{{ $user['email'] }}">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="role">Role</label>
                  <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                    <option selected disabled>Select role type</option>
                    @foreach (App\Models\Role::orderBy('name')->get() as $role)
                    <option value="{{ $role['id'] }}" {{ ($user['role_id'] == $role['id']) ? "selected" : "" }}>{{ $role['name'] }}</option>
                    @endforeach
                  </select>
                  @error('role')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary {{ ($user['is_active'] == 1) ? "active" : "" }}">
                    <input type="radio" name="options" id="option1" value="1" {{ ($user['is_active'] == 1) ? "checked" : ""}}> Active
                  </label>
                  <label class="btn btn-secondary {{ ($user['is_active'] == 0) ? "active" : "" }}">
                    <input type="radio" name="options" value="0" id="option2" {{ ($user['is_active'] == 0) ? "checked" : ""}}> Unactive
                  </label>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </form>
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

  $().button('toggle')

</script>
@endpush