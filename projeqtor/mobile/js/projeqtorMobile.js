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
	url='../mobile/getJsonDay.php?currentDate='+currentDate
	dojo.xhrPost({
      url: url,
      handleAs: "text",
      load: function(data,args){
    	  alert(data);
    	  hideWait();
      },
      error: function() {
    	  alert('ERROR LOADING DATA FROM \n'+url);
    	  hideWait();
      }
	});
}