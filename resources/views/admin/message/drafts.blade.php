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
    <div class="row">
      <div class="col-md-3">
        <a href="{{ route('message.compose') }}" class="btn btn-primary btn-block mb-3">Compose</a>

        @include('admin.message.sidebar')
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Inbox</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search Mail">
                <div class="input-group-append">
                  <div class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
              <!-- Check all button -->
              <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="mark"><i
                  class="far fa-square"></i>
              </button>
              <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" id="read" title="mark as read">
                  <i class="fas fa-clipboard-check"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" id="delete">
                  <i class="far fa-trash-alt"></i>
                </button>
                {{-- <form action="{{ route('message.reply') }}" method="POST" id="formReply">
                @csrf
                <input type="hidden" name="replyList" id="replyList" value="">
                <button type="button" class="btn btn-default btn-sm" id="reply" title="reply">
                  <i class="fas fa-reply"></i>
                </button>
                </form> --}}
                <!--
                <button type="button" class="btn btn-default btn-sm" title="forward">
                  <i class="fas fa-share"></i>
                </button>
                -->
              </div>
              <!-- /.btn-group -->
              <button type="button" class="btn btn-default btn-sm" id="reload"><i class="fas fa-sync-alt"></i></button>
              <div class="float-right">
                <span
                  class="from">1-{{ (count(App\Models\Message::where('status', 'sent')->orderBy('id', 'desc')->get()) > 50) ? "50" : count(App\Models\Message::where('status', 'sent')->orderBy('id', 'desc')->get()) }}</span>/<span
                  class="to">{{ count(App\Models\Message::where('drafts', 'drafts')->get()) }}</span>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" id="previous"><i
                      class="fas fa-chevron-left"></i></button>
                  <button type="button" class="btn btn-default btn-sm" id="next"><i
                      class="fas fa-chevron-right"></i></button>
                </div>
                <!-- /.btn-group -->
              </div>
              <!-- /.float-right -->
            </div>
            <div class="table-responsive mailbox-messages">
              <table class="table table-hover table-striped">
                <tbody id="mailing">
                  @foreach ($messages as $message)
                  <tr id="listingClicked">
                    <td>
                      <div class="icheck-primary">
                        <input type="checkbox" name="selection" value="{{ $message['id'] }}"
                          id="check{{ $message['id'] }}">
                        <label for="check{{ $message['id'] }}"></label>
                      </div>
                    </td>
                    <td class="mailbox-star">
                      <button type="button" name="star[]" class="btn btn-outline-secondary border-0">
                        <i class="fas fa-star {{ ($message['star'] == 'star') ? "text-warning" : "text-muted" }}"></i>
                      </button>
                      <input type="hidden" name="ajxId" value="{{ $message['id'] }}" class="ajxId">
                    </td>
                    <td class="mailbox-name"><a href="{{ route('message.editMessage', [$message['id']]) }}"
                        class="text-dark">{{ ucwords($message['name']) }}</a></td>
                    <td class="mailbox-subject">
                      <a href="{{ route('message.editMessage', [$message['id']]) }}" class="text-dark">
                        @php
                        if ($message['read'] == 'unread') {
                        if (strlen($message['subject']) > 62) {
                        echo "<b>";
                          echo ucfirst(strip_tags(substr($message['subject'], 0, 62))) . "...";
                          echo "</b>";
                        } else {
                        echo "<b>";
                          echo ucfirst($message['subject']);
                          echo "</b>";
                        }
                        } else {
                        if (strlen($message['subject']) > 62) {
                        echo ucfirst(strip_tags(substr($message['subject'], 0, 62))) . "...";
                        } else {
                        echo ucfirst($message['subject']);
                        }
                        }
                        @endphp
                      </a>
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date">
                      @php
                      $sendTime = strtotime($message['created_at']);
                      $date = time();
                      $diff = ($date - $sendTime) / 60;

                      if ($diff < 60) { echo round($diff) . " min ago" ; } elseif ($diff < (60 * 60)) { if
                        (floor($diff / 60)> 24) {
                        echo floor($diff / 60 / 24) . " days ago";
                        } else {
                        echo floor($diff / 60) . " hours ago";

                        }
                        } else {
                        echo date_format(date_create(substr($message['created_at'], 0, (strlen($message['created_at']) -
                        9))), "D, d M Y");
                        }
                        @endphp
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
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
<script src="{{ asset('js/message.js') }}"></script>
<script>
  $(function () {
    @if (Session::has('message'))
      $(document).ready(function() {
        toastr.success("{!! Session::get('message') !!}")
      });
    @endif
  });

  let indexOffset = 0;
  let count = {{ count(App\Models\Message::where('drafts', 'drafts')->get()) }};
    
  // console.log(count);
  let baseURL = "{{ route('message.index') }}";
  let routing = "{{ route('message.nextDraftsPage') }}";

  let i = 0;

  $(document).ready(() => {
    let baseURL = "{{ route('message.index') }}";
    $('#next').click(() => {
      nextPrevSent('next', routing, baseURL);      
      $('#mark').html("<i class=\"far fa-square\"></i>");
      i = 0;
    });

    $('#previous').click(() => {
      nextPrevSent('previous', routing, baseURL);  
      $('#mark').html("<i class=\"far fa-square\"></i>");
      i = 0;
    })
  });

  $("#delete").click(() => {
    let routingCheckedInput = "{{ route('message.delete') }}";
    checkedInput('delete', 'drafts', routingCheckedInput);
    refresh(baseURL, "{{ route('message.nextDraftsPage') }}", "{{ route('message.inboxCount') }}", 'drafts');
  });
  
  $('#mark').click(() => {
    // console.log(i);
    if (i == 0) {
      i++;
      // $('#mark').html("");
      $('#mark').html("<i class=\"far fa-check-square\"></i>");
      $('input:checkbox[name=selection]').each(function() {
        $(this).attr('checked', true);
      });
    } else {
      i = 0;
      $('#mark').html("<i class=\"far fa-square\"></i>");
      $('input:checkbox[name=selection]').each(function() {
        $(this).attr('checked', false);
      });
    }
  });

  $('#reply').click(() => {
    $('input:checkbox[name=selection]:checked').each(function() {
      // selectItem.push(parseInt($(this).val()));
      $('#formReply').append(
        "<input type='hidden' name='idReply[]' value='" + parseInt($(this).val()) + "'>"
      );
    });

    $('#formReply').submit();
  });

  $(document).ready(() => {
    starred(baseURL);
  });

  $('#read').click(() => {
    let routing = "{{ route('message.markRead') }}";
    read(routing);
    refresh(baseURL, "{{ route('message.nextDraftsPage') }}", "{{ route('message.inboxCount') }}", 'drafts');
  });

  $('#reload').click(() => {
    let baseURL = "{{ route('message.index') }}";
    let routing = "{{ route('message.nextDraftsPage') }}";
    let targetCountRoute = "{{ route('message.inboxCount') }}";
    refresh(baseURL, routing, targetCountRoute, 'drafts');
  });  
</script>
@endpush