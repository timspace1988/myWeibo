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
      //bind upload image upload function to modal
      $('#upload').on('submit', function(e){
        //$("#modal-image-upload [data-dismiss='modal']").trigger("click");//close the modal dialog
        e.preventDefault();
        var formData = new FormData(this);


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
            $("#modal-image-upload [data-dismiss='modal']").trigger("click");//close the modal dialog

            var panel = $("#uploaded-panel")//the panel to contain uploaded image
            var urlSet = data.urlSet;
            var pathSet = data.pathSet;

            for(var key in urlSet){
              var src = urlSet[key];
              var path = pathSet[key];
              var newUpload = $("#upload-template").clone();
              newUpload.removeAttr("id");
              newUpload.css({
                "background": "url("+src+") no-repeat center",
                "background-size":"cover"
              });
              panel.append(newUpload);
              newUpload.removeClass("hidden");
              newUpload.height( newUpload.width());//set height same with width
              var removeFunc = "remove('{{ route('upload.remove') }}', '"+path+"', this)";
              newUpload.find("span").first().attr({
                "data-path": path,
                "onclick": removeFunc
              });
              //newUpload.find("span").first().attr("data-path",pathSet[key]);
              //newUpload.find("span").first().data("path",pathSet[key]);
              //note: you can set custom attr using data("*", xx),(not working, confused)
              //but you need to use attr("data-*", xx) to change a an existing custom attr
            }


          },
          error: function(xhr, status, error) {
            alert(xhr.responseText);
            alert(error);
          }
        });
      });
    });

    //Remove an uploaded image from upload panel
    function remove(route, path, removeButton){
      var toRemove = $(removeButton).parent();
      toRemove.fadeOut("slow", function(){
        $(this).remove();
      });

      $.ajax({
        type: "POST",
        url: route,
        data: {_method: 'delete', path: path},
        // dataType: 'json',
        // contentType:false,
        // processData: false,
        headers: {
           'X-CSRF-Token': "{{csrf_token()}}"
         },
        success: function(data){
          if(data.message != "deleted"){
            alert('Something went wrong, please refresh page.');
            exit();
          }
        },
        error: function(xhr, status, error){
          //console.log(JSON.stringify(xhr));
          console.log("AJAX error: " + status + ' : ' + error);
          var newWindow = window.open();
          newWindow.document.write(xhr.responseText);
        }
      });
    }
    </script>
  </body>
</html>
