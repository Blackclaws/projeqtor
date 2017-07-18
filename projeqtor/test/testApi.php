<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

// FIX FOR IIS
$cronnedScript=true;
$batchMode=true;
require_once "../tool/projeqtor.php";
if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
	if (isset($_SERVER['QUERY_STRING'])) { $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; }
}
$url=$_SERVER['REQUEST_URI'];
$srv=$_SERVER['SERVER_NAME'];
$pos=strpos($url,'/test/');
$urlRoot=substr($url,0,$pos);
$service_url = 'http://'.$srv.$urlRoot.'/api';
$userParam="admin";
$passwordParam="admin";
$userApi=SqlElement::getSingleSqlElementFromCriteria('User', array('name'=>$userParam));
$apiKeyParam=$userApi->apiKey;
//var_dump($_SERVER);
$curl_post_data="";
$user=new User(); 
setSessionUser($user);

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
if (isset($_REQUEST['user'])) {
	$userParam=$_REQUEST['user'];
}
if (isset($_REQUEST['password'])) {
	$passwordParam=$_REQUEST['password'];
}
if (isset($_REQUEST['apikey'])) {
	$apiKeyParam=$_REQUEST['apikey'];
}
$searchParameters="";
for ($i=1;$i<=3;$i++) {
	if (isset($_REQUEST['crit'.$i])) {
		$searchParameters.="/".urlencode($_REQUEST['crit'.$i]);
	}
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
    function runApi(callMode, context) {
      var url='testApi.php?action='+callMode+'&object='+dojo.byId("object").options[dojo.byId("object").selectedIndex].text;
			if (callMode=="GET") {
	      if (context=='byId') { url+='&id='+dojo.byId("id").value; }
	      if (context=='listAll') { url+='&list=all'; }
	      if (context=='listFilter') { url+='&list=filter&filter='+dojo.byId("filterId").value; }
	      if (context=='search') {
          for (var i=1;i<=3;i++) {
            if (dojo.byId("crit"+i).value) {
            	url+="&list=search";
            	url+="&crit"+i+"="+encodeURI(dojo.byId("crit"+i).value);
            }
          }
	      }
			} else {
				url+='&data='+encodeURIComponent(dojo.byId("result").value);
			}
      url+='&user='+dojo.byId("user").value+'&password='+dojo.byId("password").value;
      url+='&apikey='+dojo.byId("apikey").value;
      dojo.byId('result').innerHTML="";
      dojo.byId('resultUrl').innerHTML="";
      document.body.style.cursor = 'wait';
      //console.log to keep
      console.log(url);
      dojo.xhrGet({
        url: url,
        handleAs: "text",
        load: function (data) {
          //alert(data);
          var spl=data.split('#$#$#');
          dojo.byId('resultUrl').innerHTML=spl[0];
          dojo.byId('result').value=spl[1];
          document.body.style.cursor = 'default';
        },
        error: function () {
          document.body.style.cursor = 'default';
          alert('error');
        }
      });
    }
  </script>
  <style type="text/css">
    body {
      font-family: arial;
    }
    .line {
      height: 25px;
      text-align: right;
      font-family: arial;
    }
    .title {
      font-weight: bold;
      text-align: center !important;
    }
    .button {
      text-align: center !important;
    }
  </style>
</head>

<body>
<table>
<tr>
<td style="border:1px solid grey">
  <div class="line">user : <input type="text" name="user" id="user" value="<?php echo $userParam;?>"/></div>
  <div class="line">password : <input type="text" name="password" id="password" value="<?php echo $passwordParam;?>"/></div>
  <div class="line">API key : <input type="text" name="apikey" id="apikey" value="<?php echo $apiKeyParam;?>"/></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey"><div class="line title">Class of object</div>
<div class="line">Object : <select class="input" name="object" id="object">
<?php 
//htmlDrawOptionForReference('idImportable', null, null, true);
foreach (SqlList::getListNotTranslated('Importable') as $id=>$val) {
  echo "<option valued='$val' >$val</option>";
}
?>
<option value="User">User</option>
<option value="History">History</option>
</select></div>
<div class="line"></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey"><div class="line title">Get item by id</div>
  <div class="line">Id : <input type="text" name="id" id="id" /></div>
  <div class="line button"><button onClick="runApi('GET','byId');" >Get item</button></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey"><div class="line title">Get all items</div>
  <div class="line"></div>
  <div class="line button"><button onClick="runApi('GET','listAll');" >Get all items</button></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey"><div class="line title">Get items from filter</div>
  <div class="line">Filter id : <input type="text" name="filterId" id="filterId" /></div>
  <div class="line button"><button onClick="runApi('GET','listFilter');" >Get items</button></div>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border:1px solid grey"><div class="line title">Update Json Item (in result)</div>
  <div class="line button"><button onClick="runApi('PUT','');" >PUT item</button>
                           <button onClick="runApi('POST','');" >POST item</button></div>
  <div class="line button"><button onClick="runApi('DELETE','');" >DELETE item</button></div>
</td>
</tr>
<tr>
<td colspan="12" style="border:1px solid grey">
  <span class="line title">Search criteria (sql like)</span>
  <span class="line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;crit1: <input style="width:250px" type="text" name="crit1" id="crit1" /></span>
  <span class="line">&nbsp;&nbsp;&nbsp;crit2: <input style="width:250px" type="text" name="crit2" id="crit2" /></span>
  <span class="line">&nbsp;&nbsp;&nbsp;crit3: <input style="width:250px" type="text" name="crit3" id="crit3" /></span>
  <span class="line button"><button onClick="runApi('GET','search');" >Get items</button></span>
</td>
</tr>
</table>
<div id="resultUrl" style="font-weight: bold;width:100%;height:5%;border:1px solid black;"><i>url will come here</i></div>
<textarea id="result" style="width:100%;border:1px solid black; height: 500px">result will come here</textarea>
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
} else if ($list and $list=='search'){
	$fullUrl=$service_url.'/'.$object.'/search'.$searchParameters;
} else if ($action=="PUT" or $action=="POST" or $action=="DELETE") {
  $fullUrl=$service_url.'/'.$object."?confirmed=true";
  if (isset($_REQUEST['data'])) {
    $data=$_REQUEST['data'];
  } else {
    $data='{"id":""}';
  }
  /*if ($action=="DELETE") {
    $dataArray=json_decode($data,true);
    if (isset($dataArray['items'])) {
      $id=$dataArray['items'][0]['id'];
    } else {
      $id=$dataArray['id'];
    }
    $fullUrl.='/'.$id;
  }*/
  require_once "../external/phpAES/aes.class.php";
  require_once "../external/phpAES/aesctr.class.php";
  $data=AesCtr::encrypt($data, $apiKeyParam, Parameter::getGlobalParameter('aesKeyLength'));
} else {
	echo "invalid query - API not called#$#$#";
	exit;
}

$curl = curl_init($fullUrl);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, "$userParam:$passwordParam");
//curl_setopt($curl, CURLOPT_USERPWD, "admin:admin");
//curl_setopt($curl, CURLOPT_USERPWD, "manager:manager");
//curl_setopt($curl, CURLOPT_USERPWD, "supervisor:supervisor");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
if (isset($_REQUEST['data'])) {
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
  if ($action=="POST") { 
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array('data'=>$data));
  } else if ($action=="PUT" or $action=="DELETE") {
	  curl_setopt($curl, CURLOPT_POST, true);
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
  
	//curl_setopt($curl, CURLOPT_POSTFIELDS, array('data'=>$data));
}
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$curl_response = curl_exec($curl);
echo $action. " => ". $fullUrl;
echo "#$#$#";
echo $curl_response;
curl_close($curl);
}