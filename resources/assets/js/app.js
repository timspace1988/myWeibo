window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

$(document).ready(function(){
  enableEmoji();
  squareImage();

  //bind upload image upload function to modal
  $('#upload').on('submit', function(e){
    //$("#modal-image-upload [data-dismiss='modal']").trigger("click");//close the modal dialog
    e.preventDefault();
    var formData = new FormData(this);
    formData.append("cleanFolder", $("#uploaded-panel").attr("data-cleanfolder"));

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

          //last thing is to set haveImage to yes
          haveImage();
        }


      },
      error: function(xhr, status, error) {
        // alert(xhr.responseText);
        // alert(error);
        var newWindow = window.open();
        newWindow.document.write(xhr.responseText);
      }
    });
  });

  //bind emoji insert
  $("div.emojis>div>img.emoji").bind("click", function(){
    var statusInput = $("#status-input");
    var text = statusInput.val();
    var emoji = $(this).attr("alt");

    var caretPos = statusInput[0].selectionStart;

    var newText = text.substring(0, caretPos) + emoji + text.substring(caretPos);
    //var newText = text + emoji;
    statusInput.val(newText);

    $("#modal-emoji-insert [data-dismiss='modal']").trigger("click");//close the modal dialog
    //alert(text);
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
      //check if we need to set haveImage field as no
      haveImage();

      //we have already removed uploaded image elements from image panel
      //following codes is to check if the images files have been removed from filesystem
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

//Check and set if post contains images
function haveImage(){
  var panel = $("#uploaded-panel")//the panel to contain uploaded image
  var haveImage = $("#haveImage");
  if(panel.children().length>0){
    haveImage.val("yes");
  }else{
    haveImage.val("no");
  }

  //when we first access image panel page, we need clean the folder in case for old files existing
  //after we perform any successful image panel operation(upload or remove), we set folderclean as no
  panel.attr("data-cleanfolder", "cleaned");
}

//if a posted status has images, we need to set image's height as same of its width
function squareImage(){
  $(".post-image").each(function(i){
    $(this).height($(this).width());
  });
}

//Preview image
function preview(path){
  //alert(path);
  $("#preview-image").attr("src", path);
  $("#modal-image-view").modal("show");
}

function enableEmoji(){
  twemoji.parse(document.body);
}
