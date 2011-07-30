// ============================================================================
// All specific ProjectOr functions and variables
// This file is included in the main.php page, to be reachable in every context
// ============================================================================

//=============================================================================
//= Variables (global)
//=============================================================================

var i18nMessages=null;                 // array containing i18n messages
var currentLocale=null;                // the locale, from browser or user set
var browserLocale=null;                // the locale, from browser
var cancelRecursiveChange_OnGoingChange = false; // boolean to avoid recursive change trigger
var formChangeInProgress = false;      // boolean to avoid exit from form when changes are not saved
var currentRow = null;                 // the row num of the current selected element in the main grid
var currentFieldId = '';               // Id of the ciurrent form field (got via onFocus)
var currentFieldValue = '';            // Value of the current form field (got via onFocus)
var g;                                 // Gant chart for JsGantt : must be named "g"

//=============================================================================
//= Functions
//=============================================================================

/** ============================================================================
 * Refresh the ItemFileReadStore storing Data for the main grid 
 * @param className the class of objects in the list
 * @param idle the idle filter parameter
 * @return void 
 */
function refreshJsonList(className) {
	var grid = dijit.byId("objectGrid");
	if (grid) {
		//store = grid.store;
		//store.close();
		url="../tool/jsonQuery.php?objectClass=" + className;
		if ( dojo.byId('listShowIdle') ) {
			if (dojo.byId('listShowIdle').checked) { url = url + "&idle=true"; }
		}
		if ( dijit.byId('listTypeFilter') ) {
			if (dijit.byId('listTypeFilter').value!='') {
				url = url + "&objectType=" + dijit.byId('listTypeFilter').value; 
		  }
		}
		//store.fetch();
		grid.setStore(new dojo.data.ItemFileReadStore({
			url: url, 
			clearOnClose: 'true'
		}));
		store = grid.store;
		store.fetch({onComplete: function(){filterJsonList();}});
  }

}

/** ============================================================================
 * Refresh the ItemFileReadStore storing Data for the planning (gantt)
 * @return void 
 */
function refreshJsonPlanning() {
	url="../tool/jsonPlanning.php";
	if ( dojo.byId('listShowIdle') ) {
		if (dojo.byId('listShowIdle').checked) { url = url + "?idle=true"; }
	}
	loadContent(url, "planningJsonData",'listForm',false);
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
			filter.id = '*' + filterId.value + '*';
		}
		if (filterName.value && filterName.value!='') {
			filter.name = '*' + filterName.value + '*';
		}
		grid.query=filter;
		grid._refresh();
  }
	refreshGridCount();
}

/**
 * Refresh de display of number of items in the grid
 * @param repeat internal use only
 */
function refreshGridCount(repeat) {
	var grid = dijit.byId("objectGrid");
	if (grid.rowCount==0 && ! repeat) {
	  //dojo.byId('gridRowCount').innerHTML="?";
		setTimeout("refreshGridCount(1);",100);
	} else {
	dojo.byId('gridRowCount').innerHTML=grid.rowCount;
	dojo.byId('gridRowCountShadow1').innerHTML=grid.rowCount;
	dojo.byId('gridRowCountShadow2').innerHTML=grid.rowCount;
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
	  	url: "../tool/saveDataToSession.php?id=theme&value=" + newTheme
	  	//, load: function(data,args) { addMessage("Theme=" + newTheme ); }
	  });
	}
}

/** ============================================================================
* Save the browser locale to session. 
* Needed for number formating under PHP 5.2 compatibility
* @param none
* @return void
*/
function saveBrowserLocaleToSession() {
	browserLocale=dojo.locale;
  dojo.xhrPost({
  	url: "../tool/saveDataToSession.php?id=browserLocale&value=" + browserLocale,
  	load: function(data,args) { }
  });
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
	var height=screen.height;
	var width=screen.width;
  dojo.xhrPost({
  	url: "../tool/saveDataToSession.php?id=screenHeight&value=" + height,
  	load: function(data,args) { }
  });
  dojo.xhrPost({
  	url: "../tool/saveDataToSession.php?id=screenWidth&value=" + width,
  	load: function(data,args) { }
  });
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
	 || (keyCode==67)                   // ctrl+C
	 || keyCode==91   									// Windows
//	 || (keyCode>=112 && keyCode<=123)  // Function keys 
	 || keyCode==144   									// numlock
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
	contentWidget.attr('content',null);
	return;

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
function loadContent(page, destination, formName, isResultMessage, validationType, directAccess) {
	// Test validity of destination : must be a node and a widget
	var contentNode = dojo.byId(destination);
	var contentWidget = dijit.byId(destination);
	if ( ! (contentNode && contentWidget) ) {
		console.warn(i18n("errorLoadContent", new Array(page, destination, formName, isResultMessage,destination)));
		return;
	}
	if (contentNode) {
		destinationWidth=dojo.style(contentNode, "width");
		if (destination=='detailFormDiv') {
			widthNode=dojo.byId('detailDiv');
			if (widthNode) {
				destinationWidth=dojo.style(widthNode, "width");
			}
		}
		if ( page.indexOf("?")>0) {
			page+="&destinationWidth="+destinationWidth;
		} else {
			page+="?destinationWidth="+destinationWidth;
		}
	}
	showWait();
	// Direct mode, without fading effect =====
	if ( ! fadeLoading) {
		// send Ajax request
		dojo.xhrPost({
      url: page,
      form: dojo.byId(formName),
      handleAs: "text",
      load: function(data,args){
			  // update the destination when ajax request is received
			  //cleanContent(destination);
        var contentWidget = dijit.byId(destination);
      	contentWidget.attr('content',data);
      	if (destination=="detailDiv" || destination=="centerDiv") {
      		finaliseButtonDisplay();
        }
        if (directAccess) {
        	if (dijit.byId('listIdFilter')) {
        		//dijit.byId('listIdFilter').attr('value',directAccess);
        		//setTimeout("filterJsonList();",100);
        		dojo.byId('objectId').value=directAccess;
        		//dijit.byId("listDiv").domNode.style.height="100px";
        		dijit.byId("listDiv").resize({h: 0});
        		dijit.byId("mainDivContainer").resize();
        		loadContent("objectDetail.php", "detailDiv", 'listForm');
        	}
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
  		    			finalizeMessageDisplay(destination,validationType);
  		    		}
  		    	}
  		    	}).play();
    		} else if (destination=="loginResultDiv") {
    			checkLogin();
	      } else if (destination=="passwordResultDiv") {
      		checkLogin();
	      } else if (page.indexOf("planningMain.php")>=0 || page.indexOf("planningList.php")>=0
   			    || page.indexOf("jsonPlanning.php")>=0) {  		      		
	      	drawGantt();
      		hideWait();
      	} else {
	        hideWait();
      	}
      },
      error: function(error,args){
        console.warn(i18n("errorXhrPost", new Array(page, destination, formName, isResultMessage, error)));
        hideWait();}
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
  	dojo.xhrPost({
        url: page,
        form: dojo.byId(formName),
        handleAs: "text",
        load: function(data,args){
  		// update the destination when ajax request is received
  		    //cleanContent(destination);
          var contentWidget = dijit.byId(destination);
        	contentWidget.attr('content',data);
          var contentNode = dojo.byId(destination);
          if (destination=="detailDiv" || destination=="centerDiv" ) {
          	finaliseButtonDisplay();
          }
          if (directAccess) {
          	if (dijit.byId('listIdFilter')) {
          		//dijit.byId('listIdFilter').attr('value',directAccess);
          		//setTimeout("filterJsonList();",100);
          		dojo.byId('objectId').value=directAccess;
          		//dijit.byId("listDiv").domNode.style.height="100px";
          		dijit.byId("listDiv").resize({h: 0});
          		dijit.byId("mainDivContainer").resize();
          		loadContent("objectDetail.php", "detailDiv", 'listForm');
          	}
          }
          // fade in the destination, to set is visible back
  		    dojo.fadeIn({
  		    	node: contentNode, 
  		    	duration: 100,
  		    	onEnd: function() {
  		    		if (isResultMessage) {
  		    		  // finalize message is return from treatment
  		    			finalizeMessageDisplay(destination, validationType);
  		    		} else if (destination=="loginResultDiv") {
  	        		checkLogin();
   		    		} else if (destination=="passwordResultDiv") {
  	        		checkLogin();
   		      	} else if (page.indexOf("planningMain.php")>=0 || page.indexOf("planningList.php")>=0
   		      			    || page.indexOf("jsonPlanning.php")>=0) {  		      		
   		      		drawGantt();
   		      		hideWait();
  	        	} else {
      	        hideWait();
  	        	}
  		    	}
  		    }).play();
        },
        error: function(error,args){
        	console.warn(i18n("errorXhrPost", new Array(page, destination, formName, isResultMessage, error)));
        }
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
		//showWait();
		if (changePassword) {
			window.location="main.php?changePassword=true";
		} else {
		  window.location="main.php";
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
function finalizeMessageDisplay(destination, validationType) {
	var contentNode = dojo.byId(destination);
  var contentWidget = dijit.byId(destination);
  var lastOperationStatus = dojo.byId('lastOperationStatus');
  var lastOperation = dojo.byId('lastOperation');
  // scpecific Plan return
  if (destination=="planResultDiv") {
  	lastOperationStatus = dojo.byId('lastPlanStatus');
  	lastOperation = "plan";
  }
  var noHideWait=false;
  if ( ! (contentWidget && contentNode && lastOperationStatus && lastOperation) ) {
  	returnMessage="";
  	if (contentWidget) {
  		returnMessage=contentWidget.attr('content');
  	}
  	showError(i18n("errorFinalizeMessage", new Array(destination,returnMessage)));
  	hideWait();
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
  	if (validationType=='note' || validationType=='attachement' || validationType=="link" 
  		|| validationType=="assignment" || validationType=="dependency") {
  		if (validationType=='note') {
  			loadContent("objectDetail.php?refreshNotes=true", "notesPane", 'listForm');
  		} else if (validationType=='attachement') {
    	  loadContent("objectDetail.php?refreshAttachements=true", "attachementsPane", 'listForm');
  		} else if (validationType=='link') {
  			loadContent("objectDetail.php?refresh=true", "detailFormDiv", 'listForm');
  		} else if (validationType=='assignment') {
  			loadContent("objectDetail.php?refresh=true", "detailFormDiv", 'listForm');
  		} else if (validationType=='dependency') {
  			loadContent("objectDetail.php?refresh=true", "detailFormDiv", 'listForm');
  		} else {
  			hideWait();
  	  }
  	} else {
	  	formInitialize();
	  	// refresh the grid to reflect changes
	  	var lastSaveId=dojo.byId('lastSaveId');
	  	var objectId=dojo.byId('objectId');
	  	if (objectId && lastSaveId) {
	  		objectId.value=lastSaveId.value;
	  	}
	  	// Refresh the Grid list (if visible)
	    var grid = dijit.byId("objectGrid");  
	  	if (grid) {
	  		store = grid.store;
	  		store.close();
	  		store.fetch();
	      grid._refresh();
	    }
	  	// Refresh the planning Gantt (if visible)
	  	if (dojo.byId(destination=="planResultDiv" || dojo.byId("GanttChartDIV"))) {
	  		noHideWait=true;
	  		refreshJsonPlanning();
	  		//loadContent("planningList.php", "listDiv", 'listForm');
	  		
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
	  	if ( (grid || dojo.byId("GanttChartDIV")) && dojo.byId("detailFormDiv") && refreshUpdates=="YES" && lastOperation.value!="delete") {
	  		//loadContent("objectDetail.php?refresh=true", "formDiv", 'listForm');
	  		if (lastOperation.value=="copy") {
	  			loadContent("objectDetail.php?", "detailDiv", 'listForm');
		  	} else {
		  		loadContent("objectDetail.php?refresh=true", "detailFormDiv", 'listForm');
		  		// Need also to refresh History
		  		if (dojo.byId("historyPane")) {
		  			loadContent("objectDetail.php?refreshHistory=true", "historyPane", 'listForm');
		  		}
		  		if (lastOperation.value=="insert" && ! validationType) {
			  		if (dojo.byId("attachementsPane")) {
			  			loadContent("objectDetail.php?refreshAttachements=true", "attachementsPane", 'listForm');
			  		}
			  		if (dojo.byId("notesPane")) {
			  			loadContent("objectDetail.php?refreshNotes=true", "notesPane", 'listForm');
			  		}
		  		}
		  	}
	  	} else {
	  		if ( !noHideWait ) {
	  			hideWait();
	  		}
	  	}
  	}
	} else if (lastOperationStatus.value=="INVALID") {
		if (formChangeInProgress) {
			formInitialize();
			formChanged();
	  } else {
	  	formInitialize();
	  }
  } else {
  	if (validationType!='note' && validationType!='attachement') {
  		formInitialize();
  	}
  	hideWait();
  }
	// If operation is correct (not an error) slowly fade the result message
	if (lastOperationStatus.value!="ERROR" && lastOperationStatus.value!="INVALID") {
		dojo.fadeOut({node: contentNode, duration: 3000}).play();
	} else {
		if (lastOperationStatus.value=="ERROR") {
		  showError(message);
		} else {
			showAlert(message);
		}
		hideWait();
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
  		disableWidget('undoButton');
  	}
  } else {
  	// id does not exist => not selected, only new button possible
  	formLock();
  	enableWidget('newButton');
  }
  buttonRightLock();
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
	buttonRightLock();
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
	disableWidget('undoButton');
	enableWidget('deleteButton');
	enableWidget('refreshButton');
	formChangeInProgress=false;
	buttonRightLock();
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
 * Lock some buttons depending on access rights
 */
function buttonRightLock() {
	var createRight=dojo.byId('createRight');
	var updateRight=dojo.byId('updateRight');
	var deleteRight=dojo.byId('deleteRight');
	if (createRight) {
		if (createRight.value!='YES') {
			disableWidget('newButton');
			disableWidget('copyButton');
		}
	}
	if (updateRight) {
		if (updateRight.value!='YES') {
			disableWidget('saveButton');
			disableWidget('undoButton');
		}
	}
	if (deleteRight) {
		if (deleteRight.value!='YES') {
			disableWidget('deleteButton');
		}
	}
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
 * Loack a widget, testing it exists before to avoid error
 * @return void
 */
function lockWidget(widgetName) {
	if (dijit.byId(widgetName)) {
	  dijit.byId(widgetName).attr('readOnly',true);
	}
}

/** ============================================================================
 * Unlock a widget, testing it exists before to avoid error
 * @return void
 */
function unlockWidget(widgetName) {
	if (dijit.byId(widgetName)) {
	  dijit.byId(widgetName).attr('readOnly',false);
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
	window.setTimeout("cancelRecursiveChange_OnGoingChange=false;",100);
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
				if (pos>=0) {
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
	  	load: function(data,args) { 
	  		addMessage(i18n("Project")+ "=" + nameProject );
	  	  if (dojo.byId("GanttChartDIV")) {
	  	  	loadContent("planningList.php", "listDiv", 'listForm');
	  	  } else if (dijit.byId("listForm") && dojo.byId('objectClass') && dojo.byId('listShowIdle')) {
	  	  	refreshJsonList(dojo.byId('objectClass').value, dojo.byId('listShowIdle').checked);
	  	  }
	    }
	  });
	}
	if (idProject!="" && idProject!="*") {
		dijit.byId("idProjectPlan").attr("value",idProject);
  }
}

/**
 * Ends current user session
 * @return
 */
function disconnect() {
	disconnectFunction = function() {
    dojo.xhrPost({
  	  url: "../tool/saveDataToSession.php?id=disconnect",
  	  load: function(data,args) { window.location="../index.php"; }
    });
	};
	if ( ! checkFormChangeInProgress() ) {
    showConfirm(i18n('confirmDisconnection'),disconnectFunction);
	}
}

/**
 * Disconnect (kill current session)
 * @return
 */
function quit() {
    dojo.xhrPost({
  	  url: "../tool/saveDataToSession.php?id=disconnect",
  	  load: function(data,args) { }
    });
}

/**
 * Before quitting, check for updates
 * @return
 */
function beforequit() {
	if (formChangeInProgress) {
    return (i18n("alertQuitOngoingChange"));
	} else {
		//return (i18n("alertQuit"));
	}
}

/**
 * Draw a gantt chart using jsGantt
 * @return
 */
function drawGantt() {
	var startDateView=dijit.byId('startDatePlanView').attr('value');
	var gFormat="day";
	if (g) {
		gFormat=g.getFormat();
	}
	g = new JSGantt.GanttChart('g',document.getElementById('GanttChartDIV'), gFormat);
  g.setShowRes(0);             					// Show/Hide Responsible (0/1)
  g.setShowDur(1);             					// Show/Hide Duration (0/1)
  g.setShowComp(1);            					// Show/Hide % Complete(0/1)
  g.setCaptionType('Caption');    					// Set to Show Caption (None,Caption,Resource,Duration,Complete)
  g.setShowStartDate(1);       					// Show/Hide Start Date(0/1)
  g.setShowEndDate(1);         					// Show/Hide End Date(0/1)
  g.setDateInputFormat('yyyy-mm-dd');   // Set format of input dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
  g.setDateDisplayFormat('default'); // Set format to display dates ('mm/dd/yyyy', 'dd/mm/yyyy', 'yyyy-mm-dd')
  g.setFormatArr("day","week","month"); // Set format options (up to 4 : "minute","hour","day","week","month","quarter")
  g.setStartDateView(startDateView);
  var contentNode = dojo.byId('gridContainerDiv');
  if (contentNode) {
  	g.setWidth(dojo.style(contentNode, "width"));
  }
  jsonData=dojo.byId('planningJsonData');
  //g.AddTaskItem(new JSGantt.TaskItem(    0,       'project', '',           '',           'ff0000', '',    0,     '',   '10',  1,      '',       1,    ''  , 'test'));
  if( g && jsonData) {
    var store=eval('('+jsonData.innerHTML+')');
    var items=store.items;
  	for (var i=0; i< items.length; i++) {
      var item=items[i];
      // pStart : start date of task 
      var pStart="";
      pStart=(item.initialStartDate!=" ")?item.initialStartDate:pStart;
      pStart=(item.validatedStartDate!=" ")?item.validatedStartDate:pStart;
      pStart=(item.plannedStartDate!=" ")?item.plannedStartDate:pStart;
      pStart=(item.realStartDate!=" ")?item.realStartDate:pStart;
      // pEnd : end date of task
      var pEnd="";
      pEnd=(item.initialEndDate!=" ")?item.initialEndDate:pEnd;
      pEnd=(item.validatedEndDate!=" ")?item.validatedEndDate:pEnd;
      pEnd=(item.plannedEndDate!=" ")?item.plannedEndDate:pEnd;
      pEnd=(item.realEndDate!=" ")?item.realEndDate:pEnd;
      var realWork=parseFloat(item.realWork);
      var plannedWork=parseFloat(item.plannedWork);
      var progress=100;
      if (plannedWork>0) {
      	progress=Math.round(100*realWork/plannedWork);
      }
      // pGroup : is the tack a group one ?
      var pGroup=(item.elementary=='0')?1:0;
      // runScript : JavaScript to run when click on tack (to display the detail of the task)
      var runScript="dojo.byId('objectClass').value='" + item.refType + "';";
      runScript+="dojo.byId('objectId').value='" + item.refId + "';";
      runScript+="loadContent('objectDetail.php','detailDiv','listForm');";
      // display Name of the task 
      var pName=item.wbs + " " + item.refName; // for testeing purpose, add wbs code
      //var pName=item.refName;
      // display color of the task bar
      var pColor='50BB50';
      // show in red not respected constraints
      if (item.validatedEndDate!=" " && item.validatedEndDate < pEnd) {
      	pColor='BB5050';	
      }
      // pMile : is it a milestone ?
      var pMile=(item.refType=='Milestone')?1:0;
      pClass=item.refType;
      //                        TaskItem(pID,     pName, pStart, pEnd, pColor, pLink,     pMile, pRes,    pComp,     pGroup, pParent,    pOpen, pDepend, Caption)
  		g.AddTaskItem(new JSGantt.TaskItem(item.id, pName, pStart, pEnd, pColor, runScript, pMile, '',   progress,     pGroup, item.topId, 1,     item.depend  ,    '' ,    pClass));
  	}
    g.Draw();	
    g.DrawDependencies();
  }
  else
  {
    showAlert("Gantt chart not defined");
  }
  // Refresh class and id
  var listId=dojo.byId('objectId');
  var objId=dojo.byId('id');
  var listClass=dojo.byId('objectClass');
  var objClass=dojo.byId('className');
  if (listId && listClass && objId && objClass) {
  	listClass.value=objClass.value;
  	listId.value=objId.value;
  }
}

/**
 * calculate diffence (in work days) between dates
 */ 
function workDayDiffDates(paramStartDate, paramEndDate) {
	var startDate=paramStartDate;
	var endDate=paramEndDate;
	var valDay=(24 * 60 * 60 * 1000);
	if ( ! ( ( startDate!=null && startDate!="") && ( endDate!=null && endDate!="") ) ) {
    return "";
  }
	if (getDay(endDate)>=6) {
		endDate.setDate(endDate.getDate()+5-getDay(endDate));
	}
	if (getDay(startDate)>=6) {
		startDate.setDate(startDate.getDate()+8-getDay(startDate));
	}
	if (startDate>endDate) {
    return 0;
  }
	var duration=(endDate - startDate) / valDay;
  duration=Math.round(duration);
  if (duration>=7) {
    duration-=Math.floor(duration/7)*2;
  }
  if (getDay(endDate) < getDay(startDate)) {
  	duration-=2;
  }
  //add 1 day to include first day, dayDiffDates(X,X)=1, dayDiffDates(X,X+1)=2
  duration+=1;
  return duration;
}

/**
* calculate diffence (in days) between dates
*/ 
function dayDiffDates(paramStartDate, paramEndDate) {
	var startDate=paramStartDate;
	var endDate=paramEndDate;
	var valDay=(24 * 60 * 60 * 1000);
	var duration=(endDate - startDate) / valDay;
  duration=Math.round(duration);
  return duration;
}

/**
 * Return the day of the week like php function : date("N",$valDate)
 * Monday=1, Tuesday=2, Wednesday=3, Thursday=4, Friday=5, Saturday=6, Sunday=7 (not 0 !)
 */
function getDay(valDate) {
	var day=valDate.getDay();
	day=(day==0)?7:day;
	return day;
}

/** ============================================================================
 * Calculate new date after adding some days
 * @param $ate start date 
 * @param days numbers of days to add (can be < 0 to subtract days)
 * @return new calculated date 
 */
function addDaysToDate(paramDate, paramDays) {
	var date=paramDate;
	var days=paramDays;
	var endDate=date;
	endDate.setDate(date.getDate()+days);
	return endDate;
}

/** ============================================================================
 * Calculate new date after adding some work days, subtracting week-ends
 * @param $ate start date 
 * @param days numbers of days to add (can be < 0 to subtract days)
 * @return new calculated date 
 */
function addWorkDaysToDate(paramDate, paramDays) {
//alert("paramDate=" + paramDate + "\nparamDays=" + paramDays);
	var startDate=paramDate;
	var days=paramDays;
	if (days<=0) {
		return startDate;
	}
	days-=1;
	if (getDay(startDate)>=6) {
		//startDate.setDate(startDate.getDate()+8-getDay(startDate));
	}
	var weekEnds=Math.floor(days/5);
	var additionalDays=days-(5*weekEnds);
	if (getDay(startDate) + additionalDays >= 6) {
	  weekEnds+=1;
	}
	days+=(2*weekEnds);
	var endDate=startDate;
	endDate.setDate(startDate.getDate()+days);
	return endDate;
}

/**
 * Check "all" checkboxes on workflow definition
 * @return
 */
function workflowSelectAll(line, column, profileList) {
	workflowChange();
	var reg=new RegExp("[ ]+", "g");
	var profileArray=profileList.split(reg);
	var check=dijit.byId('val_' + line + "_" + column);
	if (check) {
		var newValue=(check.attr("checked"))? 'checked': '';
		for (i=0; i < profileArray.length; i++) {
			var checkBox=dijit.byId('val_' + line + "_" + column + "_" + profileArray[i]);
			if (checkBox) {
				checkBox.attr("checked",newValue);
			}
		}
	} else {
		var newValue=dojo.byId('val_' + line + "_" + column).checked;
		for (i=0; i < profileArray.length; i++) {
			var checkBox=dojo.byId('val_' + line + "_" + column + "_" + profileArray[i]);
			if (checkBox) {
				checkBox.checked=newValue;
			}
		}
	}
}

/**
 * Flag a change on workflow definition
 * @return
 */
function workflowChange() {
	var change=dojo.byId('workflowUpdate');
	change.value=new Date();
	formChanged();
}

/**
 * refresh Projects List on Today screen
 */
function refreshTodayProjectsList() {
	loadContent("../view/today.php?refreshProjects=true", "todayProjectDiv", "todayProjectsForm", false);	
}

function gotoElement(eltClass, eltId) {
  cleanContent("detailDiv");
  formChangeInProgress=false;
  loadContent("objectMain.php?objectClass="+eltClass,"centerDiv", false, false, false, eltId);
}

function runReport() {
	var fileName=dojo.byId('reportFile').value;
	loadContent("../report/"+ fileName , "detailReportDiv", "reportForm", false);	
}