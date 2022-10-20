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
            <li class="breadcrumb-item"><a href="{{ route('submenu.index') }}">Subenu</a></li>
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
              <h3 class="card-title">Submenu Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('submenu.update', [$submenu['id']]) }}">
              @csrf
              @method('PATCH')
              <div class="card-body">
                <div class="form-group">
                  <label for="menu_id">Base Menu</label>
                  <select name="menu_id" id="menu_id" class="form-control @error('menu_id') is-invalid @enderror" required>
                    @foreach (App\Models\Menu::orderBy('id', 'asc')->get() as $menu)
                    <option value="{{ $submenu['menu_id'] }}" {{ ($submenu['menu_id'] == $menu['id']) ? "selected" : "" }}>{{ $menu['menu'] }}</option>
                    @endforeach
                    @error('menu_id')
                    <span class="error invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </select>
                </div>
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    placeholder="Enter title" value="{{ $submenu['title'] }}" required>
                  @error('title')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="route">Submenu route</label>
                  <input type="text" class="form-control @error('route') is-invalid @enderror" name="route" id="route"
                    placeholder="Enter submenu route" value="{{ $submenu['route'] }}" required>
                  @error('route')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="icon">Submenu fontawesome icon</label>
                  <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon"
                    placeholder="Enter submenu icon" value="{{ $submenu['icon'] }}" required>
                  @error('icon')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="active">Is active</label>
                  <select name="active" id="active" class="form-control @error('active') is-invalid @enderror">
                    <option value="active" {{ (strtolower($submenu['active']) == 'active') ? "selected" : "" }}>Active</option>
                    <option value="inactive" {{ (strtolower($submenu['active']) == 'inactive') ? "selected" : "" }}>Inactive</option>
                  </select>
                  @error('active')
                  <span class="error invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
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