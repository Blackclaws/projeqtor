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
      url: "../tool/saveDataToSession.php?id=disconnect"+extUrl,
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

function loadItems(currentDate) {
	showWait();
	url='../mobile/getJsonDay.php?currentDate='+currentDate;
	dojo.xhrPost({
      url: url,
      handleAs: "text",
      load: function(data,args){
    	  fillItemsFromJson(data);
    	  hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
      }
	});
}

var jsonDataArray=null;
function fillItemsFromJson(json) {
	var jsonArray = JSON.parse(json);
	jsonDataArray=jsonArray;
	var list = dijit.byId('itemList');
	list.destroyDescendants();
	dijit.byId('dayCaption').domNode.innerHTML=jsonArray.dayCaption;
	var cpt=0;
	dojo.forEach(jsonArray.items, function (item,index) {
		var itemWidget= new dojox.mobile.ListItem({icon: item.icon, style:"height:100%;"+((item.real)?'opacity: 0.5;filter: alpha(opacity=50);':''), moveTo: "detail", id:index, onClick:function(e){fillDetailFromJson(index);}});
		itemNode='<div>'+item.nameType+" #"+item.id;
		itemNode+='<span '+((! item.real)?'onClick="saveWork();"':'')+' class="projeqtorActionBtn'+((item.real)?'Disabled':'')+'" style="z-index:ççç;font-weight:normal;position: relative; left:10px">'+item.workUnit+'<span></div>';
		itemNode+='<div  style="font-weight:normal;font-size:80%">'+item.name+'</div>';
		itemWidget.domNode.innerHTML=itemNode;
		list.addChild(itemWidget,index);
		cpt++;
	});
}
function saveWork() {
	//TODO : saveWork planned for item
	console.log('TODO...');
	setTimeout("retourSaveWork()",100);
}
function retourSaveWork(){
	alert("Sauvegarde non implémentée");
}
function fillDetailFromJson(index) {
	showWait();
	item=jsonDataArray.items[index];
	dijit.byId('mobileItem').set('value',item.nameType+ " #"+item.id);
	dijit.byId('mobileName').set('value',item.name);
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
    	  hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
      }
	});
	
	
	
}
