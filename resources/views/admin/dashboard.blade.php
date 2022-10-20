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
    <div class="container-fluid">
      <!-- category box -->
      <div class="card">
        <div class="card-header border-0">
          Category and Subcategory
        </div>
        <div class="card-body">
          <!-- Small boxes (Stat box) category-->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ count(App\Models\Category::all()) }}</h3>

                  <p>Category</p>
                </div>
                <div class="icon">
                  <i class="ion ion-cube"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count(App\Models\Category::onlyTrashed()->get()) }}</h3>

                  <p>Category in Trash</p>
                </div>
                <div class="icon">
                  <i class="ion ion-trash-a"></i>
                </div>
                <a href="{{ route('categories.trash') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ count(App\Models\SubCategory::all()) }}</h3>

                  <p>Subategory</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clipboard"></i>
                </div>
                <a href="{{ route('subcategories.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count(App\Models\SubCategory::onlyTrashed()->get()) }}</h3>

                  <p>Subategory in Trash</p>
                </div>
                <div class="icon">
                  <i class="ion ion-trash-a"></i>
                </div>
                <a href="{{ route('subcategories.trash') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-header">Statistic</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <!-- bar chart-->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Article count by category vs viewer</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="myChart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.bar chart-->
            </div>
            <div class="col-md-12">
              <!-- bar chart-->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Article viewer by subcategory vs viewer</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="subcatViewer" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.bar chart-->
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- post box -->
        <div class="col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              Post
            </div>
            <div class="card-body">
              <!-- Small boxes (Stat box)-->
              <div class="row">
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>{{ count(App\Models\Post::all()) }}</h3>
  
                      <p>Post</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-ios-compose-outline"></i>
                    </div>
                    <a href="{{ route('posts.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3>{{ count(App\Models\Post::onlyTrashed()->get()) }}</h3>
  
                      <p>Post in Trash</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-trash-a"></i>
                    </div>
                    <a href="{{ route('posts.trash') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Role box -->
        <div class="col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              Role
            </div>
            <div class="card-body">
              <!-- Small boxes (Stat box)-->
              <div class="row">
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>{{ count(App\Models\Role::all()) }}</h3>  
                      <p>Post</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-aperture"></i>
                    </div>
                    <a href="{{ route('role.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3>{{ count(App\Models\Role::onlyTrashed()->get()) }}</h3>  
                      <p>Post in Trash</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-trash-a"></i>
                    </div>
                    <a href="{{ route('role.trash') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>

      <div class="row">
        <!-- post box -->
        <div class="col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              Comment
            </div>
            <div class="card-body">
              <!-- Small boxes (Stat box)-->
              <div class="row">
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>{{ count(App\Models\Comment::all()) }}</h3>
  
                      <p>Comment</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-speakerphone"></i>
                    </div>
                    <a href="{{ route('comment.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3>{{ count(App\Models\ReplayComment::all()) }}</h3>
  
                      <p>Subcomment</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-ios-chatbubble-outline"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Role box -->
        <div class="col-md-6 col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              User
            </div>
            <div class="card-body">
              <!-- Small boxes (Stat box)-->
              <div class="row">
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3>{{ count(App\Models\User::all()) }}</h3>  
                      <p>Users</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3>{{ count(App\Models\User::onlyTrashed()->get()) }}</h3>  
                      <p>Post in Trash</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-trash-a"></i>
                    </div>
                    <a href="{{ route('users.trash') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>

      <!-- Message -->
      <div class="card">
        <div class="card-header border-0">
          Message
        </div>
        <div class="card-body">
          <!-- Small boxes (Stat box) category-->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{ count(App\Models\Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->get()) }}</h3>

                  <p>Inbox</p>
                </div>
                <div class="icon">
                  <i class="fas fa-inbox"></i>
                </div>
                <a href="{{ route('message.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ count(App\Models\Message::where('status', 'sent')->orderBy('id', 'desc')->get()) }}</h3>

                  <p>Sent</p>
                </div>
                <div class="icon">
                  <i class="far fa-envelope"></i>
                </div>
                <a href="{{ route('message.sent') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-secondary">
                <div class="inner">
                  <h3>{{ count(App\Models\Message::where('drafts', 'drafts')->orderBy('created_at', 'desc')->get()) }}</h3>

                  <p>Drafts</p>
                </div>
                <div class="icon">
                  <i class="far fa-file-alt"></i>
                </div>
                <a href="{{ route('message.drafts') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count(App\Models\Message::onlyTrashed()->get()) }}</h3>

                  <p>Trash</p>
                </div>
                <div class="icon">
                  <i class="ion ion-trash-a"></i>
                </div>
                <a href="{{ route('message.trash') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Menu & Submenu -->
      <div class="card">
        <div class="card-header border-0">
          Menus & Submenus
        </div>
        <div class="card-body">
          <!-- Small boxes (Stat box) category-->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ count(App\Models\Menu::all()) }}</h3>

                  <p>Menu</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-menu"></i>
                </div>
                <a href="{{ route('menu.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count(App\Models\Menu::onlyTrashed()->get()) }}</h3>

                  <p>Menu Trash</p>
                </div>
                <div class="icon">
                  <i class="ion ion-trash-a"></i>
                </div>
                <a href="{{ route('menu.trash') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ count(App\Models\Submenus::orderBy('created_at', 'desc')->get()) }}</h3>

                  <p>Submenu</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-paper-outline"></i>
                </div>
                <a href="{{ route('submenu.index') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count(App\Models\Submenus::onlyTrashed()->get()) }}</h3>

                  <p>Trash</p>
                </div>
                <div class="icon">
                  <i class="ion ion-trash-a"></i>
                </div>
                <a href="{{ route('submenu.trash') }}" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('addon-css')

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.css') }}">
@endpush

@push('addon-script')
  <!-- jQuery -->
  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('template/plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('template/dist/js/pages/dashboard.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('template/dist/js/demo.js') }}"></script>
  @php
    $viewer = [];
    foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category) {
      $count = 0;
      foreach (App\Models\Post::where('category_id', $category->id)->get() as $item) {
        $count += $item['views'];
      }
      array_push($viewer, $count);
    }

    $subViewer = [];
    foreach (App\Models\SubCategory::orderBy('subname', 'asc')->get() as $subcategory) {
      $count = 0;
      foreach (App\Models\Post::where('sub_category_id', $subcategory['id'])->get() as $item) {
        $count += $item['views'];
      }
      array_push($subViewer, $count);
    }
  @endphp
  <script>
    $(function () {
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          labels: [
            @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
              "{{ $category->name }}",
            @endforeach
          ],
          datasets: [
            {
              label               : 'Article count by category',
              backgroundColor     : "#3e95cd",
              borderColor         : 'rgba(60,141,188,0.8)',
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [
                @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
                  "{{ count(App\Models\Post::where('category_id', $category->id)->get()) }}",
                @endforeach
              ]
            },
            {
              label               : 'Viewer',
              backgroundColor     : 'rgba(210, 214, 222, 1)',
              borderColor         : 'rgba(210, 214, 222, 1)',
              pointRadius         : false,
              pointColor          : 'rgba(210, 214, 222, 1)',
              pointStrokeColor    : '#c1c7d1',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data                : [
                @for ($i = 0; $i < sizeof($viewer); $i++)
                  "{{ $viewer[$i] }}",
                @endfor
              ]
            },
            {
              label               : 'Ratio',
              backgroundColor     : '#f2c043',
              borderColor         : 'rgba(60,141,188,0.8)',
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [
                @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $key => $category)
                  @if (count(App\Models\Post::where('category_id', $category->id)->get()) > 0)
                  "{{ $viewer[$key] / count(App\Models\Post::where('category_id', $category->id)->get()) }}",
                  @endif
                @endforeach
              ]
            },
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              gridLines: {
                offsetGridLines: true
              }
            }]
          },
        }
      });  

      var stx = document.getElementById('subcatViewer').getContext('2d');
      var subcatViewer = new Chart(stx, {
        type: 'bar',
        data: {
          // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          labels: [
            @foreach (App\Models\SubCategory::orderBy('subname', 'asc')->get() as $subcategory)
              "{{ $subcategory->subname }}",
            @endforeach
          ],
          datasets: [
            {
              label               : 'Article count by subcategory',
              backgroundColor     : "#3e95cd",
              borderColor         : 'rgba(60,141,188,0.8)',
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [
                @foreach (App\Models\SubCategory::orderBy('subname', 'asc')->get() as $key => $subcategory)
                  "{{ count(App\Models\Post::where('sub_category_id', $subcategory->id)->get()) }}",
                @endforeach
              ]
            },
            {
              label               : 'Viewer',
              backgroundColor     : '#f2c043',
              borderColor         : 'rgba(60,141,188,0.8)',
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [
                @foreach (App\Models\SubCategory::orderBy('subname', 'asc')->get() as $key => $subcategory)
                  "{{ $subViewer[$key]}}",
                @endforeach
              ]
            },
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              gridLines: {
                offsetGridLines: true
              }
            }]
          },
        }
      });  
    })
  </script>
@endpush