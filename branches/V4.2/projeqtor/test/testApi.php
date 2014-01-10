<?php
$url=$_SERVER['REQUEST_URI'];
$srv=$_SERVER['SERVER_ADDR'];
$pos=strpos($url,'/test/');
$urlRoot=substr($url,0,$pos);
$service_url = 'http://'.$srv.$urlRoot.'/api';

//var_dump($_SERVER);
$curl_post_data="";
$cronnedScript=true;
$batchMode=true;
require_once "../tool/projeqtor.php";
$user=new User(); 
$_SESSION['user']=$user;

$action="display";
if (isset($_REQUEST['action'])) {
	$action=$_REQUEST['action'];
}
$object=null;
if (isset($_REQUEST['object'])) {
  $object=$_REQUEST['object'];
}
$id=null;
if (isset($_REQUEST['id'])) {
  $id=$_REQUEST['id'];
}
$list=null;
if (isset($_REQUEST['list'])) {
  $list=$_REQUEST['list'];
}
$filter=null;
if (isset($_REQUEST['filter'])) {
  $filter=$_REQUEST['filter'];
}
if ($action=='display') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"
    djConfig='modulePaths: {i18n: "../../tool/i18n"}, parseOnLoad: true, isDebug: false'></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.parser");
    dojo.require("dojo.date");
    dojo.require("dojo.date.locale");
    dojo.require("dojo.number");
    dojo.require("dijit.focus");
    dojo.require("dojo.i18n");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
    dojo.require("dijit.form.Form");
    dojo.require("dijit.form.FilteringSelect");
    function runApi(context) {
      var url='testApi.php?action=GET&object='+dojo.byId("object").options[dojo.byId("object").selectedIndex].text;
      if (context=='byId') { url+='&id='+dojo.byId("id").value; }
      if (context=='listAll') { url+='&list=all'; }
      if (context=='listFilter') { url+='&list=filter&filter='+dojo.byId("filterId").value; }
      dojo.byId('result').innerHTML="";
      dojo.byId('resultUrl').innerHTML="";
      document.body.style.cursor = 'wait';
      dojo.xhrGet({
        url: url,
        handleAs: "text",
        load: function (data) {
          //alert(data);
          var spl=data.split('#$#$#');
          dojo.byId('resultUrl').innerHTML=spl[0];
          dojo.byId('result').innerHTML=spl[1];
          document.body.style.cursor = 'default';
        },
        error: function () {
          document.body.style.cursor = 'default';
          alert('error');
        }
      });
    }
  </script>
</head>

<body>
<table>
<tr>
<td style="border:1px solid grey">Class of object<br/>
Object : <select class="input" name="object" id="object">
<?php htmlDrawOptionForReference('idImportable', null, null, true);?>
</select>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey">Get item by id<br/>
  Id : <input type="text" name="id" id="id" /><br/>
  <button onClick="runApi('byId');" >Get item</button>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey">Get all items<br/>
  <button onClick="runApi('listAll');" >Get all items</button>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey">Get items from filter<br/>
  Filter id : <input type="text" name="filterId" id="filterId" /><br/>
  <button onClick="runApi('listFilter');" >Get items</button>
</td>
</tr>
</table>
<div id="resultUrl" style="font-weight: bold;width:100%;height:5%;border:1px solid black;"><i>url will come here</i></div>
<div id="result" style="width:100%;border:1px solid black;"><i>result will come here</i></div>
</body>
</html>
<?php } else {

//echo $service_url;
if ($id) {
	$fullUrl=$service_url.'/'.$object.'/'.$id;
} else if ($list and $list=='all') {
	$fullUrl=$service_url.'/'.$object.'/all';	
} else if ($list and $list=='filter'){
	$fullUrl=$service_url.'/'.$object.'/filter/'.$filter; 
} else {
	echo "invalid query";
	exit;
}

$curl = curl_init($fullUrl);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, "projeqtor:projeqtor");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$curl_response = curl_exec($curl);
echo $fullUrl;
echo "#$#$#";
echo $curl_response;
curl_close($curl);
}