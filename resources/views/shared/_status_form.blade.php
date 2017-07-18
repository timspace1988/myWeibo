<form action="{{route('statuses.store')}}" method="post">
  @include('shared._errors')
  {{csrf_field()}}
  <input type="hidden" name="haveImage" id="haveImage" value="no">
  <textarea class="form-control" name="content" rows="8" placeholder="Write yor status...">{{old('content')}}</textarea>
  <div class="row" style="margin:0">
    <div id="uploaded-panel" class="col-sm-12 col-md-6" style="padding:0;" data-cleanfolder="dirty">

    </div>
    <div id="upload-template" class="col-sm-4 col-md-4 thumbnail hidden">
      <span class="close" type="submit" style="opacity:0.6"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
  </div>
  <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-image-upload">
    <span class="fa fa-image"></span> Image
  </button>

  <button type="submit" class="btn btn-primary pull-right">Post</button>


</form>
