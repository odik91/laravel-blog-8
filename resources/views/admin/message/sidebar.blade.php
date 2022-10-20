<div class="card">
  <div class="card-header">
    <h3 class="card-title">Folders</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
      <li class="nav-item active">
        <a href="{{ route('message.index') }}" class="nav-link">
          <i class="fas fa-inbox"></i> Inbox
          <span class="badge bg-primary float-right inbox">{{ count(App\Models\Message::where('read', 'unread')->where('drafts', '!=' ,'drafts')->get()) }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('message.sent') }}" class="nav-link">
          <i class="far fa-envelope"></i> Sent
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('message.drafts') }}" class="nav-link">
          <i class="far fa-file-alt"></i> Drafts
          <span class="badge bg-info float-right drafts">{{ count(App\Models\Message::where('drafts', 'drafts')->get()) }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('message.trash') }}" class="nav-link">
          <i class="far fa-trash-alt"></i> Trash
          @if (count(App\Models\Message::onlyTrashed()->get()) != 0)
            <span class="badge bg-danger float-right trash">{{ count(App\Models\Message::onlyTrashed()->get()) }}</span>
          @endif
        </a>
      </li>
    </ul>
  </div>
  <!-- /.card-body -->
</div>