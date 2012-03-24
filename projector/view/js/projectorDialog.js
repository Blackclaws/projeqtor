// ============================================================================
// All specific ProjectOr functions and variables for Dialog Purpose
// This file is included in the main.php page, to be reachable in every context
// ============================================================================

//=============================================================================
//= Variables (global)
//=============================================================================

var filterType="";
var closeFilterListTimeout;
//=============================================================================
//= Wait spinner
//=============================================================================

/** ============================================================================
 * Shows a wait spinner
 * @return void
 */
function showWait() {
	if (dojo.byId("wait")) {
		showField("wait");
	} else {
		showField("waitLogin");
	}
}

/** ============================================================================
 * Hides a wait spinner
 * @return void
 */
function hideWait() {
	hideField("wait");
	hideField("waitLogin");
}

//=============================================================================
//= Generic field visibility properties
//=============================================================================

/** ============================================================================
 * Setup the style properties of a field to set it visible (show it)
 * @param field the name of the field to be set 
 * @return void
 */
function showField(field) {
	var dest = dojo.byId(field);
  if (dijit.byId(field)) {
  	dest=dijit.byId(field).domNode;
  }
  if (dest) {
  	dojo.style(dest, {visibility:'visible'});
  	dojo.style(dest, {display:'inline'});
  	//dest.style.visibility = 'visible';
  	//dest.style.display = 'inline';
  }
}

/** ============================================================================
 * Setup the style properties of a field to set it invisible (hide it) 
 * @param field the name of the field to be set
 * @return void 
 */
function hideField(field) {
  var dest = dojo.byId(field);
  if (dijit.byId(field)) {
  	dest=dijit.byId(field).domNode;
  }
  if (dest) {
  	dojo.style(dest, {visibility:'hidden'});
  	dojo.style(dest, {display:'none'});
  	//dest.style.visibility = 'hidden';
  	//dest.style.display = 'none';
  }
}

//=============================================================================
//= Message boxes
//=============================================================================

/** ============================================================================
 * Display a Dialog Error Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showError (msg) {
	top.hideWait();
	top.dojo.byId("dialogErrorMessage").innerHTML=msg ;
	top.dijit.byId("dialogError").show();
}

/** ============================================================================
 * Display a Dialog Information Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showInfo (msg) {
	top.dojo.byId("dialogInfoMessage").innerHTML=msg ;
	top.dijit.byId("dialogInfo").show();
}

/** ============================================================================
 * Display a Dialog Alert Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showAlert (msg) {
	top.dojo.byId("dialogAlertMessage").innerHTML=msg ;
	top.dijit.byId("dialogAlert").show();
}

/** ============================================================================
 * Display a Dialog Question Message Box, with Yes/No buttons
 * @param msg the message to display in the box
 * @param actionYes the function to be executed if click on Yes button
 * @param actionNo the function to be executed if click on No button
 * @return void 
 */
function showQuestion (msg,actionYes, ActionNo) {
	dojo.byId("dialogQuestionMessage").innerHTML=msg ;
	dijit.byId("dialogQuestion").acceptCallbackYes=actionYes;
	dijit.byId("dialogQuestion").acceptCallbackNo=actionNo;
	dijit.byId("dialogQuestion").show();
}

/** ============================================================================
 * Display a Dialog Confirmation Message Box, with OK/Cancel buttons
 * NB : no action on Cancel click
 * @param msg the message to display in the box
 * @param actionOK the function to be executed if click on OK button
 * @return void 
 */
function showConfirm (msg, actionOK) {
	dojo.byId("dialogConfirmMessage").innerHTML=msg ;
	dijit.byId("dialogConfirm").acceptCallback=actionOK;
	dijit.byId("dialogConfirm").show();
}

/** ============================================================================
 * Display a About Box
 * @param msg the message of the about box (must be passed here because built in php)
 * @return void 
 */
function showAbout (msg) {
	showInfo(msg);
}

//=============================================================================
//= Print
//=============================================================================

/** ============================================================================
 * Display a Dialog Print Preview Box
 * @param page the page to display
 * @param forms the form containing the data to send to the page
 * @return void 
 */
function showPrint (page, context, comboName, outMode) {
	//dojo.byId('printFrame').style.width= 1000 + 'px';
	showWait();
	quitConfirmed=true;
	noDisconnect=true;
	if (! outMode) outMode='html';
	var printInNewWin=printInNewWindow;
	if (outMode=="pdf") {
	  printInNewWin=pdfInNewWindow;
	}
	if (outMode=="csv") {
		printInNewWin=true;
	}
	if (outMode=="mpp") {
		printInNewWin=true;
	}
	if ( ! printInNewWin) {
	  //window.frames['printFrame'].document.body.innerHTML='<i>' + i18n("messagePreview") + '</i>';
		//frames['printFrame'].location.href='../view/preparePreview.php';
		dijit.byId("dialogPrint").show();
	}
	if (dojo.byId('objectClass')) {
		cl=dojo.byId('objectClass').value;
	}
	if (dojo.byId('objectId')) {
		id=dojo.byId('objectId').value;
	}
	var params="";
	dojo.byId("sentToPrinterDiv").style.display='block';
	if (outMode) {
		params+="&outMode=" + outMode;
		if (outMode=='pdf') {
			dojo.byId("sentToPrinterDiv").style.display='none';
		}
	}
	if (context=='list') {
		if (dijit.byId("listShowIdle")) {
			if (dijit.byId("listShowIdle").get('checked')) {
			  params+="&idle=true";
			}
		}
		if (dijit.byId("listIdFilter")) {		
			if (dijit.byId("listIdFilter").get('value')) {
			  params+="&listIdFilter="+encodeURIComponent(dijit.byId("listIdFilter").get('value'));
			}
		}
		if (dijit.byId("listNameFilter")) {		
			if (dijit.byId("listNameFilter").get('value')) {
			  params+="&listNameFilter="+encodeURIComponent(dijit.byId("listNameFilter").get('value'));
			}
		}
		if (dijit.byId("listTypeFilter")) {		
			if (dijit.byId("listTypeFilter").get('value')) {
				params+="&objectType="+encodeURIComponent(dijit.byId("listTypeFilter").get('value'));
			}
		}
	} else if (context=='planning'){
		if (dijit.byId("startDatePlanView").get('value')) {
		  params+="&startDate="+encodeURIComponent(formatDate(dijit.byId("startDatePlanView").get("value")));
		  params+="&endDate="+encodeURIComponent(formatDate(dijit.byId("endDatePlanView").get("value")));
		  params+="&format="+g.getFormat();
		  if (dijit.byId('listShowIdle').get('checked')) {
		  	params+="&idle=true";
		  }
		  if (dijit.byId('showWBS').checked) { 
				params+="&showWBS=true";
		  }
		}
	} else if (context=='report'){
		var frm=dojo.byId('reportForm');
		frm.action="../view/print.php";
		if (outMode) {
			dojo.byId('outMode').value=outMode;
		} else {
			dojo.byId('outMode').value='';
		}
		if (printInNewWin) {
			frm.target='#';
		} else {
		  frm.target='printFrame';
		}
		frm.submit();
		hideWait();
		quitConfirmed=false;
		noDisconnect=false;
		return;
	} else if (context=='imputation'){
		var frm=dojo.byId('listForm');
		frm.action="../view/print.php";
		if (printInNewWin) {
			frm.target='#';
		} else {
		  frm.target='printFrame';
		}
		if (outMode) {
			dojo.byId('outMode').value=outMode;
		} else {
			dojo.byId('outMode').value='';
		}
		frm.submit();
		hideWait();
		quitConfirmed=false;
		noDisconnect=false;
		return;
	}
	var grid=dijit.byId('objectGrid');
	if (grid) {
		var sortWay=(grid.getSortAsc())?'asc':'desc';
		var sortIndex=grid.getSortIndex();
		if (sortIndex>=0) {
			params+="&sortIndex="+sortIndex;
			params+="&sortWay="+sortWay;
		}
	}
	if (printInNewWin) {
		var newWin=window.open("print.php?print=true&page="+page+"&objectClass="+cl+"&objectId="+id+params);
		hideWait();
	} else {
	  // Fixing IE9 bug
	  //window.frames['printFrame'].location.href="print.php?print=true&page="+page+"&objectClass="+cl+"&objectId="+id+params;
	  dojo.byId("printFrame").src = "print.php?print=true&page="+page+"&objectClass="+cl+"&objectId="+id+params;
	  if (outMode=='pdf') {
		  hideWait();
	  }
	}
	quitConfirmed=false;
	noDisconnect=false;
	//document.getElementsByTagName('printFrame')[0].contentWindow.print();
}

function sendFrameToPrinter() {
	dojo.byId("sendToPrinter").blur();
  //printFrame.focus();
  //printFrame.print();
  window.frames['printFrame'].focus();
  window.frames['printFrame'].print();
  //var myRef = window.open(window.frames['printFrame'].location +"&directPrint=true",'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
  dijit.byId('dialogPrint').hide();      
  return true;
}
//=============================================================================
//= Detail (from combo)
//=============================================================================

function showDetailDependency() {
	var depType=dijit.byId('dependencyRefTypeDep').get("value");
	if (depType) {
		var dependable=dependableArray[depType];
		var canCreate=0;
		if (canCreateArray[dependable]=="YES") {
			canCreate=1;
	    }
		showDetail('dependencyRefIdDep',canCreate, dependable);
		
	} else {
		showInfo(i18n('messageMandatory', new Array(i18n('linkType'))));
	}
}

function showDetailLink() {
	var linkType=dijit.byId('linkRef2Type').get("value");
	if (linkType) {
		var linkable=linkableArray[linkType];
		var canCreate=0;
		if (canCreateArray[linkable]=="YES") {
			canCreate=1;
	    }
		showDetail('linkRef2Id',canCreate, linkable);
		
	} else {
		showInfo(i18n('messageMandatory', new Array(i18n('linkType'))));
	}
}

function showDetailOrigin() {
	var originType=dijit.byId('originOriginType').get("value");
	if (originType) {
		var originable=originableArray[originType];
		var canCreate=0;
		if (canCreateArray[originable]=="YES") {
			canCreate=1;
	    }
		showDetail('originOriginId',canCreate, originable);
		
	} else {
		showInfo(i18n('messageMandatory', new Array(i18n('originType'))));
	}
}

function showDetail (comboName, canCreate, objectClass) {
	var contentWidget = dijit.byId("comboDetailResult");
	dojo.byId("canCreateDetail").value=canCreate;
    if (contentWidget) {
      contentWidget.set('content','');
    }
    if (! objectClass) {
    	objectClass=comboName.substring(2);
    }
	dojo.byId('comboName').value=comboName;
	dojo.byId('comboClass').value=objectClass;
	var val=null;
	if (dijit.byId(comboName)) {
	  val=dijit.byId(comboName).get('value');
	} else {
	  val=dojo.byId(comboName).value;	
	}
	if (! val || val=="" || val==" ") {
		cl=objectClass;
		window.frames['comboDetailFrame'].document.body.innerHTML='<i>' + i18n("messagePreview") + '</i>';
		dijit.byId("dialogDetail").show();
		displaySearch(cl);
  } else {
		cl=objectClass;
	    id=val;
		window.frames['comboDetailFrame'].document.body.innerHTML='<i>' + i18n("messagePreview") + '</i>';
		dijit.byId("dialogDetail").show();
		displayDetail(cl,id);
  }
}

function displayDetail(objClass, objId) {
	showWait();
	showField('comboSearchButton');
	hideField('comboSelectButton');
	hideField('comboNewButton');
	hideField('comboSaveButton');
	showField('comboCloseButton');	
  frames['comboDetailFrame'].location.href="print.php?print=true&page=objectDetail.php&objectClass="+objClass+"&objectId="+objId+"&detail=true";
}

function selectDetailItem(selectedValue) {
	if (selectedValue) {
		var idFldVal=selectedValue;
	} else {
		var idFld=frames['comboDetailFrame'].dojo.byId('comboDetailId');
		if (! idFld) {
			showError('error : comboDetailId not defined');
			return;
		}
		idFldVal=idFld.value;
		if (! idFldVal) {
			showAlert(i18n('noItemSelected'));
			return;
		}
	}
	var comboName=dojo.byId('comboName').value;
	var combo=dijit.byId(comboName);
	crit=null;
	critVal=null;
	if (comboName=='idActivity' || comboName=='idResource') {
		prj=dijit.byId('idProject');
		if (prj) {
		  crit='idProject';
		  critVal=prj.get("value");
		}		
	}
	if (comboName!='idStatus' && comboName!='idProject') {
	  // TODO : study if such restriction should be applied to idActivity
		if (combo) {
		  refreshList(comboName, crit, critVal, idFldVal);
		} else {
			if (comboName=='dependencyRefIdDep') {
				refreshDependencyList(idFldVal);
				setTimeout("dojo.byId('dependencyRefIdDep').focus()",1000);
				enableWidget('dialogDependencySubmit');
			} else if (comboName=='linkRef2Id') {
				refreshLinkList(idFldVal);
				setTimeout("dojo.byId('linkRef2Id').focus()",1000);
				enableWidget('dialogLinkSubmit');
			} else if (comboName=='originOriginId') {
				refreshOriginList(idFldVal);
				setTimeout("dojo.byId('originOriginId').focus()",1000);
				enableWidget('dialogOriginSubmit');
			}
		}			
	}
	if (combo) {
	  combo.set("value", idFldVal);
	}
		
  hideDetail();
}

function displaySearch(objClass) {
	if (! objClass) {
		// comboName=dojo.byId('comboName').value;
		objClass=dojo.byId('comboClass').value;
	}
	showWait();
	hideField('comboSearchButton');
	showField('comboSelectButton');
	if (dojo.byId("canCreateDetail").value=="1") { 
	  showField('comboNewButton');
	} else {
      hideField('comboNewButton');	
	}
	hideField('comboSaveButton');
	showField('comboCloseButton');	
    top.frames['comboDetailFrame'].location.href="comboSearch.php?objectClass="+objClass+"&mode=search";
    setTimeout(dijit.byId("dialogDetail").show(),10);
}

function newDetailItem() {
	//comboName=dojo.byId('comboName').value;
	var objClass=dojo.byId('comboClass').value;
	showWait();
	showField('comboSearchButton');
	hideField('comboSelectButton');
	hideField('comboNewButton');
	if (dojo.byId("canCreateDetail").value=="1") { 
	  showField('comboSaveButton');
	} else {
      hideField('comboSaveButton');	
	}
	showField('comboCloseButton');
	contentNode=frames['comboDetailFrame'].dojo.byId('body');
	destinationWidth=dojo.style(contentNode, "width");
	page="comboSearch.php";
	page+="?objectClass="+objClass;
	page+="&objectId=0";
	page+="&mode=new";
    page+="&destinationWidth="+destinationWidth;
	top.frames['comboDetailFrame'].location.href=page;
	setTimeout(dijit.byId("dialogDetail").show(),10);
}

function saveDetailItem() {
	var comboName=dojo.byId('comboName').value;
	var formVar = frames['comboDetailFrame'].dijit.byId("objectForm");
	if ( ! formVar) {
		showError(i18n("errorSubmitForm", new Array(page, destination, formName)));
		return;
	}
	// validate form Data
	if(formVar.validate()){
		frames['comboDetailFrame'].dojo.xhrPost({
		      url: "../tool/saveObject.php?comboDetail=true",
		      form: "objectForm",
		      handleAs: "text",
		      load: function(data,args){
				        var contentWidget = dijit.byId("comboDetailResult");
				        if (! contentWidget) {return};
				        contentWidget.set('content',data);
				        checkDestination("comboDetailResult");
				        var lastOperationStatus = top.dojo.byId('lastOperationStatusComboDetail');
				        var lastOperation = top.dojo.byId('lastOperationComboDetail');
				        var lastSaveId=top.dojo.byId('lastSaveIdComboDetail');
				        if (lastOperationStatus.value=="OK") {
				        	selectDetailItem(lastSaveId.value);
				        }
                    }
		});

  } else {
    showAlert(i18n("alertInvalidForm"));
  }
}

function hideDetail() {
	hideField('comboSearchButton');
	hideField('comboSelectButton');
	hideField('comboNewButton');
	hideField('comboSaveButton');
	hideField('comboCloseButton');
	frames['comboDetailFrame'].location.href="preparePreview.php";
	dijit.byId("dialogDetail").hide();
}

//=============================================================================
//= Notes
//=============================================================================

/**
 * Display a add note Box
 * 
 */
function addNote () {
	if (dijit.byId("noteToolTip")) {
		dijit.byId("noteToolTip").destroy();
		dijit.byId("noteNote").set("class","");
	}
	dojo.byId("noteId").value="";
	dojo.byId("noteRefType").value=dojo.byId("objectClass").value;
	dojo.byId("noteRefId").value=dojo.byId("objectId").value;
	dijit.byId("noteNote").set("value",null);
	dijit.byId("dialogNote").set('title',i18n("dialogNote"));
	dijit.byId("dialogNote").show();
}

/**
 * Display a edit note Box
 * 
 */
function editNote (noteId) {
	if (dijit.byId("noteToolTip")) {
		dijit.byId("noteToolTip").destroy();
		dijit.byId("noteNote").set("class","");
	}
	dojo.byId("noteId").value=noteId;
	dojo.byId("noteRefType").value=dojo.byId("objectClass").value;
	dojo.byId("noteRefId").value=dojo.byId("objectId").value;
	dijit.byId("noteNote").set("value",dojo.byId("note_"+noteId).value);
	dijit.byId("dialogNote").set('title',i18n("dialogNote") + " #" + noteId);
	dijit.byId("dialogNote").show();
}

/**
 * save a note (after addNote or editNote)
 * 
 */
function saveNote() {
	if (dijit.byId("noteNote").getValue()=='') {
		dijit.byId("noteNote").set("class","dijitError");
		//dijit.byId("noteNote").blur();
		var msg=i18n('messageMandatory', new Array(i18n('Note')));
		new dijit.Tooltip({
			id : "noteToolTip",
      connectId: ["noteNote"],
      label: msg,
      showDelay: 0
    });
		dijit.byId("noteNote").focus();
	} else {
		loadContent("../tool/saveNote.php", "resultDiv", "noteForm", true, 'note');
		dijit.byId('dialogNote').hide();
	}
}

/**
 * Display a delete note Box
 * 
 */
function removeNote (noteId) {
	dojo.byId("noteId").value=noteId;
	dojo.byId("noteRefType").value=dojo.byId("objectClass").value;
	dojo.byId("noteRefId").value=dojo.byId("objectId").value;
	actionOK=function() {loadContent("../tool/removeNote.php", "resultDiv", "noteForm", true, 'note');};
	msg=i18n('confirmDelete',new Array(i18n('Note'), noteId));
	showConfirm (msg, actionOK);
}


//=============================================================================
//= Attachements
//=============================================================================

/**
 * Display an add attachement Box
 * 
 */
function addAttachement () {
	dojo.byId("attachementId").value="";
	dojo.byId("attachementRefType").value=dojo.byId("objectClass").value;
	dojo.byId("attachementRefId").value=dojo.byId("objectId").value;
	if (dijit.byId("attachementFile")) {
		dijit.byId("attachementFile").reset();
	}
	dijit.byId("attachementDescription").set('value',null);
	dijit.byId("dialogAttachement").set('title',i18n("dialogAttachement"));
	dijit.byId("dialogAttachement").show();
}

/**
 * save an Attachement
 * 
 */
function saveAttachement() {
	dojo.byId('attachementForm').submit();
	showWait();
	dijit.byId('dialogAttachement').hide();
	return true;
}

/**
 * Acknoledge the attachment save
 * @return void
 */
function saveAttachementAck() {
	resultFrame=document.getElementById("resultPost");
	resultText=resultPost.document.body.innerHTML;
	dojo.byId('resultAck').value=resultText;
	loadContent("../tool/ack.php", "resultDiv", "attachementForm", true, 'attachement');
}

/**
 * Display a delete Attachement Box
 * 
 */
function removeAttachement (attachementId) {
	dojo.byId("attachementId").value=attachementId;
	dojo.byId("attachementRefType").value=dojo.byId("objectClass").value;
	dojo.byId("attachementRefId").value=dojo.byId("objectId").value;
	actionOK=function() {loadContent("../tool/removeAttachement.php", "resultDiv", "attachementForm", true, 'attachement');};
	msg=i18n('confirmDelete',new Array(i18n('Attachement'), attachementId));
	showConfirm (msg, actionOK);
}

//=============================================================================
//= Links
//=============================================================================

/**
 * Display a add link Box
 * 
 */
var noRefreshLink=false;
function addLink (classLink) {
	noRefreshLink=true;
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var objectClass=dojo.byId("objectClass").value;
	var objectId=dojo.byId("objectId").value;
    var message=i18n("dialogLink");
	dojo.byId("linkId").value="";
	dojo.byId("linkRef1Type").value=objectClass;
	dojo.byId("linkRef1Id").value=objectId;
	if (classLink) {
	    dojo.byId("linkFixedClass").value=classLink;
	  	message = i18n("dialogLinkRestricted", new Array(i18n(objectClass), objectId, i18n(classLink)));
	  	dijit.byId("linkRef2Type").setDisplayedValue(i18n(classLink));
	  	lockWidget("linkRef2Type");
	  	//var url="../tool/dynamicListLink.php" 
	  	//	+ "?linkRef2Type="+dojo.byId("linkRef2Type").value
	  	//  + "&linkRef1Type="+objectClass
	  	//	+ "&linkRef1Id="+objectId;
	  	//loadContent(url, "dialogLinkList", null, false);
	  	noRefreshLink=false;
	  	refreshLinkList();
	} else {
	  	dojo.byId("linkFixedClass").value="";
	  	message = i18n("dialogLinkExtended", new Array(i18n(objectClass), objectId.value));
	  	unlockWidget("linkRef2Type");
	  	noRefreshLink=false;
	  	refreshLinkList();
    }

	//dojo.byId("linkRef2Id").value='';
	dijit.byId("dialogLink").set('title', message);
	dijit.byId("dialogLink").show();
	disableWidget('dialogLinkSubmit');
}

/**
 * Refresh the link list (after update)
 */
function refreshLinkList(selected) {
	if (noRefreshLink) return;
	disableWidget('dialogLinkSubmit');
	var url='../tool/dynamicListLink.php';
	if (selected) {
	  url+='?selected='+selected;	
	}
	loadContent(url, 'dialogLinkList', 'linkForm', false);
}

/**
 * save a link (after addLink)
 * 
 */
function saveLink() {
  loadContent("../tool/saveLink.php", "resultDiv", "linkForm", true,'link');
	dijit.byId('dialogLink').hide();
}

/**
 * Display a delete Link Box
 * 
 */
function removeLink (linkId, refType, refId) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("linkId").value=linkId;
	dojo.byId("linkRef1Type").value=dojo.byId("objectClass").value;
	dojo.byId("linkRef1Id").value=dojo.byId("objectId").value;
	dijit.byId("linkRef2Type").set('value',refType);
	dojo.byId("linkRef2Id").value=refId;
	actionOK=function() {loadContent("../tool/removeLink.php", "resultDiv", "linkForm", true,'link');};
	msg=i18n('confirmDeleteLink',new Array(i18n(refType),refId));
	showConfirm (msg, actionOK);
}

//=============================================================================
//= Origin
//=============================================================================

/**
* Display a add origin Box
* 
*/
function addOrigin () {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var objectClass=dojo.byId("objectClass").value;
	var objectId=dojo.byId("objectId").value;
	dijit.byId("originOriginType").reset();
	refreshOriginList();
	dojo.byId("originId").value="";
	dojo.byId("originRefType").value=objectClass;
	dojo.byId("originRefId").value=objectId;
	dijit.byId("dialogOrigin").show();
	disableWidget('dialogOriginSubmit');
}

/**
* Refresh the origin list (after update)
*/
function refreshOriginList(selected) {
	disableWidget('dialogOriginSubmit');
	var url='../tool/dynamicListOrigin.php';
	if (selected) {
	  url+='?selected='+selected;	
    }
	loadContent(url, 'dialogOriginList', 'originForm', false);
}

/**
* save a link (after addLink)
* 
*/
function saveOrigin() {
	loadContent("../tool/saveOrigin.php", "resultDiv", "originForm", true,'origin');
	dijit.byId('dialogOrigin').hide();
}

/**
* Display a delete Link Box
* 
*/
function removeOrigin (id, origType, origId) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("originId").value=id;
	dojo.byId("originRefType").value=dojo.byId("objectClass").value;
	dojo.byId("originRefId").value=dojo.byId("objectId").value;
	dijit.byId("originOriginType").set('value',origType);
	dojo.byId("originOriginId").value=origId;
	actionOK=function() {loadContent("../tool/removeOrigin.php", "resultDiv", "originForm", true,'origin');};
	msg=i18n('confirmDeleteOrigin',new Array(i18n(origType),origId));
	showConfirm (msg, actionOK);
}

//=============================================================================
//= Assignments
//=============================================================================

/**
 * Display a add Assignment Box
 * 
 */
function addAssignment (unit) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var prj=dijit.byId('idProject').get('value');
	dijit.byId('assignmentIdResource').store = new dojo.data.ItemFileReadStore({
		       query: {id:'*'},
		       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj });
	dijit.byId('assignmentIdResource').store.fetch({query:{id:"*"}});
	dojo.byId("assignmentId").value="";
	dojo.byId("assignmentRefType").value=dojo.byId("objectClass").value;
	dojo.byId("assignmentRefId").value=dojo.byId("objectId").value;
	dijit.byId("assignmentIdResource").reset();
	dijit.byId("assignmentIdRole").reset();
	dijit.byId("assignmentDailyCost").reset();
	dijit.byId("assignmentRate").set('value','100');
	dijit.byId("assignmentAssignedWork").set('value','0');
	dojo.byId("assignmentAssignedWorkInit").value='0';
	dijit.byId("assignmentRealWork").set('value','0');
	dijit.byId("assignmentLeftWork").set('value','0');
	dojo.byId("assignmentLeftWorkInit").value='0';
	dijit.byId("assignmentPlannedWork").set('value','0');
	dijit.byId("assignmentComment").set('value','');
	dijit.byId("dialogAssignment").set('title',i18n("dialogAssignment"));
	dijit.byId("assignmentIdResource").set('readOnly',false);
	dijit.byId("assignmentIdRole").set('readOnly',false);
	dojo.byId("assignmentPlannedUnit").value=unit;
	dojo.byId("assignmentLeftUnit").value=unit;
	dojo.byId("assignmentRealUnit").value=unit;
	dojo.byId("assignmentAssignedUnit").value=unit;
	dijit.byId("dialogAssignment").show();
}

/**
 * Display a edit Assignment Box
 * 
 */

var editAssignmentLoading=false;
function editAssignment (assignmentId, idResource, idRole, cost, rate, assignedWork, realWork, leftWork, comment, unit) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	editAssignmentLoading=true;
	var prj=dijit.byId('idProject').get('value');
	dijit.byId('assignmentIdResource').store = new dojo.data.ItemFileReadStore({
		       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj
		       +'&selected=' + idResource,
		       clearOnClose: true});
	dijit.byId('assignmentIdResource').store.fetch();
	dijit.byId("assignmentIdResource").set("value",idResource);console.log('4');	
	//dijit.byId('assignmentIdRole').store = new dojo.data.ItemFileReadStore({
  //  url: '../tool/jsonList.php?listType=listRoleResource&idResource='+idRole});
	//dijit.byId('assignmentIdRole').store.fetch();
	dijit.byId("assignmentIdRole").set("value",idRole);

	dojo.byId("assignmentId").value=assignmentId;
	dojo.byId("assignmentRefType").value=dojo.byId("objectClass").value;
	dojo.byId("assignmentRefId").value=dojo.byId("objectId").value;
	dijit.byId("assignmentDailyCost").set('value',dojo.number.format(cost/100));
	dojo.byId("assignmentRate").value=rate;
	dijit.byId("assignmentAssignedWork").set('value',dojo.number.format(assignedWork/100));
	dojo.byId("assignmentAssignedWorkInit").value=assignedWork/100;
	dijit.byId("assignmentRealWork").set('value',dojo.number.format(realWork/100));
	dijit.byId("assignmentLeftWork").set('value',dojo.number.format(leftWork/100));
	dijit.byId("assignmentComment").set('value',comment);
	dojo.byId("assignmentPlannedUnit").value=unit;
	dojo.byId("assignmentLeftUnit").value=unit;
	dojo.byId("assignmentRealUnit").value=unit;
	dojo.byId("assignmentAssignedUnit").value=unit;
	dojo.byId("assignmentLeftWorkInit").value=leftWork/100;
	assignmentUpdatePlannedWork('assignment');
	dijit.byId("dialogAssignment").set('title',i18n("dialogAssignment") + " #" + assignmentId);
	dijit.byId("dialogAssignment").show();
	if (dojo.number.parse(realWork)==0) {
		dijit.byId("assignmentIdResource").set('readOnly',false);
		dijit.byId("assignmentIdRole").set('readOnly',false);
	} else {
		dijit.byId("assignmentIdResource").set('readOnly',true);
		dijit.byId("assignmentIdRole").set('readOnly',true);
	}
	setTimeout("editAssignmentLoading=false",1000);
}

/**
 * Update the left work on assignment update
 * @param prefix
 * @return
 */
function assignmentUpdateLeftWork(prefix) {
	var initAssigned = dojo.byId(prefix + "AssignedWorkInit"); 
  var initLeft =  dojo.byId(prefix + "LeftWorkInit");
  var assigned =  dojo.byId(prefix + "AssignedWork"); 
  var newAssigned=dojo.number.parse(assigned.value);
  if (newAssigned==null || isNaN(newAssigned)) {
  	newAssigned=0;
  	assigned.value=dojo.number.format(newAssigned);
	}  
  var left = dojo.byId(prefix + "LeftWork");
  var real = dojo.byId(prefix + "RealWork"); 
  var planned = dojo.byId(prefix + "PlannedWork");
	diff=dojo.number.parse(assigned.value)-initAssigned.value;
	newLeft=parseFloat(initLeft.value) + diff;
	if (newLeft<0 || isNaN(newLeft)) { newLeft=0;}
	left.value=dojo.number.format(newLeft);
	assignmentUpdatePlannedWork(prefix);
}

/**
 * Update the planned work on assignment update
 * @param prefix
 * @return
 */
function assignmentUpdatePlannedWork(prefix) {
  var left = dojo.byId(prefix + "LeftWork");
  var newLeft=dojo.number.parse(left.value);
  if (newLeft==null || isNaN(newLeft)) {
  	newLeft=0;
  	left.value=dojo.number.format(newLeft);
	}
  var real = dojo.byId(prefix + "RealWork"); 
  var planned = dojo.byId(prefix + "PlannedWork");
	newPlanned=dojo.number.parse(real.value)+dojo.number.parse(left.value);
	planned.value=dojo.number.format(newPlanned);
}

/**
 * save an Assignment (after addAssignment or editAssignment)
 * 
 */
function saveAssignment() {
	/*if (! dijit.byId('assignmentIdResource').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colIdResource'))));
		return;
	}
	if (! dijit.byId('assignmentIdResource').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colIdResource'))));
		return;
	}	*/
	var formVar = dijit.byId('assignmentForm');
  if(formVar.validate()){		
	  dijit.byId("assignmentPlannedWork").focus();
	  dijit.byId("assignmentLeftWork").focus();
	  loadContent("../tool/saveAssignment.php", "resultDiv", "assignmentForm", true, 'assignment');
	  dijit.byId('dialogAssignment').hide();
  } else {
    showAlert(i18n("alertInvalidForm"));
  }
}
 
/**
 * Display a delete Assignment Box
 * 
 */
function removeAssignment (assignmentId, realWork, resource) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	if (parseFloat(realWork)) {
		msg=i18n('msgUnableToDeleteRealWork');
		showAlert (msg);
		return;
	}
	dojo.byId("assignmentId").value=assignmentId;
	dojo.byId("assignmentRefType").value=dojo.byId("objectClass").value;
	dojo.byId("assignmentRefId").value=dojo.byId("objectId").value;
	actionOK=function() {loadContent("../tool/removeAssignment.php", "resultDiv", "assignmentForm", true, 'assignment');};
	msg=i18n('confirmDeleteAssignment',new Array(resource));
	showConfirm (msg, actionOK);
}

function assignmentChangeResource() {
	if (editAssignmentLoading) return;
	var idResource=dijit.byId("assignmentIdResource").get("value");
	if (! idResource) return;
	dijit.byId('assignmentDailyCost').reset();
	dojo.xhrGet({
		url: '../tool/getSingleData.php?dataType=resourceRole&idResource=' + idResource,
		handleAs: "text",
		load: function (data) {dijit.byId('assignmentIdRole').set('value',data);}
	});
}

function assignmentChangeRole() {
	if (editAssignmentLoading) return;
	var idResource=dijit.byId("assignmentIdResource").get("value");
	var idRole=dijit.byId("assignmentIdRole").get("value");
	if (! idResource || ! idRole ) return;
	dojo.xhrGet({
		url: '../tool/getSingleData.php?dataType=resourceCost&idResource=' + idResource + '&idRole=' + idRole,
		handleAs: "text",
		load: function (data) {
		  // #303
		  //dijit.byId('assignmentDailyCost').set('value',data);
		  dijit.byId('assignmentDailyCost').set('value',dojo.number.format(data));
		}
	});
}

//=============================================================================
//= ExpenseDetail
//=============================================================================

/**
* Display a add Assignment Box
* 
*/
function addExpenseDetail () {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("expenseDetailId").value="";
	dojo.byId("idExpense").value=dojo.byId("objectId").value;
	dijit.byId("expenseDetailName").reset();
	dijit.byId("expenseDetailDate").set('value',null);
	dijit.byId("expenseDetailType").reset();
	dojo.byId("expenseDetailDiv").innerHtml="";
	dijit.byId("expenseDetailAmount").reset();
	//dijit.byId("dialogExpenseDetail").set('title',i18n("dialogExpenseDetail"));
	dijit.byId("dialogExpenseDetail").show();
}

/**
* Display a edit Assignment Box
* 
*/
var expenseDetailLoad=false;
function editExpenseDetail (id, idExpense, type, expenseDate, amount) {
	expenseDetailLoad=true;
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("expenseDetailId").value=id;
	dojo.byId("idExpense").value=idExpense;	
	dijit.byId("expenseDetailName").set("value",dojo.byId('expenseDetail_'+id).value);
  	dijit.byId("expenseDetailDate").set("value",getDate(expenseDate));
	dijit.byId("expenseDetailAmount").set("value",dojo.number.parse(amount));
	dijit.byId("dialogExpenseDetail").set('title',i18n("dialogExpenseDetail") + " #" + id);
	dijit.byId("expenseDetailType").set("value",type);
	expenseDetailLoad=false;
	expenseDetailTypeChange(id);
	expenseDetailLoad=true;
	setTimeout('expenseDetailLoad=false;',500);
	dijit.byId("dialogExpenseDetail").show();
}

/**
* save an Assignment (after addAssignment or editAssignment)
* 
*/
function saveExpenseDetail() {
	expenseDetailRecalculate();
	if (! dijit.byId('expenseDetailName').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colName'))));
		return;
	}
	if (! dijit.byId('expenseDetailDate').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colDate'))));
		return;
	}
	if (! dijit.byId('expenseDetailType').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colType'))));
		return;
	}
	if (! dijit.byId('expenseDetailAmount').get('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colAmount'))));
		return;
	}
	var formVar = dijit.byId('expenseDetailForm');
    if(formVar.validate()){		
	  dijit.byId("expenseDetailName").focus();
	  dijit.byId("expenseDetailAmount").focus();
	  loadContent("../tool/saveExpenseDetail.php", "resultDiv", "expenseDetailForm", true, 'expenseDetail');
	  dijit.byId('dialogExpenseDetail').hide();
    } else {
    	showAlert(i18n("alertInvalidForm"));
    }
}

/**
* Display a delete Assignment Box
* 
*/
function removeExpenseDetail (expenseDetailId) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("expenseDetailId").value=expenseDetailId;
	actionOK=function() {loadContent("../tool/removeExpenseDetail.php", "resultDiv", "expenseDetailForm", true, 'expenseDetail');};
	msg=i18n('confirmDeleteExpenseDetail',new Array(dojo.byId('expenseDetail_'+expenseDetailId).value));
	showConfirm (msg, actionOK);
}

function expenseDetailTypeChange(expenseDetailId) {
	if (expenseDetailLoad) return;
	var idType=dijit.byId("expenseDetailType").get("value");
	var url='../tool/expenseDetailDiv.php?idType='+idType;
	if (expenseDetailId) {
	  url+='&expenseDetailId='+expenseDetailId;
	}
	loadContent(url, 'expenseDetailDiv', null, false);
}

function expenseDetailRecalculate() {
	val=false;
	if (dijit.byId('expenseDetailValue01')) {
		val01=dijit.byId('expenseDetailValue01').get("value");
	} else {
		val01=dojo.byId('expenseDetailValue01').value;
	}
	if (dijit.byId('expenseDetailValue02')) {
		val02=dijit.byId('expenseDetailValue02').get("value");
	} else {
		val02=dojo.byId('expenseDetailValue02').value;
	}
	if (dijit.byId('expenseDetailValue03')) {
		val03=dijit.byId('expenseDetailValue03').get("value");
	} else {
		val03=dojo.byId('expenseDetailValue03').value;
	}	
	total=1;
	if (dojo.byId('expenseDetailUnit01').value) {
		total=total*val01;
		val=true;
	}
	if (dojo.byId('expenseDetailUnit02').value) {
		total=total*val02;
		val=true;
	}
	if (dojo.byId('expenseDetailUnit03').value) {
		total=total*val03;
		val=true;
	}
	if (val) {
	  dijit.byId("expenseDetailAmount").set('value',total);
	  lockWidget("expenseDetailAmount");
	} else {
      unlockWidget("expenseDetailAmount")
	}
}

//=============================================================================
//= DocumentVersion
//=============================================================================

/**
* Display a add Document Version Box
* 
*/
function addDocumentVersion (defaultStatus, typeEvo, numVers, dateVers, nameVers) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("documentVersionId").value="";
	dijit.byId('documentVersionIdStatus').store = new dojo.data.ItemFileReadStore({
		       url: '../tool/jsonList.php?listType=listStatusDocumentVersion&idDocumentVersion=' });
	dijit.byId('documentVersionIdStatus').store.fetch();
	dijit.byId('documentVersionIdStatus').set('value',defaultStatus);
	//dijit.byId('documentVersionIdStatus').reset();
	dojo.style(dojo.byId('inputFileDocumentVersion'), {display:'block'});
	dojo.byId("documentId").value=dojo.byId("objectId").value;
	dojo.byId("documentVersionVersion").value=dojo.byId('version').value;
	dojo.byId("documentVersionRevision").value=dojo.byId('revision').value;
	dojo.byId("documentVersionDraft").value=dojo.byId('draft').value;
	dojo.byId("typeEvo").value=typeEvo;
	dijit.byId("documentVersionLink").set('value','');
	dijit.byId("documentVersionFile").reset();
	dijit.byId("documentVersionDescription").set('value','');
	dijit.byId("documentVersionUpdateMajor").set('checked','true');
	dijit.byId("documentVersionUpdateDraft").set('checked',false);
	dijit.byId("documentVersionDate").set('value',new Date());
	dijit.byId("documentVersionUpdateMajor").set('readOnly',false);
	dijit.byId("documentVersionUpdateMinor").set('readOnly',false);
	dijit.byId("documentVersionUpdateNo").set('readonly',false);
	dijit.byId("documentVersionUpdateDraft").set('readonly',false);
	dijit.byId("documentVersionIsRef").set('checked',false);
	dijit.byId('documentVersionVersionDisplay').set('value',
			getDisplayVersion(typeEvo,
					dojo.byId('documentVersionVersion').value,
					dojo.byId('documentVersionRevision').value,
					dojo.byId('documentVersionDraft').value),
					numVers, 
					dateVers,
					nameVers);
	dojo.byId('documentVersionMode').value="add";
	calculateNewVersion();
	setDisplayIsRefDocumentVersion()
	dijit.byId("dialogDocumentVersion").show();
}

/**
* Display a edit Document Version Box
* 
*/
//var documentVersionLoad=false;
function editDocumentVersion (id,version,revision,draft,versionDate, status, isRef, description, typeEvo, numVers, dateVers, nameVers) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dijit.byId('documentVersionIdStatus').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=listStatusDocumentVersion&idDocumentVersion='+id });
    dijit.byId('documentVersionIdStatus').store.fetch();
    dijit.byId('documentVersionIdStatus').set('value',status);
	dojo.style(dojo.byId('inputFileDocumentVersion'), {display:'none'});
	dojo.byId("documentVersionId").value=id;
	dojo.byId("documentId").value=dojo.byId("objectId").value;
	dojo.byId("documentVersionVersion").value=version;
	dojo.byId("documentVersionRevision").value=revision;
	dojo.byId("documentVersionDraft").value=draft;
	dojo.byId("typeEvo").value=typeEvo;
	if (draft) {
		dijit.byId('documentVersionUpdateDraft').set('checked',true);
	} else {
		dijit.byId('documentVersionUpdateDraft').set('checked',false);
	}
	if (isRef=='1') {
		dijit.byId('documentVersionIsRef').set('checked',true);
	} else {
		dijit.byId('documentVersionIsRef').set('checked',false);
	}
	dijit.byId("documentVersionLink").set('value','');
	dijit.byId("documentVersionFile").reset();
	dijit.byId("documentVersionDescription").set('value',description);
	dijit.byId("documentVersionUpdateMajor").set('readOnly','readOnly');
	dijit.byId("documentVersionUpdateMinor").set('readOnly','readOnly');
	dijit.byId("documentVersionUpdateNo").set('readonly','readonly');
	dijit.byId("documentVersionUpdateNo").set('checked',true);
	dijit.byId("documentVersionUpdateDraft").set('readonly','readonly');
	dijit.byId("documentVersionDate").set('value',versionDate);
	dojo.byId('documentVersionMode').value="edit";
	dijit.byId('documentVersionVersionDisplay').set('value',nameVers);
	calculateNewVersion(false);
	setDisplayIsRefDocumentVersion()
	dijit.byId("dialogDocumentVersion").show();
}

/**
* save an Assignment (after addAssignment or editAssignment)
* 
*/
function saveDocumentVersion() {
	dojo.byId('documentVersionForm').submit();
    showWait();
	dijit.byId('dialogDocumentVersion').hide();
	return true;
}

/**
 * Acknoledge the attachment save
 * @return void
 */
function saveDocumentVersionAck() {
	resultFrame=document.getElementById("documentVersionPost");
	resultText=documentVersionPost.document.body.innerHTML;
	dojo.byId('documentVersionAck').value=resultText;
	loadContent("../tool/ack.php", "resultDiv", "documentVersionForm", true, 'documentVersion');
}


/**
* Display a delete Assignment Box
* 
*/
function removeDocumentVersion (documentVersionId, documentVersionName) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("documentVersionId").value=documentVersionId;
	actionOK=function() {loadContent("../tool/removeDocumentVersion.php", "resultDiv", "documentVersionForm", true, 'documentVersion');};
	msg=i18n('confirmDeleteDocumentVersion',new Array(documentVersionName));
	showConfirm (msg, actionOK);
}

function getDisplayVersion(typeEvo, version, revision, draft, numVers, dateVers, nameVers) {
  var res="";
  if (typeEvo=="EVO") {
	if (version!="" && revision !="") {
	  res="V"+version+"."+revision;
    }
  } else if (typeEvo=="EVT") {
	res=dateVers;
  } else if (typeEvo=="SEQ") {
	res=numVers;
  } else if (typeEvo=="EXT") {
	res=nameVers
  }
  if (typeEvo=="EVO" || typeEvo=="EVT" || typeEvo=="SEQ") {
	if (draft) {
	  res+=draftSeparator+draft;
	}
  }
  return res;
}

function calculateNewVersion(update) {
  var typeEvo=dojo.byId("typeEvo").value;
  var numVers="";
  var dateVers="";
  var nameVers="";
  if (dijit.byId('documentVersionUpdateMajor').get('checked')) {
	  type="major";
  } else if (dijit.byId('documentVersionUpdateMinor').get('checked')) {
	  type="minor";
  } else if (dijit.byId('documentVersionUpdateNo').get('checked')) {
	  type="none";
  }
  version=dojo.byId('documentVersionVersion').value;
  revision=dojo.byId('documentVersionRevision').value;
  draft=dojo.byId('documentVersionDraft').value;
  isDraft=dijit.byId('documentVersionUpdateDraft').get('checked');
  version=(version=='')?0:parseInt(version);
  revision=(revision=='')?0:parseInt(revision);
  draft=(draft=='')?0:parseInt(draft);
  if (type=="major") {
	dojo.byId('documentVersionNewVersion').value=version+1;
	dojo.byId('documentVersionNewRevision').value=0;
	dojo.byId('documentVersionNewDraft').value=(isDraft)?'1':'';
  } else if (type=="minor") {
	dojo.byId('documentVersionNewVersion').value=version;
	dojo.byId('documentVersionNewRevision').value=revision+1;
	dojo.byId('documentVersionNewDraft').value=(isDraft)?'1':'';
  } else { // 'none'
	dojo.byId('documentVersionNewVersion').value=version;
	dojo.byId('documentVersionNewRevision').value=revision;
	if (dojo.byId('documentVersionId').value) {
	  dojo.byId('documentVersionNewDraft').value=(isDraft)?((draft)?draft:1):'';	
	} else {
	  dojo.byId('documentVersionNewDraft').value=(isDraft)?draft+1:'';
	}
  }
  dateVers=dojo.date.locale.format(dijit.byId("documentVersionDate").get('value'), {datePattern: "yyyyMMdd", selector: "date"});
  nameVers=dijit.byId("documentVersionVersionDisplay").get('value');
  numVers=nameVers;
  if (typeEvo=="SEQ" && dojo.byId('documentVersionMode').value=="add") {
	  if (! nameVers) {nameVers=0;}
	  numVers=parseInt(nameVers)+1;
  }
  dijit.byId("documentVersionNewVersionDisplay").set('readOnly','readOnly');
  if (typeEvo=="EXT" ) {
	  dijit.byId("documentVersionNewVersionDisplay").set('readOnly', false);
  }
  var newVers=getDisplayVersion(typeEvo,
		  dojo.byId('documentVersionNewVersion').value,
		  dojo.byId('documentVersionNewRevision').value,
		  dojo.byId('documentVersionNewDraft').value,
		  numVers, 
		  dateVers, 
		  nameVers);
  dijit.byId('documentVersionNewVersionDisplay').set('value',newVers);
  if (isDraft) {
	dijit.byId('documentVersionIsRef').set('checked',false);
	setDisplayIsRefDocumentVersion();
  }
}

function setDisplayIsRefDocumentVersion() {
	if (dijit.byId('documentVersionIsRef').get('checked')) {
		dojo.style(dojo.byId('documentVersionIsRefDisplay'), {display:'block'});
		dijit.byId('documentVersionUpdateDraft').set('checked',false);
		calculateNewVersion();
	} else {
		dojo.style(dojo.byId('documentVersionIsRefDisplay'), {display:'none'});
	}
}
//=============================================================================
//= Dependency
//=============================================================================

/**
* Display a add Dependency Box
* 
*/
function addDependency (depType) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var objectClass=dojo.byId("objectClass").value;
	var objectId=dojo.byId("objectId").value;
	var message=i18n("dialogDependency");
	if (depType) {
		dojo.byId("dependencyType").value=depType;
		message = i18n("dialogDependencyRestricted", new Array(i18n(objectClass), objectId, i18n(depType)));
	} else {
		dojo.byId("dependencyType").value=null;
		message = i18n("dialogDependencyExtended", new Array(i18n(objectClass), objectId.value));
	}
	dijit.byId("dependencyRefTypeDep").reset();
	refreshDependencyList();
	//var url="../tool/dynamicListDependency.php" 
	//	+ "?dependencyType="+depType
	//  + "&dependencyRefType="+objectClass
	//	+ "&dependencyRefId="+objectId
	//	+ "&dependencyRefTypeDep="+dojo.byId("dependencyRefTypeDep").value;
	//loadContent(url, "dialogDependencyList", null, false);
	dojo.byId("dependencyId").value="";
	dojo.byId("dependencyRefType").value=objectClass;
	dojo.byId("dependencyRefId").value=objectId;
	dijit.byId("dialogDependency").set('title', message);
	dijit.byId("dialogDependency").show();
	disableWidget('dialogDependencySubmit');
}

/**
* Refresh the Dependency list (after update)
*/
function refreshDependencyList(selected) {
	disableWidget('dialogDependencySubmit');
	var url='../tool/dynamicListDependency.php';
	if (selected) {
		url+='?selected='+selected;
	}
	loadContent(url, 'dialogDependencyList', 'dependencyForm', false);
}

/**
* save a Dependency (after addLink)
* 
*/
function saveDependency() {
	if (dojo.byId("dependencyRefIdDep").value=="") return;
	loadContent("../tool/saveDependency.php", "resultDiv", "dependencyForm", true,'dependency');
	dijit.byId('dialogDependency').hide();
}

/**
* Display a delete Dependency Box
* 
*/
function removeDependency (dependencyId, refType, refId) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("dependencyId").value=dependencyId;
	actionOK=function() {loadContent("../tool/removeDependency.php", "resultDiv", "dependencyForm", true,'dependency');};
	msg=i18n('confirmDeleteLink',new Array(i18n(refType),refId));
	showConfirm (msg, actionOK);
}


//=============================================================================
//= BillLines
//=============================================================================

/**
* Display a add line Box
* 
*/
function addBillLine (line) {
	dojo.byId("billLineId").value="";
	dojo.byId("billLineRefType").value=dojo.byId("objectClass").value;
	dojo.byId("billLineRefId").value=dojo.byId("objectId").value;	
	dijit.byId("billLineLine").set("value",line);
	dijit.byId("billLineQuantity").set("value",null);
	var prj=dijit.byId('idProject').get('value');
	dijit.byId('billLineIdTerm').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=listTermProject&idProject='+prj });
	dijit.byId('billLineIdTerm').store.fetch();
	dijit.byId("billLineIdTerm").set("value",null);
	dijit.byId('billLineIdResource').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj });
	dijit.byId('billLineIdResource').store.fetch();
	dijit.byId("billLineIdResource").reset("value");
	dijit.byId('billLineIdActivityPrice').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=list&dataType=idActivityPrice&critField=idProject&critValue='+prj });
	dijit.byId('billLineIdActivityPrice').store.fetch();
	dijit.byId("billLineIdActivityPrice").reset("value");
	dijit.byId("billLineStartDate").reset("value");
	dijit.byId("billLineEndDate").reset("value");
	dijit.byId("billLineDescription").set("value","");
	dijit.byId("billLineDetail").set("value","");
	dijit.byId("billLinePrice").set("value",null);
	dijit.byId("dialogBillLine").set('title',i18n("dialogBillLine"));
	manageBillingType();
	dijit.byId("dialogBillLine").show();
}


/**
* Display a edit line Box
* 
*/
function editBillLine (id,line,quantity,idTerm,idResource, idActivityPrice, startDate, endDate,price) {
	dojo.byId("billLineId").value=id;
	dojo.byId("billLineRefType").value=dojo.byId("objectClass").value;
	dojo.byId("billLineRefId").value=dojo.byId("objectId").value;
	dijit.byId("billLineLine").set("value",line);
	dijit.byId("billLineQuantity").set('value',quantity);
	var prj=dijit.byId('idProject').get('value');
	dijit.byId('billLineIdTerm').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=listTermProject&idProject='+prj+'&selected='+idTerm });
	dijit.byId('billLineIdTerm').store.fetch();
	dijit.byId("billLineIdTerm").set("value",idTerm);
	dijit.byId('billLineIdResource').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj+'&selected='+idResource });
	dijit.byId('billLineIdResource').store.fetch();
	dijit.byId("billLineIdResource").set("value",idResource);
	dijit.byId('billLineIdActivityPrice').store = new dojo.data.ItemFileReadStore({
	       url: '../tool/jsonList.php?listType=list&dataType=idActivityPrice&critField=idProject&critValue='+prj });
	dijit.byId('billLineIdActivityPrice').store.fetch();
	dijit.byId("billLineIdActivityPrice").set("value",idActivityPrice);
	dijit.byId("billLineStartDate").set("value",startDate);
	dijit.byId("billLineEndDate").set("value",endDate);
	dijit.byId("billLineDescription").set('value',dojo.byId('billLineDescription_'+id).value);
	dijit.byId("billLineDetail").set("value",dojo.byId('billLineDetail_'+id).value);
	dijit.byId("billLinePrice").set("value",price);
	dijit.byId("dialogBillLine").set('title',i18n("dialogBillLine") + " #" + id);
	manageBillingType();
	dijit.byId("dialogBillLine").show();
}

function manageBillingType() {
	type=dijit.byId('billingType').get('value');
	if (type=='E') {
	  if (! dijit.byId("billLineQuantity").get("value")) {
		  dijit.byId("billLineQuantity").set("value",'1');
	  }
	  dojo.style(dojo.byId('billLineFrameTerm'), {display:'block'});
	  dojo.style(dojo.byId('billLineFrameResource'), {display:'none'});
	  if (! dojo.byId("billLineId").value) { // add
		dijit.byId("billLineIdTerm").set('readOnly',false);
		dojo.style(dojo.byId('billLineFrameDescription'), {display:'none'});
	  } else { // edit
		dijit.byId("billLineIdTerm").set('readOnly',true);
		dojo.style(dojo.byId('billLineFrameDescription'), {display:'block'});
	  }
	  dijit.byId("billLineQuantity").set('readOnly',false);
	  dijit.byId("billLinePrice").set('readOnly',true);
	} else if (type=='R' || type=='P') {
	  dojo.style(dojo.byId('billLineFrameTerm'), {display:'none'});
	  dojo.style(dojo.byId('billLineFrameResource'), {display:'block'});
	  dijit.byId("billLineQuantity").set('readOnly',true);
	  dijit.byId("billLinePrice").set('readOnly',true);
	  if (! dojo.byId("billLineId").value) { // add
		dojo.style(dojo.byId('billLineFrameDescription'), {display:'none'});  
		dijit.byId("billLineIdResource").set('readOnly',false);
		dijit.byId("billLineStartDate").set('readOnly',false);
		dijit.byId("billLineEndDate").set('readOnly',false);
	  } else { // edit
		dojo.style(dojo.byId('billLineFrameDescription'), {display:'block'});
		dijit.byId("billLineIdResource").set('readOnly',true);
		dijit.byId("billLineStartDate").set('readOnly',true);
		dijit.byId("billLineEndDate").set('readOnly',true);
	  }
	} else if (type=='M') {
	  if (! dijit.byId("billLineQuantity").get("value")) {
		dijit.byId("billLineQuantity").set("value",'1');
	  }
	  dojo.style(dojo.byId('billLineFrameDescription'), {display:'block'});
	  dojo.style(dojo.byId('billLineFrameTerm'), {display:'none'});
	  dojo.style(dojo.byId('billLineFrameResource'), {display:'none'});
	  dijit.byId("billLineQuantity").set('readOnly',false);
	  dijit.byId("billLinePrice").set('readOnly',false);
	  dijit.byId("billLineDescription").set('readOnly',false);
	  dijit.byId("billLineDetail").set('readOnly',false);
    } else if (type=='N') {
      showAlert(i18n('billingTypeN'));
    } else {
      showAlert('error : unknown billing type');
    }
}
/**
* save a line (after addDetail or editDetail)
* 
*/
function saveBillLine() {
	if (isNaN(dijit.byId("billLineLine").getValue())) {
		dijit.byId("billLineLine").set("class","dijitError");
		//dijit.byId("noteNote").blur();
		var msg=i18n('messageMandatory', new Array(i18n('BillLine')));
		new dijit.Tooltip({
			id : "billLineToolTip",
    connectId: ["billLineLine"],
    label: msg,
    showDelay: 0
  });
		dijit.byId("billLineLine").focus();
	} else {
		loadContent("../tool/saveBillLine.php", "resultDiv", "billLineForm", true, 'billLine');
		dijit.byId('dialogBillLine').hide();
	}
}


/**
* Display a delete line Box
* 
*/
function removeBillLine (lineId) {
	dojo.byId("billLineId").value=lineId;
	actionOK=function() {loadContent("../tool/removeBillLine.php", "resultDiv", "billLineForm", true, 'billLine');};
	msg=i18n('confirmDelete',new Array(i18n('BillLine'), lineId));
	showConfirm (msg, actionOK);
}



//=============================================================================
//= Import
//=============================================================================

/**
 * Display an import Data Box
 * (Not used, for an eventual improvement)
 * 
 */
function importData() {
	var controls=controlImportData();
	if (controls) {	showWait();}
	return controls;
}

function showHelpImportData() {
	var controls=controlImportData();
	if (controls) {	
		showWait();
		var url='../tool/importHelp.php?elementType='+dijit.byId('elementType').get('value');
		url+='&fileType='+dijit.byId('fileType').get('value');
		frames['resultImportData'].location.href=url;
  }
}

function controlImportData() {
	var elementType=dijit.byId('elementType').get('value');
	if (! elementType ) {
		showAlert(i18n('messageMandatory',new Array(i18n('colImportElementType'))));
		return false;
	}
	var fileType=dijit.byId('fileType').get('value');
	if (! fileType ) {
		showAlert(i18n('messageMandatory',new Array(i18n('colImportFileType'))));
		return false;
	}
	return true;
}
//=============================================================================
//= Plan
//=============================================================================

/**
 * Display a planning Box
 * 
 */
function showPlanParam (selectedProject) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dijit.byId("dialogPlan").show();
}

/**
 * Run planning
 * 
 */
function plan() {
	loadContent("../tool/plan.php", "planResultDiv", "dialogPlanForm", true,null);
	dijit.byId("dialogPlan").hide();
}

//=============================================================================
//= Filter
//=============================================================================

/**
 * Display a Filter Box
 * 
 */
var filterStartInput=false;
function showFilterDialog () {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	filterStartInput=false;
	dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'hidden'});
	dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	dojo.style(dijit.byId('filterSortValueList').domNode, {display:'none'});
	dijit.byId('idFilterAttribute').reset();
	dojo.byId('filterObjectClass').value= dojo.byId('objectClass').value;
	filterType="";
	dojo.xhrPost({
		url: "../tool/backupFilter.php?filterObjectClass=" + dojo.byId('filterObjectClass').value,
		handleAs: "text",
		load: function(data,args) { }
		});
	loadContent("../tool/displayFilterClause.php", "listFilterClauses", "dialogFilterForm", false);
	loadContent("../tool/displayFilterList.php", "listStoredFilters", "dialogFilterForm", false);
	dijit.byId('idFilterAttribute').store = new dojo.data.ItemFileReadStore({url: '../tool/jsonList.php?listType=object&objectClass=' + dojo.byId("objectClass").value});
	dijit.byId("dialogFilter").show();
}

/**
 * Select attribute : refresh depedant lists box
 * 
 */
function filterSelectAtribute(value) {
	if (value) {
	  filterStartInput=true;	
	  dijit.byId('idFilterAttribute').store.fetchItemByIdentity({
	    identity : value, 
	    onItem : function(item) { 
	  	  var dataType = dijit.byId('idFilterAttribute').store.getValue(item, "dataType", "inconnu");
	  	  dijit.byId('idFilterOperator').store = new dojo.data.ItemFileReadStore({url: '../tool/jsonList.php?listType=operator&dataType=' + dataType});	  		
	  	  dijit.byId('idFilterOperator').store.fetch({
	  	  	query : {id : "*"},
	  	  	count : 1,
	  	  	onItem : function(item) { 
	  	  		dijit.byId('idFilterOperator').set("value",dijit.byId('idFilterOperator').store.getValue(item,"id",""));
	  	  	},  
          onError : function(err) { 
            console.info(err.message) ;  
          }
	  	  });	      
	  	  dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'visible'});
	  		dojo.byId('filterDataType').value=dataType;
	  		if (dataType=="bool") {
	  			filterType="bool";
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'block'});
	  			dijit.byId('filterValueCheckbox').set('checked','');
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	  		} else if (dataType=="list") {
	  			filterType="list";
	  			var tmpStore = new dojo.data.ItemFileReadStore({url: '../tool/jsonList.php?listType=list&dataType=' + value});
	  			var mySelect=dojo.byId("filterValueList");
	  			mySelect.options.length=0;
	  			var nbVal=0;
	  			tmpStore.fetch({
		  	  	query : {id : "*"},
		  	  	onItem : function(item) {
		  	  		mySelect.options[mySelect.length] = new Option(tmpStore.getValue(item,"name",""),tmpStore.getValue(item,"id",""));
		  	  		nbVal++;
		  	  	},  
	          onError : function(err) { 
	            console.info(err.message) ;  
	          }
		  	  });
	  			mySelect.size=(nbVal>0)?10:nbVal;
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueList').domNode, {display:'block'});
	  			dijit.byId('filterValueList').reset();
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	  		} else if (dataType=="date") {
	  			filterType="date";
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'block'});
	  			dijit.byId('filterValueDate').reset();
	  		} else {
	  	  	filterType="text";
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'block'});
	  			dijit.byId('filterValue').reset();
	  			dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	  		}
	  	},
	    onError : function(err) {
	  		dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'hidden'});
  			dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
  			dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	  		//hideWait();
	    }
    }) ;
	  dijit.byId('filterValue').reset();
		dijit.byId('filterValueList').reset();
		dijit.byId('filterValueCheckbox').reset();
		dijit.byId('filterValueDate').reset();
	} else {
		dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'hidden'});
		dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	}
}

function filterSelectOperator(operator) {
	filterStartInput=true;
	if (operator=="SORT") {
		filterType="SORT";
		dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
		dojo.style(dijit.byId('filterSortValueList').domNode, {display:'block'});
	} else if (operator=="<=now+" || operator==">=now+") {
		filterType="text";
		dojo.style(dijit.byId('filterValue').domNode, {display:'block'});
		dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
		dojo.style(dijit.byId('filterSortValueList').domNode, {display:'none'});
	} else {
		dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
		dataType=dojo.byId('filterDataType').value;
		dojo.style(dijit.byId('filterSortValueList').domNode, {display:'none'});
		if (dataType=="bool") {
			filterType="bool";
			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'block'});
		} else if (dataType=="list") {
			filterType="list";
			dojo.style(dijit.byId('filterValueList').domNode, {display:'block'});
		} else if (dataType=="date") {
			filterType="date";
			dojo.style(dijit.byId('filterValueDate').domNode, {display:'block'});
		} else {
	  	filterType="text";
			dojo.style(dijit.byId('filterValue').domNode, {display:'block'});
		}
	}
}

/**
 * Save filter clause
 * 
 */
function addfilterClause(silent) {
	filterStartInput=false;
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').get('value');
	}
	if (filterType=="") { 
		if (!silent) showAlert(i18n('attributeNotSelected')); 
		return;
	}
	if (filterType=="list" && dijit.byId('filterValueList').get('value')=='') {
		if (!silent) showAlert(i18n('valueNotSelected')); 
		return;
	}
	if (filterType=="date" && ! dijit.byId('filterValueDate').get('value')) {
		if (!silent) showAlert(i18n('valueNotSelected')); 
		return;
	}		
	if (filterType=="text" && ! dijit.byId('filterValue').get('value')) {
		if (!silent) showAlert(i18n('valueNotSelected')); 
		return;
	}		
	// Add controls on operator and value
	loadContent("../tool/addFilterClause.php", "listFilterClauses", "dialogFilterForm", false);
	//dijit.byId('filterNameDisplay').set('value',null);
	//dojo.byId('filterName').value=null;
}

/**
 * Remove a filter clause
 * 
 */
function removefilterClause(id) {
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').get('value');
	}
	// Add controls on operator and value
	dojo.byId("filterClauseId").value=id;
	loadContent("../tool/removeFilterClause.php", "listFilterClauses", "dialogFilterForm", false);
	//dijit.byId('filterNameDisplay').set('value',null);
	//dojo.byId('filterName').value=null;
}

/**
 * Action on OK for filter
 * 
 */
function selectFilter() {
	if (filterStartInput) {
		addfilterClause(true);
		setTimeout("selectFilterContinue();",1000);
	} else {
		selectFilterContinue();
	}
}
function selectFilterContinue() {
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').get('value');
	}
	dojo.xhrPost({
		url: "../tool/backupFilter.php?valid=true",
		form: dojo.byId('dialogFilterForm'),
		handleAs: "text",
		load: function(data,args) { }
	});
	if (dojo.byId("nbFilterCirteria").value>0) {
		dijit.byId("listFilterFilter").set("iconClass","iconActiveFilter16");
	} else {
		dijit.byId("listFilterFilter").set("iconClass","iconFilter16");
	}
	loadContent("../tool/displayFilterList.php?context=directFilterList&filterObjectClass="+dojo.byId('objectClass').value, "directFilterList", null, false,'returnFromFilter', false);
	refreshJsonList(dojo.byId('objectClass').value, dojo.byId('listShowIdle').checked);
	dijit.byId("dialogFilter").hide();
	filterStartInput=false;
}

/**
 * Action on Cancel for filter
 * 
 */
function cancelFilter() {
	filterStartInput=true;
	dojo.xhrPost({url: "../tool/backupFilter.php?cancel=true",
		form: dojo.byId('dialogFilterForm'),
		handleAs: "text",
		load: function(data,args) { }
	});
		dijit.byId('dialogFilter').hide();
}

/**
 * Action on Clear for filter
 * 
 */
function clearFilter() {
	if (dijit.byId('filterNameDisplay')) {
		dijit.byId('filterNameDisplay').reset();
	}
	dojo.byId('filterName').value="";
	removefilterClause('all');	
	//setTimeout("selectFilter();dijit.byId('listFilterFilter').set('iconClass','iconFilter16');",100);
	dijit.byId('listFilterFilter').set('iconClass','iconFilter16');
	dijit.byId('filterNameDisplay').set('value',null);
	dojo.byId('filterName').value=null;
}

/**
 * Action on Default for filter
 * 
 */
function defaultFilter() {
	if (dijit.byId('filterNameDisplay')) {
		//if (dijit.byId('filterNameDisplay').get('value')=="") {
		//	showAlert(i18n("messageMandatory", new Array(i18n("filterName")) ));
		//	exit;
		//}
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').get('value');
	}
	loadContent("../tool/defaultFilter.php", "listStoredFilters", "dialogFilterForm", false);
}

/**
 * Save a filter as a stored filter
 * 
 */
function saveFilter() {
	if (dijit.byId('filterNameDisplay')) {
		if (dijit.byId('filterNameDisplay').get('value')=="") {
			showAlert(i18n("messageMandatory", new Array(i18n("filterName")) ));
			exit;
		}
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').get('value');
	}
	loadContent("../tool/saveFilter.php", "listStoredFilters", "dialogFilterForm", false);
}

/**
 * Select a stored filter in the list and fetch criteria
 * 
 */
function selectStoredFilter(idFilter,context) {
  if (context=='directFilterList') {
	  if (idFilter=='0') {
			dojo.byId('noFilterSelected').value='true';
	  } else {
			dojo.byId('noFilterSelected').value='false';
	  }
	  loadContent("../tool/selectStoredFilter.php?idFilter="+idFilter+"&context=" + context 
			+ "&filterObjectClass="+dojo.byId('objectClass').value, "directFilterList", null, false);
	
	//loadContent("../tool/displayFilterList.php?", "directFilterList",  "dialogFilterForm", false);
	
  } else {
	loadContent("../tool/selectStoredFilter.php?idFilter="+idFilter, "listFilterClauses", "dialogFilterForm", false);
  }
}

/**
 * Removes a stored filter from the list
 * 
 */
function removeStoredFilter(idFilter, nameFilter) {
  var action=function() {
  	loadContent("../tool/removeFilter.php?idFilter="+idFilter, "listStoredFilters", "dialogFilterForm", false);;
  };
  showConfirm(i18n("confirmRemoveFilter",new Array(nameFilter)),action);
}

//=============================================================================
//= Reports
//=============================================================================

function reportSelectCategory(idCateg) {
	loadContent("../view/reportsParameters.php?idReport=", "reportParametersDiv", null, false);
	var tmpStore = new dojo.data.ItemFileReadStore({url: '../tool/jsonList.php?required=true&listType=list&dataType=idReport&critField=idReportCategory&critValue='+idCateg});
	var mySelect=dojo.byId("reportsList");
	//dijit.byId("reportsList").reset();
	mySelect.options.length=0;
	var nbVal=0;
	tmpStore.fetch({
  	query : {id : "*"},
  	onItem : function(item) {
  		mySelect.options[mySelect.length] = new Option(tmpStore.getValue(item,"name",""),tmpStore.getValue(item,"id",""));
  		nbVal++;
  	},  
    onError : function(err) { 
      console.info(err.message) ;  
    }
  });
}

function reportSelectReport(idReport) {
	loadContent("../view/reportsParameters.php?idReport="+idReport, "reportParametersDiv", null, false);
}

//=============================================================================
//= Resource Cost
//=============================================================================

function addResourceCost(idResource, idRole, funcList) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("resourceCostId").value="";
	dojo.byId("resourceCostIdResource").value=idResource;
	dojo.byId("resourceCostFunctionList").value=funcList;
	dijit.byId("resourceCostIdRole").set('readOnly',false);
	if (idRole) {
	  dijit.byId("resourceCostIdRole").set('value',idRole);
	} else {
		dijit.byId("resourceCostIdRole").reset();
	}
	dijit.byId("resourceCostValue").reset('value');
	dijit.byId("resourceCostStartDate").set('value',null);
	resourceCostUpdateRole();
	dijit.byId("dialogResourceCost").show();
}

function removeResourceCost(id, idRole, nameRole, startDate) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("resourceCostId").value=id;
	actionOK=function() {loadContent("../tool/removeResourceCost.php", "resultDiv", "resourceCostForm", true, 'resourceCost');};
	msg=i18n('confirmDeleteResourceCost',new Array(nameRole, startDate));
	showConfirm (msg, actionOK);
} 

reourceCostLoad=false;
function editResourceCost(id, idResource,idRole,cost,startDate,endDate) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	dojo.byId("resourceCostId").value=id;
	dojo.byId("resourceCostIdResource").value=idResource;
	dijit.byId("resourceCostIdRole").set('readOnly',true);
	dijit.byId("resourceCostValue").set('value',dojo.number.format(cost/100));
	var dateStartDate=getDate(startDate);
	dijit.byId("resourceCostStartDate").set('value',dateStartDate);
	dijit.byId("resourceCostStartDate").set('disabled',true);
	dijit.byId("resourceCostStartDate").set('required','false');
	reourceCostLoad=true;
	dijit.byId("resourceCostIdRole").set('value',idRole);
	setTimeout('reourceCostLoad=false;',300);
	dijit.byId("dialogResourceCost").show();  	
}

function saveResourceCost() {
	var formVar = dijit.byId('resourceCostForm');
  if(formVar.validate()){		
  	loadContent("../tool/saveResourceCost.php", "resultDiv", "resourceCostForm", true,'resourceCost');
  	dijit.byId('dialogResourceCost').hide();
  } else {
    showAlert(i18n("alertInvalidForm"));
  }
}

function resourceCostUpdateRole() {
	if (reourceCostLoad) {return;}
	var funcList=dojo.byId('resourceCostFunctionList').value;
	$key='#' + dijit.byId("resourceCostIdRole").get('value') + '#';
	if (funcList.indexOf($key)>=0) {
		dijit.byId("resourceCostStartDate").set('disabled',false);
		dijit.byId("resourceCostStartDate").set('required','true');
	} else {
		dijit.byId("resourceCostStartDate").set('disabled',true);
		dijit.byId("resourceCostStartDate").set('value',null);
		dijit.byId("resourceCostStartDate").set('required','false');
	}
}

//=============================================================================
//= Version Project
//=============================================================================

function addVersionProject(idVersion, idProject) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	refreshList('idProject', null, null, null, 'versionProjectProject', true);
	refreshList('idVersion', null, null, null, 'versionProjectVersion', true);
	dojo.byId("versionProjectId").value="";
	//dijit.byId('assignmentIdResource').store = new dojo.data.ItemFileReadStore({
	//       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj });
    //dijit.byId('assignmentIdResource').store.fetch();
	if (idVersion) {
		dijit.byId("versionProjectVersion").set('readOnly',true);
		dijit.byId("versionProjectVersion").set('value',idVersion);
	} else {
	    dijit.byId("versionProjectVersion").set('readOnly',false);
		dijit.byId("versionProjectVersion").reset();
	}
	if (idProject) {
		dijit.byId("versionProjectProject").set('readOnly',true);
		dijit.byId("versionProjectProject").set('value',idProject);
	} else {
		dijit.byId("versionProjectProject").set('readOnly',false);
		dijit.byId("versionProjectProject").reset();
	}
	
	dijit.byId("versionProjectIdle").reset();
	dijit.byId("versionProjectStartDate").reset();
	dijit.byId("versionProjectEndDate").reset();
	dijit.byId("dialogVersionProject").show();
}

function removeVersionProject(id) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("versionProjectId").value=id;
	actionOK=function() {loadContent("../tool/removeVersionProject.php", "resultDiv", "versionProjectForm", true, 'versionProject');};
	msg=i18n('confirmDeleteVersionProject');
	showConfirm (msg, actionOK);
} 

versionProjectLoad=false;
function editVersionProject(id, idVersion,idProject,startDate,endDate,idle) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("versionProjectId").value=id;
	refreshList('idProject', null, null, null, 'versionProjectProject', true);
	refreshList('idVersion', null, null, null, 'versionProjectVersion', true);
	if (idVersion) {
		dijit.byId("versionProjectVersion").set('readOnly',true);
		dijit.byId("versionProjectVersion").set('value',idVersion);
	} else {
	    dijit.byId("versionProjectVersion").set('readOnly',false);
		dijit.byId("versionProjectVersion").reset();
	}
	if (idProject) {
		dijit.byId("versionProjectProject").set('readOnly',true);
		dijit.byId("versionProjectProject").set('value',idProject);
	} else {
		dijit.byId("versionProjectProject").set('readOnly',false);
		dijit.byId("versionProjectProject").reset();
	}
	if (startDate) {
	  dijit.byId("versionProjectStartDate").set('value',startDate);
	} else {
		dijit.byId("versionProjectStartDate").reset();
	}
	if (endDate) {
	  dijit.byId("versionProjectEndDate").set('value',endDate);
	} else {
		dijit.byId("versionProjectEndDate").reset();
	}
	if (idle==1) {
		dijit.byId("versionProjectIdle").set('value',idle);
	} else {
		dijit.byId("versionProjectIdle").reset();
	}
	dijit.byId("dialogVersionProject").show();  	
}

function saveVersionProject() {
	var formVar = dijit.byId('versionProjectForm');
	if(formVar.validate()){		
		loadContent("../tool/saveVersionProject.php", "resultDiv", "versionProjectForm", true,'versionProject');
		dijit.byId('dialogVersionProject').hide();
	} else {
		showAlert(i18n("alertInvalidForm"));
	}
}


//=============================================================================
//= Affectation
//=============================================================================

function addAffectation(objectClass, type, idResource, idProject) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	refreshList('idProject', null, null, null, 'affectationProject', true);
	if (objectClass=='Project') {
	  refreshList('id'+type, null, null, null, 'affectationResource', true);
	} else { 
	  refreshList('id'+objectClass, null, null, null, 'affectationResource', true);
	}
	dojo.byId("affectationId").value="";
	dojo.byId("affectationIdTeam").value="";
	if (objectClass=='Project') {
		dijit.byId("affectationProject").set('readOnly',true);
		dijit.byId("affectationProject").set('value',idProject);
		dijit.byId("affectationResource").set('readOnly',false);
		dijit.byId("affectationResource").reset();
	} else {
		dijit.byId("affectationResource").set('readOnly',true);
		dijit.byId("affectationResource").set('value',idResource);
		dijit.byId("affectationProject").set('readOnly',false);
		dijit.byId("affectationProject").reset();
	}
	dijit.byId("affectationResource").set('required',true);
	dijit.byId("affectationRate").set('value','100');
	dijit.byId("affectationIdle").reset();
	dijit.byId("dialogAffectation").show();
}

function removeAffectation(id) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.byId("affectationId").value=id;
	dojo.byId("affectationIdTeam").value="";
	actionOK=function() {loadContent("../tool/removeAffectation.php", "resultDiv", "affectationForm", true, 'affectation');};
	msg=i18n('confirmDeleteAffectation',new Array(id));
	showConfirm (msg, actionOK);
} 

affectationLoad=false;
function editAffectation(id, objectClass, type, idResource, idProject, rate,idle) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	refreshList('idProject', null, null, null, 'affectationProject', true);
	if (objectClass=='Project') {
	  refreshList('id'+type, null, null, null, 'affectationResource', true);
	} else { 
	  refreshList('id'+objectClass, null, null, null, 'affectationResource', true);
	}
	dijit.byId("affectationResource").set('required',true);
	dojo.byId("affectationId").value=id;
	dojo.byId("affectationIdTeam").value="";
	if (objectClass=='Project') {
		dijit.byId("affectationProject").set('readOnly',true);
		dijit.byId("affectationProject").set('value',idProject);
		dijit.byId("affectationResource").set('readOnly',false);
		dijit.byId("affectationResource").set('value',idResource);
	} else {
		dijit.byId("affectationResource").set('readOnly',true);
		dijit.byId("affectationResource").set('value',idResource);
		dijit.byId("affectationProject").set('readOnly',false);
		dijit.byId("affectationProject").set('value',idProject);
	}
	if (rate) {
	  dijit.byId("affectationRate").set('value',rate);
	} else {
      dijit.byId("affectationRate").reset();
	}
	if (idle==1) {
		dijit.byId("affectationIdle").set('value',idle);
	} else {
		dijit.byId("affectationIdle").reset();
	}
	dijit.byId("dialogAffectation").show();  	
}

function saveAffectation() {
	var formVar = dijit.byId('affectationForm');
	if(formVar.validate()){		
		loadContent("../tool/saveAffectation.php", "resultDiv", "affectationForm", true,'affectation');
		dijit.byId('dialogAffectation').hide();
	} else {
		showAlert(i18n("alertInvalidForm"));
	}
}

function affectTeamMembers(idTeam) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	refreshList('idProject', null, null, null, 'affectationProject', true);
	dojo.byId("affectationId").value="";
	dojo.byId("affectationIdTeam").value=idTeam;
    dijit.byId("affectationResource").set('readOnly',true);
    dijit.byId("affectationResource").set('required',false);
	dijit.byId("affectationResource").reset();
	dijit.byId("affectationProject").set('readOnly',false);
	dijit.byId("affectationProject").reset();
	dijit.byId("affectationRate").set('value','100');
	dijit.byId("affectationIdle").reset();
	dijit.byId("affectationIdle").set('readOnly',true);
	dijit.byId("dialogAffectation").show();
}
//=============================================================================
//= Misceallanous
//=============================================================================

//var manualWindow=null;
function showHelp() {
	var objectClass=dojo.byId('objectClass');
	var objectClassManual=dojo.byId('objectClassManual');
	var section='';
	if (objectClassManual) {
		section=objectClassManual.value;
	} else if (objectClass) {
		section=objectClass.value;
	}
	var url='../manual/manual.php?section=' + section;
	var name="Manual";
	var attributes='toolbar=no, titlebar=no, menubar=no, status=no, scrollbars=no, directories=no, location=no, resizable=no,'
		 +'height=650, width=1024, top=0, left=0';
	manualWindow=window.open(url, name , attributes);
	manualWindow.focus();
	//manualWindow.window.focus();
	
	return false;
} 


/**
 * Refresh a list (after update)
 */
function refreshList(field, param, paramVal, selected, destination, required) {
	var urlList='../tool/jsonList.php?listType=list&dataType=' + field;
	if (param) {
	  urlList+='&critField='+param;
	  urlList+='&critValue='+paramVal;
	}
	if (selected) {
		urlList+='&selected='+selected;
	}
	if (required) {
		urlList+='&required=true';
	}
	var tmpStore = new dojo.data.ItemFileReadStore({url: urlList});
	if (destination) {
	  var mySelect=dijit.byId(destination);	
	} else {
	  var mySelect=dijit.byId(field);
	}
	mySelect.store=tmpStore;
}

var menuHidden=false;
var menuActualStatus='visible';
var menuDivSize=0; 
var menuShowMode='CLICK';
/**
 * Hide or show the Menu (left part of the screen
 */
function hideShowMenu() {
	if (! dijit.byId("leftDiv")) {
		return;
	}
	if (menuActualStatus=='visible' || ! menuHidden) {		
		menuDivSize=dojo.byId("leftDiv").offsetWidth;
		if (menuDivSize<2) {
			menuDivSize=dojo.byId("mainDiv").offsetWidth*.2;
		}
		dojo.byId('leftDiv_splitter').style.display='none';
		dijit.byId("leftDiv").resize({w: 20});
		dijit.byId("buttonHideMenu").set('label',i18n('buttonShowMenu'));
		setTimeout("dojo.byId('menuBarShow').style.display='block'",10);
		menuHidden=true;
		menuActualStatus='hidden';
	} else {
		dojo.byId('menuBarShow').style.display='none';
		dojo.byId('leftDiv_splitter').style.display='block';
		if (menuDivSize<20) {
			menuDivSize=dojo.byId("mainDiv").offsetWidth*.2;
		}
		dijit.byId("leftDiv").resize({w: menuDivSize});
		dijit.byId("buttonHideMenu").set('label',i18n('buttonHideMenu'));
		menuHidden=false;
		menuActualStatus='visible';
	}
	dijit.byId("globalContainer").resize();	
	//dojo.byId('menuBarShow').style.top='50px';
}
function tempShowMenu(mode) {
	if (mode=='mouse' && menuShowMode=='CLICK') return;
	hideShowMenu();
	menuHidden=true;
}
function menuClick() {
	if (menuHidden) {
		menuHidden=false;
		hideShowMenu();
		menuHidden=true;
	}
}

var switchedMode=false;
var listDivSize=0;
var switchedVisible='';
var switchListMode='CLICK';
function switchMode(){
	if (! switchedMode) {
		switchedMode=true;
		dijit.byId("buttonSwitchMode").set('label',i18n('buttonStandardMode'));
		if (! dojo.byId("listDiv")) {
			if (listDivSize==0) {
			  listDivSize=dojo.byId("centerDiv").offsetHeight*.4;
			}
			return;
		} else {
		  listDivSize=dojo.byId("listDiv").offsetHeight;
		}
		if (dojo.byId('listDiv_splitter')) {
			dojo.byId('listDiv_splitter').style.display='none';
		}
		if (dijit.byId('id')) {
		  hideList();
		} else {
		  showList();
		}
	} else {
		switchedMode=false;
		dijit.byId("buttonSwitchMode").set('label',i18n('buttonSwitchedMode'));
		if (! dojo.byId("listDiv")) {
			return;
		}
		if (dojo.byId('listBarShow')) {
		  dojo.byId('listBarShow').style.display='none';
		}
		if (dojo.byId('detailBarShow')) {
		  dojo.byId('detailBarShow').style.display='none';
		}
		if (dojo.byId('listDiv_splitter')) {
			dojo.byId('listDiv_splitter').style.display='block';
		}
		if (listDivSize==0) {
		  listDivSize=dojo.byId("centerDiv").offsetHeight*.4;
		}
		dijit.byId("listDiv").resize({h: listDivSize});		
		dijit.byId("mainDivContainer").resize();
	}
}

function showList(mode) {
	if (mode=='mouse' && switchListMode=='CLICK') return;
	if (! switchedMode) {
		return;
	}
	if (! dijit.byId("listDiv") || ! dijit.byId("mainDivContainer") ) {
		return;
	}
	if (dojo.byId('listDiv_splitter')) {
		dojo.byId('listDiv_splitter').style.display='none';
	}
	if (dojo.byId('listBarShow')) {
	  dojo.byId('listBarShow').style.display='none';
	}
	if (dojo.byId('detailBarShow')) {
	  dojo.byId('detailBarShow').style.display='block';
	}
	fullSize=dojo.byId("listDiv").offsetHeight+dojo.byId("detailDiv").offsetHeight-20;
	dijit.byId("listDiv").resize({h: fullSize});
	dijit.byId("mainDivContainer").resize();
	switchedVisible='list';
}
function hideList(mode) {
	if (mode=='mouse' && switchListMode=='CLICK') return;
	if (! switchedMode) {
		return;
	}
	if (! dijit.byId("listDiv") || ! dijit.byId("mainDivContainer") ) {
		return;
	}
	if (dojo.byId('listDiv_splitter')) {
		dojo.byId('listDiv_splitter').style.display='none';
	}
	if (dojo.byId('listBarShow')) {
	  dojo.byId('listBarShow').style.display='block';
	}
	if (dojo.byId('detailBarShow')) {
	  dojo.byId('detailBarShow').style.display='none';
	}
	dijit.byId("listDiv").resize({h: 20});
	dijit.byId("mainDivContainer").resize();
	switchedVisible='detail';
}

function listClick() {
	stockHistory(dojo.byId('objectClass').value, dojo.byId('objectId').value);
	if (! switchedMode) {
		return;
	}
	hideList();
}

function stockHistory(curClass,curId) {
	var len=historyTable.length;
	var lastClass="";
	var lastId=0;
	if (len>0) { 
	  var lastClass=historyTable[len-1][0];
	  var lastId=historyTable[len-1][1];
	}
	if (len==0 || curClass!=lastClass || curId!=lastId) {
	  historyTable[len]=new Array(curClass, curId);
	  historyPosition=len;
	  if (historyPosition>=1) {
	    enableWidget('menuBarUndoButton');
	  }
	  disableWidget('menuBarRedoButton');
	}
}

function undoItemButton() {
	var len=historyTable.length;
	if (len==0) {return;}
	if (historyPosition==0) {return;}
	historyPosition-=1;
	gotoElement(historyTable[historyPosition][0],historyTable[historyPosition][1], true);
	enableWidget('menuBarRedoButton');
	if (historyPosition==0) {
	   disableWidget('menuBarUndoButton');
	}
}

function redoItemButton() {
	var len=historyTable.length;
	if (len==0) {return;}
	if (historyPosition==len-1) {return;}
	historyPosition+=1;
	gotoElement(historyTable[historyPosition][0],historyTable[historyPosition][1], true);
	enableWidget('menuBarUndoButton');
	if (historyPosition==(len-1)) {
	   disableWidget('menuBarRedoButton');
	}
}

// Stock id and name, to 
// => avoid filterJsonList to reduce visibility => clear this data on open
// => retrieve data before close to retrieve the previous visibility
var quickSearchStockId=null;
var quickSearchStockName=null;
var quickSearchIsOpen=false;

function quickSearchOpen() {
  dojo.style("quickSearchDiv","display","block");
  if (dijit.byId("listTypeFilter")) {
	  dojo.style("listTypeFilter","display","none");	  
  }
  quickSearchStockId=dijit.byId('listIdFilter').get("value");
  if (dijit.byId('listNameFilter')) {
    quickSearchStockName=dijit.byId('listNameFilter').get("value");
    dojo.style("listNameFilter","display","none");
    dijit.byId('listNameFilter').reset();
  }  
  dijit.byId('listIdFilter').reset(); 
  dojo.style("listIdFilter","display","none");	
  dijit.byId("quickSearchValue").reset();
  dijit.byId("quickSearchValue").focus();
  quickSearchIsOpen=true;
}

function quickSearchClose() {
  quickSearchIsOpen=false;
  dojo.style("quickSearchDiv","display","none");
  if (dijit.byId("listTypeFilter")) {
	  dojo.style("listTypeFilter","display","block");	  
  }
  dojo.style("listIdFilter","display","block");
  if (dijit.byId('listNameFilter')) {
    dojo.style("listNameFilter","display","block");
    dijit.byId('listNameFilter').set("value",quickSearchStockName);
  }
  dijit.byId("quickSearchValue").reset();
  dijit.byId('listIdFilter').set("value",quickSearchStockId);  
  var objClass=dojo.byId('objectClass').value;
  refreshJsonList(objClass);
}

function quickSearchExecute() {
  if (! quickSearchIsOpen){
	  return;
  }
  if (! dijit.byId("quickSearchValue").get("value")) {
	showInfo(i18n('messageMandatory', new Array(i18n('quickSearch'))));
    return;
  }	
  var objClass=dojo.byId('objectClass').value;
  refreshJsonList(objClass);
}

/* ==========================================
 * Copy functions
 */
function copyObject(objectClass) {
  dojo.byId("copyButton").blur();
  action=function(){
    unselectAllRows('objectGrid');
    loadContent("../tool/copyObject.php", "resultDiv", 'objectForm', true);
  };
  showConfirm(i18n("confirmCopy", new Array(i18n(objectClass),dojo.byId('id').value)) ,action);
}

function copyObjectTo(objectClass) {
  dojo.byId('copyClass').value=dojo.byId("objectClass").value;
  dojo.byId('copyId').value=dojo.byId("objectId").value;
  dijit.byId('copyToClass').set('displayedValue',i18n(objectClass));
  dijit.byId('copyToName').set('value',dijit.byId('name').get('value'));
  dijit.byId('copyToOrigin').set('checked','checked');

  dijit.byId('copyToType').reset();
  //if (dojo.byId('copyClass').value==class) {
    var runModif="dijit.byId('copyToType').set('value',dijit.byId('id"+objectClass+"Type').get('value'))";
    setTimeout(runModif,1);
  //}  
  
  dijit.byId('dialogCopy').show();	
}

function copyProject() {
  var objectClass="Project";
  dojo.byId('copyProjectId').value=dojo.byId("objectId").value;
  dijit.byId('copyProjectToName').set('value',dijit.byId('name').get('value'));
  //dijit.byId('copyToOrigin').set('checked','checked');
  dijit.byId('copyProjectToType').reset();
  if (dijit.byId('idProjectType') && dojo.byId('codeType') && dojo.byId('codeType').value!='TMP') {
    var runModif="dijit.byId('copyProjectToType').set('value',dijit.byId('idProjectType').get('value'))";
    setTimeout(runModif,1);
  }
      
  dijit.byId('dialogCopyProject').show();	
}

function copyObjectToSubmit(objectClass) {
  var formVar = dijit.byId('copyForm');
  if(! formVar.validate()){  
    showAlert(i18n("alertInvalidForm"));
	return;
  }
  unselectAllRows('objectGrid');
  loadContent("../tool/copyObjectTo.php", "resultDiv", 'copyForm', true, 'copyTo');
  dijit.byId('dialogCopy').hide();
  dojo.byId('objectClass').value=copyableArray[dijit.byId('copyToClass').get('value')];
}

function copyProjectToSubmit(objectClass) {
  var formVar = dijit.byId('copyProjectForm');
  if(! formVar.validate()){  
    showAlert(i18n("alertInvalidForm"));
	return;
  }
  unselectAllRows('objectGrid');
  loadContent("../tool/copyProjectTo.php", "resultDiv", 'copyProjectForm', true, 'copyTo');
  dijit.byId('dialogCopyProject').hide();
  //dojo.byId('objectClass').value='Project';
}

function loadMenuBarObject(menuClass) {
  	if (checkFormChangeInProgress()) {
  		return false;
  	}
  	cleanContent("detailDiv");
    formChangeInProgress=false;
    loadContent("objectMain.php?objectClass="+menuClass,"centerDiv");
}

function loadMenuBarItem(item) {
  	if (checkFormChangeInProgress()) {
  		return false;
  	}
  	cleanContent("detailDiv");
    formChangeInProgress=false;
    if (item=='Today') {
	    loadContent("today.php","centerDiv");
    } else if (item=='Planning') {
	    loadContent("planningMain.php","centerDiv");
    } else if (item=='Imputation') {
      loadContent("imputationMain.php","centerDiv");
    } else if (item=='ImportData') {
      loadContent("importData.php","centerDiv");
    } else if (item=='Reports') {
      loadContent("reportsMain.php","centerDiv");
	} else if(item=='UserParameter') {
	   loadContent("parameter.php?type=userParameter","centerDiv");
	}
}

// ====================================================================================
// ALERTS
// ====================================================================================
//
//var alertDisplayed=false;
function checkAlert() {
  //if (alertDisplayed) return;
  dojo.xhrGet({
	url: "../tool/checkAlertToDisplay.php",
	handleAs: "text",
	load: function(data,args) { checkAlertRetour(data); },
    error: function() { checkAlert(); }
  });
}
function checkAlertRetour(data) {
  if (data) {
	var reminderDiv=dojo.byId('reminderDiv');
	var dialogReminder=dojo.byId('dialogReminder');
	reminderDiv.innerHTML=data;
	if (dojo.byId('alertType')) {
		//dojo.parser.parse(reminderDiv);
		dojo.style(dialogReminder, {visibility:'visible', display:'inline', bottom: '-200px'});
		//alertDisplayed=true;
		var toColor='#FFCCCC';
	    if (dojo.byId('alertType') && dojo.byId('alertType').value=='WARNING') {
			toColor='#FFFFCC';
		}
		if (dojo.byId('alertType') && dojo.byId('alertType').value=='INFO') {
			toColor='#CCCCFF';
		}
		dojo.animateProperty({
	        node: dialogReminder,
	        properties: {
	            bottom: { start: -200, end: 0 },
	            right: 0,
	            backgroundColor: { start: '#FFFFFF', end: toColor }
	        },
	        duration: 2000
	    }).play();
     }
  } else {
	setTimeout('checkAlert();',alertCheckTime*1000);  
  }
}
function setAlertReadMessage() {
  //alertDisplayed=false;
  closeAlertBox();
  if (dojo.byId('idAlert')) {
    setAlertRead(dojo.byId('idAlert').value);
  }
}
function setAlertRemindMessage() {
 //alertDisplayed=false;
  closeAlertBox();
  //alert(dijit.byId('remindAlertTime').get('value'));
  setAlertRead(dojo.byId('idAlert').value, dijit.byId('remindAlertTime').get('value'));
}

function setAlertRead(id, remind) {
  var url="../tool/setAlertRead.php?idAlert="+id;
  if (remind) {
	url+='&remind='+remind;
  }
  //alert(url);
  dojo.xhrGet({
	url: url,
	handleAs: "text",
	load: function(data,args) { setTimeout('checkAlert();',1000); },
	error: function() {setTimeout('checkAlert();',1000);}
  });
}

function closeAlertBox() {
	var dialogReminder=dojo.byId('dialogReminder');
	dojo.animateProperty({
        node: dialogReminder,
        properties: {
            bottom: { start: 0, end: -200 }
        },
        duration: 900,
        onEnd: function () {dojo.style(dialogReminder, {visibility:'hidden', display:'none', bottom: '-200px'}); }
    }).play();
}

// ===========================================================================================
// ADMIN functionalities
// ===========================================================================================
//
var cronCheckIteration=5; // Number of cronCheckTimeout to way max
function adminLaunchScript(scriptName) {
  var url="../tool/" + scriptName + ".php";
  dojo.xhrGet({
	url: url,
	handleAs: "text",
	load: function(data,args) {  },
	error: function() { }
  });	
  if (scriptName=='cronRun') {
    setTimeout('loadContent("admin.php","centerDiv");',1000);
  } else if (scriptName=='cronStop') {
	i=120;
	cronCheckIteration=5;
	setTimeout('adminCronCheckStop();',1000*cronSleepTime); 
  }
} 

function adminCronCheckStop() {
  dojo.xhrGet({
	url: "../tool/cronCheck.php",
	handleAs: "text",
	load: function(data,args) {
	        if (data!='running') {
	          loadContent("admin.php","centerDiv");
	        } else {
	          cronCheckIteration--;
	          if (cronCheckNumber>0) {
	        	setTimeout('adminCronCheckStop();',1000*cronSleepTime);
	          } else {
	            loadContent("admin.php","centerDiv");
	          }
	        }
	      },
	error: function() {loadContent("admin.php","centerDiv");}
  });  
}

function adminCronRelaunch() {
  var url="../tool/cronRelaunch.php";
  dojo.xhrGet({
	url: url,
	handleAs: "text",
	load: function(data,args) {  },
	error: function() { }
  });	
} 

function adminSendAlert() {
  formVar=dijit.byId("adminForm");	
  if(formVar.validate()){
    loadContent("../tool/adminFunctionalities.php?adminFunctionality=sendAlert","resultDiv", "adminForm", true, 'admin');
  }
}

function maintenance(operation,item) {
  if (operation=="updateReference")	{
	loadContent("../tool/adminFunctionalities.php?adminFunctionality="+operation+"&element="+item, "resultDiv", "adminForm", true, 'admin');  
  } else {
    var nb=dijit.byId(operation+item+"Days").get('value');
    loadContent("../tool/adminFunctionalities.php?adminFunctionality=maintenance&operation="+operation+"&item="+item+"&nbDays="+nb,"resultDiv", "adminForm", true, 'admin');
  }
}

function lockDocument() {
  if (checkFormChangeInProgress()) {
	return false;
  }
  dijit.byId('locked').set('checked',true);
  dijit.byId('idLocker').set('value',dojo.byId('idCurrentUser').value);
  var curDate = new Date();
  dijit.byId('lockedDate').set('value',curDate);
  dijit.byId('lockedDateBis').set('value',curDate);
  formChanged();
  submitForm("../tool/saveObject.php","resultDiv", "objectForm", true); 
}

function unlockDocument() {
  if (checkFormChangeInProgress()) {
	return false;
  }
  dijit.byId('locked').set('checked',false);
  dijit.byId('idLocker').set('value',null);
  dijit.byId('lockedDate').set('value',null);
  dijit.byId('lockedDateBis').set('value',null);
  formChanged();
  submitForm("../tool/saveObject.php","resultDiv", "objectForm", true); 
}