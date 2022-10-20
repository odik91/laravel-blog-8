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
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Post</a></li>
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
            <h3 class="card-title">Post Trash</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Slug</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Content</th>
                  <th>Image</th>
                  <th>Author</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($posts as $key => $post)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ ucfirst($post['title']) }}</td>
                  <td>{{ $post['slug'] }}</td>
                  <td>{{ ucfirst($post->getCategory['name']) }}</td>
                  <td>{{ ucfirst($post->getSubcategory['subname']) }}</td>
                  <td>{!! substr($post['content'], 0, 50) !!}...</td>
                  <td><img src="{{ asset('post/' . $post['image']) }}" alt="" class="img-thumbnail" width="150"></td>
                  <td>{{ ucfirst($post->getUser['name']) }}</td>
                  <td>
                    <a href="{{ route('posts.restore', $post['id']) }}" class="btn btn-warning mb-1" title="restore"><i class="fas fa-trash-restore"></i></a></a>
                    <a href="#" class="btn btn-danger mb-1" title="delete" data-toggle="modal" data-target="#ModalCenter{{ $post['id'] }}"><i class="fas fa-dumpster-fire"></i></a>
                    <!-- Modal -->
                    <div class="modal fade" id="ModalCenter{{ $post['id'] }}" tabindex="-1" role="dialog"
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
                            Are you sure want to delete <b>{{ ucfirst($post['title']) }}</b> permanetly?
                          </div>
                          <div class="modal-footer">
                            <form action="{{ route('posts.remove', $post['id']) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Slug</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Content</th>
                  <th>Image</th>
                  <th>Author</th>
                  <th>Action</th>
                </tr>
              </tfoot>
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