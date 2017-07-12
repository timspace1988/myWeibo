<form action="{{route('statuses.store')}}" method="post">
  @include('shared._errors')
  {{csrf_field()}}
  <textarea class="form-control" name="content" rows="8" placeholder="Write yor status...">{{old('content')}}</textarea>
  <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-image-upload">
    <span class="fa fa-image"></span> Image
  </button>

  <button type="submit" class="btn btn-primary pull-right">Post</button>


</form>
@include('statuses._modals')
