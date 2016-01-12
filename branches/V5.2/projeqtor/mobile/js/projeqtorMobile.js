/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 *
 * This file is a plugIn for ProjeQtOr.
 * This plugIn in not Open Source.
 * You must have bought the licence from Copyrigth owner to use this plgIn.
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

function showWait() {
	if (dojo.byId("wait")) {
		dojo.byId("wait").style.visibility='visible';
	}
}

function hideWait() {
	if (dojo.byId("wait")) {
		dojo.byId("wait").style.visibility='hidden';
	}
}

function connect() {
	showWait();
    dojo.byId('login').focus();
    dojo.byId('password').focus();
    var login=dijit.byId('login').get('value');  
    var crypted=Aes.Ctr.encrypt(login, aesLoginHash, 256);   
    dojo.byId('login').focus();
    dojo.xhrGet({
      url: '../tool/getHash.php?username='+encodeURIComponent(crypted),
      handleAs: "text",
      load: function (data) {
        cryptData(data);
        loadContent("../tool/loginCheck.php","loginResultDiv", "loginForm");
      }
    });
}

function disconnect() {
  disconnectFunction = function() {
    var extUrl="&cleanCookieHash=true";
    dojo.xhrPost({
      url: "../tool/saveDataToSession.php?idData=disconnect"+extUrl,
      handleAs: "text",
      load: function(data,args) { window.location="."; }
    });
  };
  //showConfirm(i18n('confirmDisconnection'),disconnectFunction);
  disconnectFunction();
}

function cryptData(data) {   
  var arr=data.split(';');
  var crypto=arr[0];
  var userSalt=arr[1];
  var sessionSalt=arr[2];
  var pwd=dijit.byId('password').get('value');
  var login=dijit.byId('login').get('value');
  dojo.byId('hashStringLogin').value=Aes.Ctr.encrypt(login, sessionSalt, 256);
  if (crypto=='md5') {
    crypted=CryptoJS.MD5(pwd+userSalt);
    crypted=CryptoJS.MD5(crypted+sessionSalt);
    dojo.byId('hashStringPassword').value=crypted;
  } else if (crypto=='sha256') {
    crypted=CryptoJS.SHA256(pwd+userSalt);
    crypted=CryptoJS.SHA256(crypted+sessionSalt);
    dojo.byId('hashStringPassword').value=crypted;
  } else {
    var crypted=Aes.Ctr.encrypt(pwd, sessionSalt, 256);
    dojo.byId('hashStringPassword').value=crypted;
  }
}

function loadContent(page, destination, formName) {
	showWait();
	var contentNode=dojo.byId(destination);
	dojo.xhrPost({
	      url: page,
	      form: dojo.byId(formName),
	      handleAs: "text",
	      load: function(data,args){
	    	  contentNode.innerHTML=data;
	    	  contentNode.style.visibility='visible';
	    	  contentNode.style.display='block';
	    	  if (destination=="loginResultDiv") {
	              checkLogin();
	    	  }
	    	  hideWait();
	      }
	});
	
}

function checkLogin() {
  resultNode=dojo.byId('validated');
  resultWidget=dojo.byId('validated');
  if (resultNode && resultWidget) {
	url=".";
    window.location=url;
  }
}

function loadItems(currentDate, keepMessage) {
	showWait();
	url='../mobile/getJsonDay.php?currentDate='+currentDate;
	dojo.xhrPost({
      url: url,
      handleAs: "text",
      load: function(data,args){
    	  fillItemsFromJson(data,keepMessage);
    	  hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
      }
	});
}

var jsonDataArray=null;
function fillItemsFromJson(json,keepMessage) {
	var jsonArray = JSON.parse(json);
	jsonDataArray=jsonArray;
	var list = dijit.byId('itemList');
	list.destroyDescendants();
	dijit.byId('dayCaption').domNode.innerHTML=jsonArray.dayCaption;
	var cpt=0;
	dojo.forEach(jsonArray.items, function (item,index) {
		var itemWidget= new dojox.mobile.ListItem({icon: item.icon, style:"height:100%;"+((item.real)?'opacity: 0.5;filter: alpha(opacity=50);':''), moveTo: "detail", id:index, onClick:function(e){fillDetailFromJson(index);}});
		itemNode='<div>'+item.nameType+" #"+item.id;
		itemNode+='<span '+((! item.real)?'onClick="saveWork(\''+item.type+'\','+item.id+',\''+jsonArray.day+'\');"':'')+' class="projeqtorActionBtn'+((item.real)?'Disabled':'')+'" style="z-index:999;font-weight:normal;position: relative; left:10px">'+item.workUnit+'<span></div>';
		itemNode+='<div  style="font-weight:normal;font-size:80%">'+item.display+'</div>';
		itemWidget.domNode.innerHTML=itemNode;
		list.addChild(itemWidget,index);
		cpt++;
	});
	if (! keepMessage) {
	  clearMessages();
	}
}
saveInProgress=false;
function saveWork(refType, refId, day) {
	showWait();
	saveInProgress=true;
	clearMessages();
	url="saveWork.php?refType="+refType+"&refId="+refId+"&day="+day;
	dojo.xhrPost({
      url: url,
      handleAs: "text",
      load: function(data,args){
    	  showMessage(data, 'Detail');
    	  loadItems(day, true);
    	  saveInProgress=false;
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
    	  saveInProgress=false;
      }
	});
}
function saveDetail() {
	showWait();
	saveInProgress=true;
	clearMessages();
	url="saveDetail.php";
	dojo.xhrPost({
      url: url,
      form: 'detailForm',
      handleAs: "text",
      load: function(data,args){
    	  showMessage(data, 'Detail');
    	  saveInProgress=false;
    	  hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
    	  saveInProgress=false;
      }
	});
}


function clearMessages() {
	if (dojo.byId('resultDivDetail')) {
		dojo.byId('resultDivDetail').style.visibility="hidden";
		dojo.byId('resultDivDetail').style.display="none";
		dojo.byId('resultDivDetail').innerHTML='';
	}
	if (dojo.byId('resultDivList')) {
		dojo.byId('resultDivList').style.visibility="hidden";
		dojo.byId('resultDivList').style.display="none";
		dojo.byId('resultDivList').innerHTML='';
	}
}
function showMessage(message, section, type) {
	var resulDiv = dojo.byId('resultDiv'+section);
	if (resulDiv) {
		resulDiv.style.visibility="visible";
		resulDiv.style.display="block";
		if (type=='ERROR') {
			message='<span class="messageERROR">'+message+"</span>";
		}
		resulDiv.innerHTML=message;
	}
}
function fillDetailFromJson(index) {
	if (! saveInProgress) showWait();
	item=jsonDataArray.items[index];
	dijit.byId('mobileItem').set('value',item.nameType+ " #"+item.id);
	dijit.byId('mobileName').set('value',item.name);
	dijit.byId('mobileProject').set('value',item.project);
	dojo.byId('mobileType').value=item.type;
	dojo.byId('mobileId').value=item.id;
	url='../mobile/getLongData.php?class='+item.type+"&id="+item.id;
	dojo.xhrPost({
      url: url,
      handleAs: "text",
      load: function(data,args){
    	  var result=data.split(longFieldsSeparator);
    	  dijit.byId('mobileDescription').set('value',result[0]);
    	  dijit.byId('mobileResult').set('value',result[1]);
    	  var list = dijit.byId('mobileNotes');
    	  list.destroyDescendants();
    	  for (var i=2;i<result.length;i++){
    		  var itemWidget= new dojox.mobile.ListItem({style:"line-height:normal;height:100%", moveTo: ""});
    		  itemNode='<span style="font-weight:normal; font-size:70%">'+result[i]+'</span>';
    		  itemWidget.domNode.innerHTML=itemNode;
    		  list.addChild(itemWidget,i-2);
    	  }
    	  if (! saveInProgress) hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  if (! saveInProgress) hideWait();
      }
	});
	
	
	
}
