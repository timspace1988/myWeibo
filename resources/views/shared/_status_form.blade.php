<form action="{{route('statuses.store')}}" method="post">
  @include('shared._errors')
  {{csrf_field()}}
  <textarea class="form-control" name="content" rows="8" placeholder="Write yor status...">{{old('content')}}</textarea>
  <button type="submit" class="btn btn-primary pull-right">Post</button>
</form>
