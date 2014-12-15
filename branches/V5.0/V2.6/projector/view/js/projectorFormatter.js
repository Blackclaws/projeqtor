// ============================================================================
// All specific ProjectOr functions and variables
// This file is included in the main.php page, to be reachable in every context
// ============================================================================

//=============================================================================
//= global formating functions)
//=============================================================================

/**
 * Format a JS date as YYYY-MM-DD 
 * @param value the value 
 * @return the formatted value 
 */
function formatDate(date) {
	if (! date) {
      return '';
	}
	var month=date.getMonth()+1;
	var year=date.getFullYear();
	var day=date.getDate();
	month=(month<10)?"0"+month:month;
	day=(day<10)?"0"+day:day;
	return year + "-" + month + "-" + day;
}
function getDate(dateString) {
	if (dateString.length!=10) return null;
	return new Date(dateString.substring(0,4), parseInt(dateString.substring(5,7),10)-1, dateString.substring(8));
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
 * Format value to present a color
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

/** ============================================================================
 * Format value to present a name in a colored field
 * @param value the value of the boolean (true or false)
 * @return the formatted value as an image (html code)
 */
function colorNameFormatter(value) {
  if (value) {
  	var tab=value.split("#split#");
  	if (tab.length>1) {
  		if (tab.length==2) { // just found : val #split# color
  			var val=tab[0];
  			var color=tab[1];
  			var order='';
  		} else if (tab.length==3) { // val #split# color #split# order
	  			var val=tab[1];
	  			var color=tab[2];
	  			var order=tab[0];
  		} else { // should not be found
  	  	return value;
  	  }
  		var foreColor='#000000';
  		if (color.length==7) {
  		  var red=color.substr(1,2);
  		  var green=color.substr(3,2);
  		  var blue=color.substr(5,2);
  		  var light=(0.3)*parseInt(red,16)+(0.6)*parseInt(green,16)+(0.1)*parseInt(blue,16);
  		  if (light<128) { foreColor='#FFFFFF'; }
  		}
  	  return '<span style="display:none;">' + order + '</span><table width="100%"><tr><td style="background-color: ' + color + '; color:' +foreColor + ';width: 100%;">' + val + '</td></tr></table>'; 
  	} else {
  		return value;
  	}
  } else { 
  	return ''; 
  }
}

/** ============================================================================
 * Format boolean to present a color
 * @param value the value of the boolean (true or false)
 * @return the formatted value as an image (html code)
 */
function translateFormatter(value, prefix) {
  if (value) { 
  	return i18n(value); 
  } else { 
  	return ''; 
  }
}

/** ============================================================================
 * Format percent value
 * @param value the value of the boolean (true or false)
 * @return the formatted value as an image (html code)
 */
function percentFormatter(value) {
  if (value) { 
   return parseInt(value,10) + ' %';
  } else { 
  	return ''; 
  }
}

/** ============================================================================
 * Format numeric value (removes leading zeros)
 * @param value the value 
 * @return the formatted value 
 */
function numericFormatter(value) {
  //result=dojo.number.format(value);
  var result = value.replace(/^0+/g,'');
  //result = value.replace(/^0+/g,'');
  return result;
}

/** ============================================================================
 * Format date value (depends on locale)
 * @param value the value 
 * @return the formatted value 
 */
function dateFormatter(value) {
  if (value.length==10) {
  	vDate=dojo.date.locale.parse(value, {selector: "date", datePattern: "yyyy-MM-dd"});
    return dojo.date.locale.format(vDate, {formatLength: "short", fullYear: true, selector: "date"});
  } else {
  	return value;
  }
}

/** ============================================================================
 * Format date & time value (depends on locale)
 * @param value the value 
 * @return the formatted value 
 */
function dateTimeFormatter(value) {
  if (value.length==19) {
  	vDate=dojo.date.locale.parse(value, {datePattern: "yyyy-MM-dd", timePattern: "HH:mm:ss"});
    return dojo.date.locale.format(vDate, {formatLength: "short", fullYear: true});
  } else {
  	return value;
  }
}

function sortableFormatter(value) {
	var tab=value.split('.');
	var result='';
	for (i=0; i<tab.length; i++) {
		result+=(result!="")?".":"";
		result+=tab[i].replace(/^0+/,"");
	}
  return result; 
}