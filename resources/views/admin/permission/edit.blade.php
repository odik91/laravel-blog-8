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
              <h3 class="card-title">Permission Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('permission.update', [$permission['id']]) }}">
              @csrf
              @method('PATCH')
              <div class="card-body">
                <div class="form-group">
                  <select class="form-control" name="role_id">
                    <option value="{{ $permission['role_id'] }}">{{ $permission->rolePermission['name'] }}</option>
                  </select>
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
                  <tbody>
                    @php
                    $menu_id = explode(',', $permission['menu_id']);
                    $menus = App\Models\Menu::whereIn('id', $menu_id)->get();
                    @endphp
                    @foreach (App\Models\Menu::orderBy('menu', 'asc')->get() as $menu)
                    @if (count(App\Models\Submenus::where('menu_id', $menu['id'])->get()) > 0)
                    <tr>
                      <td>{{ $menu['menu'] }}</td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="menuEnable{{ $menu['id'] }}" name="enable[]"
                            value="{{ $menu['id'] }}" {{ (in_array($menu['id'], $menu_id)) ? "checked" : '' }}>
                          <label for="menuEnable{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="view{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][view]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['view'])) ? "checked" : '' }}>
                          <label for="view{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="create{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][create]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['create'])) ? "checked" : '' }}>
                          <label for="create{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="edit{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][edit]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['edit'])) ? "checked" : '' }}>
                          <label for="edit{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="delete{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][delete]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['delete'])) ? "checked" : '' }}>
                          <label for="delete{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="trash{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][trash]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['trash'])) ? "checked" : '' }}>
                          <label for="trash{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="restore{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][restore]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['restore'])) ? "checked" : '' }}>
                          <label for="restore{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="remove{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][remove]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['remove'])) ? "checked" : '' }}>
                          <label for="remove{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="other{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][other]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['other'])) ? "checked" : '' }}>
                          <label for="other{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                    </tr>
                    @elseif (strtolower($menu['menu']) == 'comment')
                    <tr>
                      <td>{{ $menu['menu'] }}</td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="menuEnable{{ $menu['id'] }}" name="enable[]"
                            value="{{ $menu['id'] }}" {{ (in_array($menu['id'], $menu_id)) ? "checked" : '' }}>
                          <label for="menuEnable{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="view{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][view]"
                            value="1" value="1" {{ (isset($permission['name'][$menu['id']]['view'])) ? "checked" : '' }}>
                          <label for="view{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="delete{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][delete]" value="1" value="1" {{ (isset($permission['name'][$menu['id']]['delete'])) ? "checked" : '' }}>
                          <label for="delete{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline text">
                          <input type="checkbox" id="other{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][other]" value="1" value="1" {{ (isset($permission['name'][$menu['id']]['other'])) ? "checked" : '' }}>
                          <label for="other{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                    </tr>
                    @else
                    <tr>
                      <td>{{ $menu['menu'] }}</td>
                      <td class="text-center">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="menuEnable{{ $menu['id'] }}" name="enable[]"
                            value="{{ $menu['id'] }}" {{ (in_array($menu['id'], $menu_id)) ? "checked" : '' }}>
                          <label for="menuEnable{{ $menu['id'] }}">
                          </label>
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
                          <input type="checkbox" id="other{{ $menu['id'] }}" name="name[{{ $menu['id'] }}][other]"
                            value="1" {{ (isset($permission['name'][$menu['id']]['other'])) ? "checked" : '' }}>
                          <label for="other{{ $menu['id'] }}">
                          </label>
                        </div>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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