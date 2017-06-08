<li id="status-{{$status->id}}">
  <a href="{{route('users.show', $user->id)}}">
    <img src="{{$user->gravatar()}}" alt="{{$user->name}}" class="gravatar">
  </a>
  <span class="user">
    <a href="{{route('users.show', $user->id)}}">{{$user->name}}</a>
  </span>
  <span class="timestamp">
    {{$status->created_at->diffForHumans()}}<!--difForHumans will display the date as 'xx days ago' format-->
  </span>
  <span class="content">{{$status->content}}</span>
  @can('destroy', $status)
    <form action="{{route('statuses.destroy', $status->id)}}" method="post">
      {{csrf_field()}}
      {{method_field('DELETE')}}
      <button type="submit" class="btn btn-sm btn-danger status-delete-btn">Delete</button>
    </form>
  @endcan
</li>
