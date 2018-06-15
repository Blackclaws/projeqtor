var screenHeight=$(window).height(); 
$( document ).ready(function() {
  $("#editor").height($(window).height()-$("#buttonDiv").height()-$(".title").height()-30);
  //$("#preview").width($("#errorDiv").width());
});
$("#editor").on("change", convertEditor);
var changeInProgress=false;

function selectFile(file) {
  if (changeInProgress) {
    $("#resultMsg").html(errorMsg("save or cancell before selecting new file"));
    $("#selectedFile").val($("#file").val());
    return;
  }
  $("#file").val(file);
  $.ajax({
    url: "controller.php",
    data: {
      action: "getFile",
      file: file
    },
    success: function( result ) {
      $("#editor").val(result);
      convertEditor();
      $("#resultMsg").html("");
    }
  });
  
}
function detectKey(event) {
  if (event.keyCode == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey) && ! event.altKey) { // CTRL + S (save)
    event.preventDefault();
    saveFile();
    changeInProgress=false;
  } else {
    changeInProgress=true;
  }
}

function convertEditor() {
  $("#action").val("convert");
  $.ajax({
    type: "POST",
    url: "controller.php",
    data: $("#editorForm").serialize(), 
    success: function(result){
      var errors="";
      posErr=result.indexOf('/!\\');
      while (posErr>=0) {
        posEnd=result.indexOf('<br/>')+5;
        errors+=result.substring(posErr+4,posEnd);
        result=result.substr(posEnd);
        posErr=result.indexOf('/!\\');
      }
      if (errors) {
        $("#errorDiv").html(errors);
        $("#errorDiv").height(150);
      } else {
        $("#errorDiv").html("");
        $("#errorDiv").height(0);
      }
      $("#preview").html(result);
      $("li:contains('Field')").addClass('tableHeader');
      $("li:contains('Description')").addClass('tableHeader');
      $("li:has('a')").removeClass('tableHeader');
    }
  });
}

function saveFile() {
  $("#action").val("save");
  if (!$("#file").val()) {
    $("#resultMsg").html(errorMsg("no file to save"));
    return;
  }
  $.ajax({
    type: "POST",
    url: "controller.php",
    data: $("#editorForm").serialize(), 
    success: function(result){
      if (result.indexOf('Fatal')==-1 && result.indexOf('Error')==-1 && result.indexOf('Notice')==-1 && result.indexOf('Warning')==-1) {
        $("#resultMsg").html(result);
        setTimeout('$("#resultMsg").html("");',2000);
        changeInProgress=false;
      } else {
        $("#resultMsg").html(errorMsg(result));
      }
    }
  });
}
function errorMsg(msg) {
  return '<span style="color:red">'+msg+'</span>';
}

function undoFile() {
  changeInProgress=false;
  $("#resultMsg").html("");
  if (!$("#file").val()) {
    $("#editor").val("");
    convertEditor();
  } else {
    selectFile($("#file").val());
  }
}

function switchTo(mode) {
  if (changeInProgress) {
    $("#resultMsg").html(errorMsg("save or cancell before selecting new file"));
    $("#selectedFile").val($("#file").val());
    return;
  }
  window.location='index.php?mode='+mode;
}