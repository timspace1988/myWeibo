<li id="status-{{$status->id}}">
  <a href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
  </a>
  <span class="user">
    <a href="{{ route('users.show', $user->id )}}">{{ $user->name }}</a>
  </span>
  <span class="timestamp">
    {{ $status->created_at->diffForHumans() }}<!--difForHumans will display the date as 'xx days ago' format-->
  </span>
  <span class="content">{{$status->content}}</span>
  @if($uploadManager->exists($status->id))

    <div class="container" style="width:100%; margin-left:60px; padding-left:0; padding-right:60px;">
      <div class="row postPanel">
        <div class="col-sm-12 col-md-6 image-wrapper">
          @foreach($uploadManager->getAllFilesAt($status->id, true) as $src)
          <div class="col-sm-4 col-md-4 thumbnail post-image" onclick="preview('{{$src}}')" style="background:url('{{$src}}') no-repeat center; background-size:cover; margin-bottom:0; cursor:pointer">

          </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif
  @can('destroy', $status)
        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit" class="btn btn-sm btn-danger status-delete-btn">Delete</button>
        </form>
  @endcan
</li>
