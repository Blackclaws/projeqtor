// ============================================================================
// All specific ProjectOr functions and variables for Dialog Purpose
// This file is included in the main.php page, to be reachable in every context
// ============================================================================

//=============================================================================
//= Variables (global)
//=============================================================================

var filterType="";

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
  if (dest) {
  	dest.style.visibility = 'visible';
  	dest.style.display = 'inline';
  }
}

/** ============================================================================
 * Setup the style properties of a field to set it invisible (hide it) 
 * @param field the name of the field to be set
 * @return void 
 */
function hideField(field) {
  var dest = dojo.byId(field);
  if (dest) {
  	dest.style.visibility = 'hidden';
  	dest.style.display = 'none';
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
	hideWait();
	dojo.byId("dialogErrorMessage").innerHTML=msg ;
	dijit.byId("dialogError").show();
}

/** ============================================================================
 * Display a Dialog Information Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showInfo (msg) {
	dojo.byId("dialogInfoMessage").innerHTML=msg ;
	dijit.byId("dialogInfo").show();
}

/** ============================================================================
 * Display a Dialog Alert Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showAlert (msg) {
	dojo.byId("dialogAlertMessage").innerHTML=msg ;
	dijit.byId("dialogAlert").show();
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
function showPrint (page) {
	dijit.byId("dialogPrint").show();
	cl=dojo.byId('objectClass').value;
	id=dojo.byId('objectId').value;
	//cl='Project';
	//id='3';
	frames['printFrame'].location.href="print.php?print=true&page="+page+"&objectClass="+cl+"&objectId="+id;
	//document.getElementsByTagName('printFrame')[0].contentWindow.print();
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
		dijit.byId("noteNote").attr("class","");
	}
	dojo.byId("noteId").value="";
	dojo.byId("noteRefType").value=dojo.byId("objectClass").value;
	dojo.byId("noteRefId").value=dojo.byId("objectId").value;
	dijit.byId("noteNote").attr("value","");
	dijit.byId("dialogNote").attr('title',i18n("dialogNote"));
	dijit.byId("dialogNote").show();
}

/**
 * Display a edit note Box
 * 
 */
function editNote (noteId) {
	if (dijit.byId("noteToolTip")) {
		dijit.byId("noteToolTip").destroy();
		dijit.byId("noteNote").attr("class","");
	}
	dojo.byId("noteId").value=noteId;
	dojo.byId("noteRefType").value=dojo.byId("objectClass").value;
	dojo.byId("noteRefId").value=dojo.byId("objectId").value;
	dijit.byId("noteNote").attr("value",dojo.byId("note_"+noteId).value);
	dijit.byId("dialogNote").attr('title',i18n("dialogNote") + " #" + noteId);
	dijit.byId("dialogNote").show();
}

/**
 * save a note (after addNote or editNote)
 * 
 */
function saveNote() {
	if (dijit.byId("noteNote").getValue()=='') {
		dijit.byId("noteNote").attr("class","dijitError");
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
	dijit.byId("attachementDescription").attr("value","");
	dijit.byId("dialogAttachement").attr('title',i18n("dialogAttachement"));
	dijit.byId("dialogAttachement").show();
}

/**
 * save an Attachement
 * 
 */
function saveAttachement() {
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
function addLink (classLink) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var objectClass=dojo.byId("objectClass").value;
	var objectId=dojo.byId("objectId").value;
  var message=i18n("dialogLink");
	if (classLink) {
		dojo.byId("linkFixedClass").value=classLink;
  	message = i18n("dialogLinkRestricted", new Array(i18n(objectClass), objectId, i18n(classLink)));
  	dijit.byId("linkRef2Type").setDisplayedValue(classLink);
  	lockWidget("linkRef2Type");
  	var url="../tool/dynamicListLink.php" 
  		+ "?linkRef2Type="+dojo.byId("linkRef2Type").value
  	  + "&linkRef1Type="+objectClass
  		+ "&linkRef1Id="+objectId;
  	loadContent(url, "dialogLinkList", null, false);
  } else {
  	dojo.byId("linkFixedClass").value="";
  	message = i18n("dialogLinkExtended", new Array(i18n(objectClass), objectId.value));
  	unlockWidget("linkRef2Type");
  	refreshLinkList();
  }
	dojo.byId("linkId").value="";
	dojo.byId("linkRef1Type").value=objectClass;
	dojo.byId("linkRef1Id").value=objectId;
	//dojo.byId("linkRef2Id").value='';
	dijit.byId("dialogLink").attr('title', message);
	dijit.byId("dialogLink").show();
	disableWidget('dialogLinkSubmit');
}

/**
 * Refresh the link list (after update)
 */
function refreshLinkList() {
	if (dojo.byId("linkFixedClass").value!="") return;
	disableWidget('dialogLinkSubmit'); 
	loadContent('../tool/dynamicListLink.php', 'dialogLinkList', 'linkForm', false);
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
	dojo.byId("linkRef2Type").value=refType;
	dojo.byId("linkRef2Id").value=refId;
	actionOK=function() {loadContent("../tool/removeLink.php", "resultDiv", "linkForm", true,'link');};
	msg=i18n('confirmDeleteLink',new Array(i18n(refType),refId));
	showConfirm (msg, actionOK);
}

//=============================================================================
//= Assignments
//=============================================================================

/**
 * Display a add Assignment Box
 * 
 */
function addAssignment () {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}	
	var prj=dijit.byId('idProject').attr('value');
	dijit.byId('assignmentIdResource').store = new dojo.data.ItemFileReadStore({
		       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj});
	dojo.byId("assignmentId").value="";
	dojo.byId("assignmentRefType").value=dojo.byId("objectClass").value;
	dojo.byId("assignmentRefId").value=dojo.byId("objectId").value;
	dijit.byId("assignmentIdResource").attr('value',null);
	dojo.byId("assignmentRate").value='100';
	dojo.byId("assignmentAssignedWork").value='0';
	dojo.byId("assignmentAssignedWorkInit").value='0';
	dojo.byId("assignmentRealWork").value='0';
	dojo.byId("assignmentLeftWork").value='0';
	dojo.byId("assignmentLeftWorkInit").value='0';
	dojo.byId("assignmentPlannedWork").value='0';
	dojo.byId("assignmentComment").value='';
	dijit.byId("dialogAssignment").attr('title',i18n("dialogAssignment"));
	dijit.byId("assignmentIdResource").attr('disabled',false);
	dijit.byId("dialogAssignment").show();
}

/**
 * Display a edit Assignment Box
 * 
 */
function editAssignment (assignmentId, idResource, rate, assignedWork, realWork, leftWork, comment) {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	var prj=dijit.byId('idProject').attr('value');
	dijit.byId('assignmentIdResource').store = new dojo.data.ItemFileReadStore({
		       url: '../tool/jsonList.php?listType=listResourceProject&idProject='+prj
		       +'&selected=' + idResource});
	dojo.byId("assignmentId").value=assignmentId;
	dojo.byId("assignmentRefType").value=dojo.byId("objectClass").value;
	dojo.byId("assignmentRefId").value=dojo.byId("objectId").value;
	dijit.byId("assignmentIdResource").attr("value",idResource);
	dojo.byId("assignmentRate").value=rate;
	dojo.byId("assignmentAssignedWork").value=assignedWork;
	dojo.byId("assignmentAssignedWorkInit").value=dojo.number.parse(assignedWork);
	dojo.byId("assignmentRealWork").value=realWork;
	dojo.byId("assignmentLeftWork").value=leftWork;
	dojo.byId("assignmentComment").value=comment;
	dojo.byId("assignmentLeftWorkInit").value=dojo.number.parse(leftWork);
	assignmentUpdatePlannedWork('assignment');
	dijit.byId("dialogAssignment").attr('title',i18n("dialogAssignment") + " #" + assignmentId);
	dijit.byId("dialogAssignment").show();
	if (dojo.number.parse(realWork)==0) {
		dijit.byId("assignmentIdResource").attr('disabled',false);
	} else {
		dijit.byId("assignmentIdResource").attr('disabled',true);
	}
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
  var left = dojo.byId(prefix + "LeftWork");
  var real = dojo.byId(prefix + "RealWork"); 
  var planned = dojo.byId(prefix + "PlannedWork");
	diff=dojo.number.parse(assigned.value)-initAssigned.value;
	newLeft=parseFloat(initLeft.value) + diff;
	if (newLeft<0) { newLeft=0;}
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
	/*if (! dijit.byId('assignmentIdResource').attr('value')) {
		showAlert(i18n('messageMandatory',new Array(i18n('colIdResource'))));
		return;
	}
	if (! dijit.byId('assignmentIdResource').attr('value')) {
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
	dojo.byId("dependencyType").value="";
	message = i18n("dialogDependencyExtended", new Array(i18n(objectClass), objectId.value));
}
var url="../tool/dynamicListDependency.php" 
	+ "?dependencyType="+depType
  + "&dependencyRefType="+objectClass
	+ "&dependencyRefId="+objectId
	+ "&dependencyRefTypeDep="+dojo.byId("dependencyRefTypeDep").value;
loadContent(url, "dialogDependencyList", null, false);
dojo.byId("dependencyId").value="";
dojo.byId("dependencyRefType").value=objectClass;
dojo.byId("dependencyRefId").value=objectId;
dijit.byId("dialogDependency").attr('title', message);
dijit.byId("dialogDependency").show();
disableWidget('dialogDependencySubmit');
}

/**
* Refresh the Dependency list (after update)
*/
function refreshDependencyList() {
disableWidget('dialogDependencySubmit'); 
loadContent('../tool/dynamicListDependency.php', 'dialogDependencyList', 'dependencyForm', false);
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
//alert("Not implemented");
//return;
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
//= Import
//=============================================================================

/**
 * Display an import Data Box
 * (Not used, for an eventual improvement)
 * 
 */
function importData() {
	showWait();
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
function showFilterDialog () {
	if (formChangeInProgress) {
		showAlert(i18n('alertOngoingChange'));
		return;
	}
	dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'hidden'});
	dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	dijit.byId('idFilterAttribute').attr("value","");
	dojo.byId('filterObjectClass').value= dojo.byId('objectClass').value;
	filterType="";
	dojo.xhrPost({url: "../tool/backupFilter.php?filterObjectClass=" + dojo.byId('filterObjectClass').value});
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
	  dijit.byId('idFilterAttribute').store.fetchItemByIdentity({
	    identity : value, 
	    onItem : function(item) { 
	  	  var dataType = dijit.byId('idFilterAttribute').store.getValue(item, "dataType", "inconnu");
	  	  dijit.byId('idFilterOperator').store = new dojo.data.ItemFileReadStore({url: '../tool/jsonList.php?listType=operator&dataType=' + dataType});	  		
	  	  dijit.byId('idFilterOperator').store.fetch({
	  	  	query : {id : "*"},
	  	  	count : 1,
	  	  	onItem : function(item) { 
	  	  		dijit.byId('idFilterOperator').attr("value",dijit.byId('idFilterOperator').store.getValue(item,"id",""));
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
	  			dijit.byId('filterValueCheckbox').attr('checked','');
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
	  			dijit.byId('filterValueList').attr('value','');
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	  		} else if (dataType=="date") {
	  			filterType="date";
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
	  			dojo.style(dijit.byId('filterValueDate').domNode, {display:'block'});
	  			dijit.byId('filterValueDate').attr('value','');
	  		} else {
	  	  	filterType="text";
	  			dojo.style(dijit.byId('filterValue').domNode, {display:'block'});
	  			dijit.byId('filterValue').attr('value','');
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
	  dijit.byId('filterValue').attr('value','');
		dijit.byId('filterValueList').attr('value','');
		dijit.byId('filterValueCheckbox').attr('value','');
		dijit.byId('filterValueDate').attr('value','');
	} else {
		dojo.style(dijit.byId('idFilterOperator').domNode, {visibility:'hidden'});
		dojo.style(dijit.byId('filterValue').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueList').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueCheckbox').domNode, {display:'none'});
		dojo.style(dijit.byId('filterValueDate').domNode, {display:'none'});
	}
}

/**
 * Save filter clause
 * 
 */
function addfilterClause() {
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').attr('value');
	}
	if (filterType=="") { 
		showAlert(i18n('attributeNotSelected')); 
		exit;
	}
	if (filterType=="list" && dijit.byId('filterValueList').attr('value')=='') {
		showAlert(i18n('valueNotSelected')); 
		exit;
	}
	if (filterType=="date" && ! dijit.byId('filterValueDate').attr('value')) {
		showAlert(i18n('valueNotSelected')); 
		exit;
	}		
	if (filterType=="text" && ! dijit.byId('filterValue').attr('value')) {
		showAlert(i18n('valueNotSelected')); 
		exit;
	}		
	// Add controls on operator and value
	loadContent("../tool/addFilterClause.php", "listFilterClauses", "dialogFilterForm", false);
}

/**
 * Remove a filter clause
 * 
 */
function removefilterClause(id) {
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').attr('value');
	}
	// Add controls on operator and value
	dojo.byId("filterClauseId").value=id;
	loadContent("../tool/removeFilterClause.php", "listFilterClauses", "dialogFilterForm", false);
}

/**
 * Action on OK for filter
 * 
 */
function selectFilter() {
	if (dijit.byId('filterNameDisplay')) {
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').attr('value');
	}
	dojo.xhrPost({url: "../tool/backupFilter.php?valid=true",
		form: dojo.byId('dialogFilterForm')
	});
	if (dojo.byId("nbFilterCirteria").value>0) {
		dijit.byId("listFilterFilter").attr("iconClass","iconActiveFilter16");
	} else {
		dijit.byId("listFilterFilter").attr("iconClass","iconFilter16");
	}
	refreshJsonList(dojo.byId('objectClass').value, dojo.byId('listShowIdle').checked);
	dijit.byId("dialogFilter").hide();
}

/**
 * Action on Cancel for filter
 * 
 */
function cancelFilter() {
	dojo.xhrPost({url: "../tool/backupFilter.php?cancel=true",
		form: dojo.byId('dialogFilterForm')
	});
		dijit.byId('dialogFilter').hide();
}

/**
 * Action on Clear for filter
 * 
 */
function clearFilter() {
	if (dijit.byId('filterNameDisplay')) {
		dijit.byId('filterNameDisplay').attr('value',"");
	}
	dojo.byId('filterName').value="";
	removefilterClause('all');	
	//setTimeout("selectFilter();dijit.byId('listFilterFilter').attr('iconClass','iconFilter16');",100);
	dijit.byId('listFilterFilter').attr('iconClass','iconFilter16');
}

/**
 * Save a filter as a stored filter
 * 
 */
function saveFilter() {
	if (dijit.byId('filterNameDisplay')) {
		if (dijit.byId('filterNameDisplay').attr('value')=="") {
			showAlert(i18n("messageMandatory", new Array(i18n("filterName")) ));
			exit;
		}
		dojo.byId('filterName').value=dijit.byId('filterNameDisplay').attr('value');
	}
	loadContent("../tool/saveFilter.php", "listStoredFilters", "dialogFilterForm", false);
}

/**
 * Select a stored filter in the list and fetch criteria
 * 
 */
function selectStoredFilter(idFilter) {
	loadContent("../tool/selectStoredFilter.php?idFilter="+idFilter, "listFilterClauses", "dialogFilterForm", false);
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
