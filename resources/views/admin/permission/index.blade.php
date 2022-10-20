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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total record: {{ count($permissions) }}</h3>
            <a href="{{ route('permission.create') }}" class="btn btn-info btn-sm float-right"><i
                class="fas fa-plus pr-1"></i>Add new permission</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Menu Access</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($permissions as $key => $permission)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ ucfirst($permission->rolePermission['name']) }}</td>
                  <td>
                    @php
                    $menu_id = explode(',', $permission['menu_id']);
                    $menus = App\Models\Menu::whereIn('id', $menu_id)->get();
                    @endphp
                    @foreach ($menus as $menu)
                    <span class="btn btn-outline-success badge-pill p-2 px-4 mb-1">{{ $menu['menu'] }}</span>
                    @endforeach
                  </td>
                  <td>
                    <a href="{{ route('permission.show', $permission['id']) }}"
                      class="btn btn-outline-info badge-pill mb-1" title="Details"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('permission.edit', $permission['id']) }}"
                      class="btn btn-outline-warning badge-pill mb-1" title="edit"><i class="fas fa-edit"></i></a>
                    @if (isset(auth()->user()->getRole->permission['name']["12"]['delete']))
                    <a href="#" class="btn btn-outline-danger badge-pill mb-1" title="delete" data-toggle="modal"
                      data-target="#ModalCenter{{ $permission['id'] }}"><i class="fas fa-trash"></i></a>
                    <!-- Modal -->
                    <div class="modal fade" id="ModalCenter{{ $permission['id'] }}" tabindex="-1" permission="dialog"
                      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header  bg-danger">
                            <h5 class="modal-title" id="exampleModalLongTitle">Warning</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are you sure want to delete <b>{{ ucfirst($permission->rolePermission['name']) }}</b> ?
                          </div>
                          <div class="modal-footer">
                            <form action="{{ route('permission.destroy', $permission['id']) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
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
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });
</script>
@endpush