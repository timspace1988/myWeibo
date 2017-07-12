{{-- Upload Image Modal --}}
<div class="modal fade" id="modal-image-upload">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="upload" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Upload New Image</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="file" class="col-sm-3 control-label">Image</label>
            <div class="col-sm-8">
              <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" multiple name="files[]" id="files">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload Image</button>
        </div>
      </form>
    </div>
  </div>
</div>
