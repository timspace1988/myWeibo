<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title', 'My Weibo') - A simulated Weibo app</title><!--second param is a default value-->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @include('layouts._header')

    <div class="container">
      @include('shared._messages')
      @yield('content')
      @include('layouts._footer')
    </div>

    <script src="/js/app.js"></script>
    <script>
    $(function(){
      $('#upload').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        // $.each($('#file').files, function(i, file){
        //   formData.append('files[]', file);
        // });

        $.ajax({
          type:"POST",
          url:"{{ route('upload.file') }}",
          //dataType: 'json',
          data:formData,
          contentType:false,
          processData: false,
        //   headers: {
        //    'X-CSRF-Token': $('#upload input[name="_token"]').val()
        //  },
          success:function(data){
            //alert(data.message);
            // $('#modal-image-upload').modal('toggle');//Hide the modal dialog
            // $('.modal-backdrop').remove(); //Hide the backdrop
            $("#modal-image-upload [data-dismiss='modal']").trigger("click");
          },
          error: function(xhr, status, error) {
            alert(xhr.responseText);
            alert(error);
          }
        });
      });
    });
    </script>
  </body>
</html>
