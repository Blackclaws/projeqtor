// ============================================================================
// All specific ProjectOr functions aqnd variables
// This file is included in the main.php page, to be reachable in every context
// ============================================================================

//=============================================================================
//= Variables (global)
//=============================================================================
var i18nMessages=null;                 // array containing i18n messages
var currentLocale=null;                // the locale, from browser or user set

var cancelRecursiveChange_OnGoingChange = false; // boolean to avoid recursive change trigger
var formChangeInProgress = false;      // boolean to avoid exit from form when changes are not saved
var currentRow = null;                 // the row num of the current selected element in the main grid

var currentFieldId = '';               // Id of the ciurrent form field (got via onFocus)
var currentFieldValue = '';            // Value of the current form field (got via onFocus)

//=============================================================================
//= Functions
//=============================================================================

/** ============================================================================
 * Shows a wait spinner
 * @return void
 */
function showWait() {
	showField("wait");
}

/** ============================================================================
 * Shows a wait spinner
 * @return void
 */
function hideWait() {
	hideField("wait");
}

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

/** ============================================================================
 * Display a Dialog Error Message Box
 * @param msg the message to display in the box 
 * @return void
 */
function showError (msg) {
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

/** ============================================================================
 * Display a About Box
 * @param msg the message of the about box (must be passed here because built in php)
 * @return void 
 */
function showAbout (msg) {
	showInfo(msg);
}

/** ============================================================================
 * Refresh the ItemFileReadStore storing Data for the main grid 
 * @param className the class of objects in the list
 * @param idle the idle filter parameter
 * @return void 
 */
function refreshJsonList(className, idle) {
	var grid = dijit.byId("objectGrid");
	if (grid) {
		store = grid.store;
		store.close();
		url="../tool/jsonQuery.php?objectClass=" + className;
		if (idle) { url = url + "&idle=true"; }
		store.fetch();
		grid.setStore(new dojo.data.ItemFileReadStore({url: url, clearOnClose: 'true'}));
  }	
}

/** ============================================================================
 * Filter the Data of the main grid on Id and/or Name
 * @return void 
 */
function filterJsonList() {
	var filterId=dojo.byId('listIdFilter');
	var filterName=dojo.byId('listNameFilter');
	var grid = dijit.byId("objectGrid");
	if (grid && filterId && filterName) {
		filter = {};
		filter.id='*'; // delfault
		if (filterId.value && filterId.value!='') {
			filter.id = '*'+filterId.value+'*';
		}
		if (filterName.value && filterName.value!='') {
			filter.name = '*' + filterName.value + '*';
		}
		//alert('id:'+filter.id+'\nname:'+filter.name);
		grid.query=filter;
		grid._refresh();
  }
}

/** ============================================================================
 * Return the current time, correctly formated as HH:MM
 * @return the current time correctly formated
 */
function getTime() {
	var currentTime = new Date();
	var hours = currentTime.getHours();
	var minutes = currentTime.getMinutes();
	if (minutes < 10){
		minutes = "0" + minutes;
	}
	return hours + ":" + minutes;
}

/** ============================================================================
 * Add a new message in the message Div, on top of messages (last being on top)
 * @param msg the message to add
 * @return void
 */
function addMessage(msg) {
  var msgDiv = dojo.byId("messageDiv");
  if (msgDiv) {
  	msgDiv.innerHTML= "[" + getTime() + "] " + msg + "<br/>" + msgDiv.innerHTML;
  }
}

/** ============================================================================
 * Change display theme to a new one.
 * Themes must be defined is projector.css.
 * The change is also stored in Session.
 * @param newTheme the new theme
 * @return void
 */
function changeTheme(newTheme) {
	if (newTheme!="") {
	  dojo.byId('body').className=newTheme;
	  dojo.xhrPost({
	  	url: "../tool/saveDataToSession.php?id=theme&value=" + newTheme,
	  	//load: function(data,args) { addMessage("Theme=" + newTheme ); }
	  });
	}
}

/** ============================================================================
 * Change the current locale. 
 * Has an impact on i18n function. 
 * The change is also stored in Session.
 * @param locale the new locale (en, fr, ...)
 * @return void
 */
function changeLocale(locale) {
	if (locale!="") {
		currentLocale=locale;
	  dojo.xhrPost({
	  	url: "../tool/saveDataToSession.php?id=currentLocale&value=" + locale,
	  	load: function(data,args) {
	  	  action = function() { window.location=("../view/main.php"); };
	  	  showConfirm (i18n('confirmLocaleChange'), action); },
	  	error: function(error,args){}
	  });
	}
}

/** ============================================================================
 * Change display theme to a new one.
 * Themes must be defined is projector.css.
 * The change is also stored in Session.
 * @param newTheme the new theme
 * @return void
 */
function saveResolutionToSession() {
alert("OK1");
  dojo.xhrPost({
  	url: "../tool/saveDataToSession.php?id=screenHeight&value=" + screen.height,
  	load: function(data,args) { }
  });
alert("OK2");
  dojo.xhrPost({
  	url: "../tool/saveDataToSession.php?id=screenWidth&value=" + screen.width,
  	load: function(data,args) { }
  });
alert("OK3");	
}

/** ============================================================================
 * Check if the recived key is able to change content of field or not
 * @param keyCode the code of the key
 * @return boolean : true if able to change field, else false
 */
function isUpdatableKey(keyCode) {
	if (keyCode==9											// tab
	 || (keyCode>=16 && keyCode<=20)    // shift, ctrl, alt, pause, caps lock		
	 || (keyCode>=33 && keyCode<=40)    // Home, end, page up, page down, arrows (left, right, up, down)
	 || keyCode==91   									// Windows
//	 || (keyCode>=112 && keyCode<=123)  // Function keys 
	 || keyCode==145   									// stop
	 || keyCode>=166  									// Media keys
	 ) {
		return false;
	} 
	return true;                        // others
}

/** ============================================================================
 * Clean the content of a Div.
 * To be sure all widgets are cleaned before setting new data in the Div.
 * If fadeLoading is true, the Div fades away before been cleaned.
 * (fadeLoadsing is a global var definied in main.php) 
 * @param destination the name of the Div to clean
 * @return void
 */
function cleanContent(destination) {
	var contentNode = dojo.byId(destination);
	var contentWidget = dijit.byId(destination);
	if ( ! (contentNode && contentWidget) ) {
		return;
	}
	if ( ! fadeLoading) {		
	  contentWidget.attr('content',null);
	  return;
	}
  dojo.fadeOut({ 
    node: contentNode ,
    duration: 10, 
    onEnd: function() {
  	  var contentWidget = dijit.byId(destination);
  	  contentWidget.attr('content',null);
    }
  }).play();
}

/** ============================================================================
 * Load the content of a Div with a new page.
 * If fadeLoading is true, the Div fades away before, and fades back in after.
 * (fadeLoadsing is a global var definied in main.php) 
 * @param page the url of the page to fetch
 * @param destination the name of the Div to load into
 * @param formName the name of the form containing data to send to the page
 * @param isResultMessage boolean to specify that the destination must show the 
 *        result of some treatment, calling finalizeMessageDisplay 
 * @return void
 */
function loadContent(page, destination, formName, isResultMessage) {
	// Test validity of destination : must be a node and a widget
	var contentNode = dojo.byId(destination);
	var contentWidget = dijit.byId(destination);
	if ( ! (contentNode && contentWidget) ) {
		showError(i18n("errorLoadContent", new Array(page, destination, formName, isResultMessage)));
		return;
	}
	showWait();
	// Direct mode, without fading effect =====
	if ( ! fadeLoading) {
		// send Ajax request
		dojo.xhrPost({
      url: page,
      form: formName,
      handleAs: "text",
      load: function(data,args){
			  // update the destination when ajax request is received
        var contentWidget = dijit.byId(destination);
      	contentWidget.attr('content',data);
      	if (destination=="detailDiv") {
        	finaliseButtonDisplay();
        }
      	if (destination=="loginResultDiv") {
      		checkLogin();
      	}
      	if (destination=="passwordResultDiv") {
      		checkLogin();
      	}
      	if (isResultMessage) {
      		var contentNode = dojo.byId(destination);
      		// Set the Div visible, needed if destination is result message (invisible before needed)
  		    dojo.fadeIn({
  		    	node: contentNode, 
  		    	duration: 1,
  		    	onEnd: function() {
  		    		if (isResultMessage) {
  		    			// finalize message is return from treatment
  		    			finalizeMessageDisplay(destination);
  		    		}
  		    	}
  		    	}).play();
    		}
      	hideWait();
      },
      error: function(error,args){showError(i18n("errorXhrPost", new Array(page, destination, formName, isResultMessage, error)));}
    });
		return;
	}
	// Smooth mode, with fading effect =====
	// fade out the destination, for smooth effect
  dojo.fadeOut({ 
    node: contentNode ,
    duration: 100, 
    onEnd: function() {
      // send Ajax request
      dojo.xhr("POST",{
        url: page,
        form: dojo.byId(formName),
        handleAs: "text",
        load: function(data,args){
          // update the destination when ajax request is received
          var contentWidget = dijit.byId(destination);
        	contentWidget.attr('content',data);
          var contentNode = dojo.byId(destination);
          if (destination=="detailDiv") {
          	finaliseButtonDisplay();
          }
          // fade in the destination, to set is visible back
  		    dojo.fadeIn({
  		    	node: contentNode, 
  		    	duration: 100,
  		    	onEnd: function() {
  		    		if (isResultMessage) {
  		    		  // finalize message is return from treatment
  		    			finalizeMessageDisplay(destination);
  		    		} else if (destination=="loginResultDiv") {
  	        		checkLogin();
   		    		} else if (destination=="passwordResultDiv") {
  	        		checkLogin();
  	        	} else {
      	        hideWait();
  	        	}
  		    	}
  		    }).play();
        },
        error: function(error,args){showError(i18n("errorXhrPost", new Array(page, destination, formName, isResultMessage, error)));}
      },true);
    }
  }).play(); 
}

/** ============================================================================
 * Chek the return code from login check, if valid, refresh page to continue
 * @return void
 */
function checkLogin() {
	resultNode=dojo.byId('validated');
	resultWidget=dojo.byId('validated');
	if (resultNode && resultWidget) {
		showWait();
		if (changePassword) {
			window.location=".?changePassword=true";
		} else {
		  window.location=".";
		}
	} else {
    hideWait();
	}
}
/** ============================================================================
 * Submit a form, after validating the data
 * @param page the url of the page to fetch
 * @param destination the name of the Div to load into
 * @param formName the name of the form containing data to send to the page
 * @return void
 */
function submitForm(page, destination, formName) {
	var formVar = dijit.byId(formName);
	if ( ! formVar) {
		showError(i18n("errorSubmitForm", new Array(page, destination, formName)));
		return;
	}
	// validate form Data
	if(formVar.validate()){
		formLock();
		// form is valid, continue and submit it
		var isResultDiv=true;
		if (formName=='passwordForm') { isResultDiv=false; };
    loadContent(page,destination, formName, isResultDiv);
  } else {
    showAlert(i18n("alertInvalidForm"));
  }
}

/** ============================================================================
 * Finalize some operations after receiving validation message of treatment
 * @param destination the name of the Div receiving the validation message
 * @return void
 */
function finalizeMessageDisplay(destination) {
	var contentNode = dojo.byId(destination);
  var contentWidget = dijit.byId(destination);
  var lastOperationStatus = dojo.byId('lastOperationStatus');
  var lastOperation = dojo.byId('lastOperation');
  if ( ! (contentWidget && contentNode && lastOperationStatus && lastOperation) ) {
  	showError(i18n("errorFinalizeMessage", new Array(destination)));
  	return;    
  }
  // fetch last message type
  var message=contentWidget.attr('content');
  posdeb=message.indexOf('class="')+7;
  posfin=message.indexOf('>')-1;
  typeMsg=message.substr(posdeb, posfin-posdeb);
  // if operation is OK
	if (lastOperationStatus.value=="OK") {
		posdeb=posfin+2;
  	posfin=message.indexOf('<',posdeb);
  	msg=message.substr(posdeb, posfin-posdeb);
  	// add the message in the message Div (left part) and prepares form to new changes
  	addMessage(msg);
  	formInitialize();
  	// refresh the grid to reflect changes
  	var lastSaveId=dojo.byId('lastSaveId');
  	var objectId=dojo.byId('objectId');
  	if (objectId && lastSaveId) {
  		objectId.value=lastSaveId.value;
  	}
    var grid = dijit.byId("objectGrid");  
  	if (grid) {
  		store = grid.store;
  		store.close();
  		store.fetch();
      grid._refresh();
    }
    // last operations depending on the executed operatoin (insert, delete, ...)
  	if (lastOperation.value=="insert") {
  		dojo.byId('id').value=lastSaveId.value;
  		// TODO : after insert select the current line in the grid
  		//selectRowById("objectGrid", lastSaveId.value); // does not work because grid is refreshing...
  	}
  	if (lastOperation.value=="copy") {
  	  // TODO : after copy select the current line in the grid
  		//selectRowById("objectGrid", lastSaveId.value); // does not work because grid is refreshing...
  	}
  	if (lastOperation.value=="delete") {
  		zone=dijit.byId("formDiv");
  		msg=dojo.byId("noDataMessage");
  		if (zone && msg) {
  			zone.attr('content',msg.value);
  		}
  		unselectAllRows("objectGrid");
  		finaliseButtonDisplay();
  	}
  	if (grid && refreshUpdates=="YES" && lastOperation.value!="delete") {
  		loadContent("objectDetail.php?refresh=true", "formDiv", 'listForm');
  	} else {
  		hideWait();
  	}
  } else {
  	formInitialize();
  	hideWait();
  }
	// If operation is correct (not an error) slowly fade the result message
	if (lastOperationStatus.value!="ERROR") {
		dojo.fadeOut({node: contentNode, duration: 3000}).play();
	}
}

/** ============================================================================
 * Operates locking, hide and show correct buttons after loadContent, 
 * when destination is detailDiv 
 * @return void
 */
function finaliseButtonDisplay() {
  id = dojo.byId("id");
  if ( id ) {
  	if (id.value=="") {
  		// id exists but is not set => new item, all buttons locked until first change
  		formLock();
  		enableWidget('newButton');
  		enableWidget('saveButton');
  		enableWidget('undoButton');
  	}
  } else {
  	// id does not exist => not selected, only new button possible
  	formLock();
  	enableWidget('newButton');
  }
}

/** ============================================================================
 * Operates locking, hide and show correct buttons when a change is done on form
 * to be able to validate changes, and avoid actions that may lead to loose change
 * @return void
 */
function formChanged() {
	disableWidget('newButton');
	enableWidget('saveButton');
	disableWidget('printButton');
	disableWidget('copyButton');
	enableWidget('undoButton');
	disableWidget('deleteButton');
	disableWidget('refreshButton');
	formChangeInProgress=true;
	grid=dijit.byId("objectGrid");
	if (grid) {
		// TODO : lock grid selection
		//saveSelection=grid.selection;
		grid.selectionMode="none";
		
	}
}

/** ============================================================================
 * Operates unlocking, hide and show correct buttons when a form is refreshed
 * to be able to operate actions only available on forms with no change ongoing, 
 * and avoid actions that may lead to unconsistancy
 * @return void
 */
function formInitialize() {
	enableWidget('newButton');
	enableWidget('saveButton');
	enableWidget('printButton');
	enableWidget('copyButton');
	enableWidget('undoButton');
	enableWidget('deleteButton');
	enableWidget('refreshButton');
	formChangeInProgress=false;
}

/** ============================================================================
 * Operates locking, to disable all actions during form submition
 * @return void
 */
function formLock() {
	disableWidget('newButton');
	disableWidget('saveButton');
	disableWidget('printButton');
	disableWidget('copyButton');
	disableWidget('undoButton');
	disableWidget('deleteButton');
	disableWidget('refreshButton');
}

/** ============================================================================
 * Disable a widget, testing it exists before to avoid error
 * @return void
 */
function disableWidget(widgetName) {
	if (dijit.byId(widgetName)) {
	  dijit.byId(widgetName).attr('disabled',true);
	}
}

/** ============================================================================
 * Enable a widget, testing it exists before to avoid error
 * @return void
 */
function enableWidget(widgetName) {
	if (dijit.byId(widgetName)) {
	  dijit.byId(widgetName).attr('disabled',false);
  }
}

/** ============================================================================
 * Check if change is possible : to avoid recursive change when computing data
 * from other changes
 * @return boolean indicating if change is allowed or not
 */
function testAllowedChange(val) {
	if (cancelRecursiveChange_OnGoingChange==true) {
	  return false;
	} else {
		if (val==null) {
			return false;
		} else {
			cancelRecursiveChange_OnGoingChange=true;
			return true;
		}
	}
}

/** ============================================================================
 * Checks that ongoing change is finished, so another change cxan be taken into account
 * so that testAllowedChange() can return true
 * @return void
 */
function terminateChange() {
	cancelRecursiveChange_OnGoingChange=false;
}

/** ============================================================================
 * Check if a change is waiting for form submission
 * to be able to avoid unwanted actions leading to loose of data change
 * @return boolean indicating if change is in progress for the form
 */
function checkFormChangeInProgress(actionYes, actionNo) {
	if (formChangeInProgress) {
    if (actionYes) {
    	if (! actionNo) {
    		actionNo=function() {  };
    	}
    	showQuestion(i18n("confirmChangeLoosing"), actionYes, actionNo);
    } else {
    	showAlert(i18n("alertOngoingChange"));
    }
		return true;
	} else {
		if (actionYes) {
			actionYes();
		}
    return false;
	}
}

/** ============================================================================
 * Unselect all the lines of the grid
 * @param gridName the name of the grid 
 * @return void
 */
function unselectAllRows(gridName) {
	grid = dijit.byId(gridName); // if the element is not a widget, exit.
	if ( ! grid) { 
		return;
  }
	var items=grid.selection.getSelected();
	if (items.length) {
		dojo.forEach(items, function(selectedItem) {
		  if (selectedItem !== null) {
		  	grid.selection.setSelected(grid.getItemIndex(selectedItem),false);
		  }
		});
	}
}

/** ============================================================================
 * Select a given line of the grid, corresponding to the given id
 * @param gridName the name of the grid 
 * @param id the searched id
 * @return void
 */
function selectRowById(gridName, id) {
	grid = dijit.byId(gridName); // if the element is not a widget, exit.
	if ( ! grid) { 
		return;
  }
	grid.
	unselectAllRows(gridName); //first unselect, to be sure to select only requested id
	var nbRow=grid.rowCount;
	for (i=0; i<nbRow; i++) {
		item=grid.getItem(i);
		itemId=item.id;
	  if (itemId==id) {
	  	grid.selection.setSelected(i,true);
	  }
	}
}


/** ============================================================================
 * i18n (internationalization) function to return all messages and caption in 
 * the language corresponding to the locale
 * File lang.js must exist in directory tool/i18n/nls/xx (xx as locale)
 * otherwise default is uses (english)
 * (similar function exists in php, using same resource)
 * @param str the code of the string message 
 * @param vars an array of parameters to replace in the message. They appear as ${n}.
 * @return the formated message, in the correct language
 */
function i18n(str, vars) {
	if ( ! i18nMessages) {
		dojo.requireLocalization("i18n","lang", currentLocale);
		i18nMessages=dojo.i18n.getLocalization("i18n","lang", currentLocale);
	}
	if (i18nMessages[str]) {
		ret = i18nMessages[str];
		if (vars) {
			for (i=0; i<vars.length; i++) {
				rep='${' + (parseInt(i)+1) +'}';
				pos=ret.indexOf(rep);
				while (pos>=0) {
					ret=ret.substring(0,pos) + vars[i] + ret.substring(pos+rep.length);
					pos=ret.indexOf(rep);
				}
			}
		}
		return ret;
	} else {
		return "["+ str + "]";
	}
}

/** ============================================================================
 * set the selected project (transmit it to session)
 * @param idProject the id of the selected project
 * @param nameProject the name of the selected project
 * @param selectionField the name of the field where selection is executed
 * @return void
 */
function setSelectedProject(idProject, nameProject, selectionField) {
	if (idProject!="") {
	  dojo.xhrPost({
	  	url: "../tool/saveDataToSession.php?id=project&value=" + idProject,
	  	load: function(data,args) { addMessage(i18n("Project")+ "=" + nameProject ); }
	  });
	}
}

function disconnect() {
	disconnectFunction = function() {
    dojo.xhrPost({
  	  url: "../tool/saveDataToSession.php?id=disconnect",
  	  load: function(data,args) { window.location="../index.php"; }
    });
	};
  showConfirm(i18n('confirmDisconnection'),disconnectFunction);
}
// ============================================================================
// = FORMATTERS (available for dojox.DataGrid formating)
// ============================================================================

/** ============================================================================
 * Format boolean to present a chechbox (checked or not depending on the value)
 * @param value the value of the boolean (true or false)
 * @return the formatted value as an image (html code)
 */
function booleanFormatter(value) {
  if (value==1) { 
  	return '<img src="img/checkedOK.png" width="12" height="12" />'; 
  } else { 
  	return '<img src="img/checkedKO.png" width="12" height="12" />'; 
  }
}


/** ============================================================================
 * Format boolean to present a color
 * @param value the value of the boolean (true or false)
 * @return the formatted value as an image (html code)
 */
function colorFormatter(value) {
  if (value) { 
  	return '<table width="100%"><tr><td style="background-color: ' + value + '; width: 100%;">&nbsp;</td></tr></table>'; 
  } else { 
  	return ''; 
  }
}