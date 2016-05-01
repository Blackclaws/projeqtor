<?php
/* ============================================================================
 * Error page.
 */
require_once "../tool/projeqtor.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>ProjeQtOr</title>

  <link rel="stylesheet" type="text/css" href="css/ProjeQtOr.css" />

  <script type="text/javascript" src="../../external/dojo/dojo.js"
    djConfig="parseOnLoad:true, isDebug:false">
  </script>
  
  <script type="text/javascript">
    dojo.require("dijit.layout.BorderContainer");
    dojo.require("dijit.layout.ContentPane");

    var formSubmit = function(e){
      e.preventDefault(); 
      dojo.xhrPost({
        url: "editObject.php",
        form: "mainForm",
        handleAs: "text",
        load: function(data,args){
          var contentNode = dojo.byId("detail");
  		dojo.fadeOut({
  			node: contentNode,
  			onEnd: function(){
  			  contentNode.innerHTML = data; 
  			  dojo.fadeIn({node: contentNode}).play();    
  			}
  		}).play();
        },
        error: function(error,args){
  		console.warn("error!",error);
        }
      });
    };
    
    dojo.addOnLoad(function(){
      var theForm = dojo.byId("mainForm");
      dojo.connect(theForm,"onsubmit",formSubmit);
    }); 

  </script>

</head>
<body >
<div id="content"> 
<?php echo i18n("messageError");?>
</div>
</body>
</html>
