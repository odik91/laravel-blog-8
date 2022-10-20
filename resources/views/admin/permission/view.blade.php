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
            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
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
              <h3 class="card-title">Permission Information</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="col-md-8">
                  Access for: <span
                    class="btn btn-outline-success badge-pill p-2 px-4 mb-1">{{ $permission->rolePermission['name'] }}</span>
                </div>
                <div class="col-md-4">
                  <a href="{{ route('permission.edit', [$id]) }}"
                    class="btn btn-outline-info badge-pill p-2 px-4 mb-1 float-right">Edit</a>
                </div>
              </div>
              <table class="table table-striped table-dark">
                <thead>
                  <tr>
                    <th scope="col">Menu</th>
                    <th scope="col" class="text-center">Enable</th>
                    <th scope="col" class="text-center">View</th>
                    <th scope="col" class="text-center">Create</th>
                    <th scope="col" class="text-center">Edit</th>
                    <th scope="col" class="text-center">Delete</th>
                    <th scope="col" class="text-center">Trash</th>
                    <th scope="col" class="text-center">Restore</th>
                    <th scope="col" class="text-center">Remove</th>
                    <th scope="col" class="text-center">Other</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th scope="col">Menu</th>
                    <th scope="col" class="text-center">Enable</th>
                    <th scope="col" class="text-center">View</th>
                    <th scope="col" class="text-center">Create</th>
                    <th scope="col" class="text-center">Edit</th>
                    <th scope="col" class="text-center">Delete</th>
                    <th scope="col" class="text-center">Trash</th>
                    <th scope="col" class="text-center">Restore</th>
                    <th scope="col" class="text-center">Remove</th>
                    <th scope="col" class="text-center">Other</th>
                  </tr>
                </tfoot>
                <tbody>
                  @php
                  $menu_id = explode(',', $permission['menu_id']);
                  $menus = App\Models\Menu::whereIn('id', $menu_id)->get();
                  @endphp
                  @foreach ($menus as $menu)
                  @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                  <tr>
                    <td>{{ $menu['menu'] }}</td>
                    <td class="text-center">
                      <i class="far fa-check-circle fa-2x text-primary"></i>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['view']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['create']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['edit']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['delete']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['trash']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['restore']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['remove']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['other']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @elseif (strtolower($menu['menu']) == 'comment')
                  <tr>
                    <td>{{ $menu['menu'] }}</td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline">
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['view']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['delete']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['other']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @else
                  <tr>
                    <td>{{ $menu['menu'] }}</td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline">
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                      </div>
                    </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">
                      <div class="icheck-primary d-inline text">
                        @if (isset($permission['name'][$menu['id']]['other']))
                        <i class="far fa-check-circle fa-2x text-primary"></i>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
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
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
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

<!-- Select2 -->
<script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Toaster -->
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
  $(function() {
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });

</script>
@endpush