<?php
/** ===========================================================================
 * Copy an object as a new one (of the same class) : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";
set_time_limit(300);

// Get the object from session(last status before change)
if (! array_key_exists('currentObject',$_SESSION)) {
  throwError('currentObject parameter not found in SESSION');
}
$proj=$_SESSION['currentObject'];
if (! is_object($proj)) {
  throwError('last saved object is not a real object');
}
// Get the object class from request

if (! array_key_exists('copyProjectToName',$_REQUEST)) {
  throwError('copyProjectToName parameter not found in REQUEST');
}
$toName=$_REQUEST['copyProjectToName'];
if (! array_key_exists('copyProjectToType',$_REQUEST)) {
  throwError('copyProjectToName parameter not found in REQUEST');
}
$toType=$_REQUEST['copyProjectToType'];

// copy from existing object
$newProj=$proj->copyTo('Project',$toType, $toName, false);
// save the new object to session (modified status)
$result=$newProj->_copyResult;
unset($newProj->_copyResult);
$_SESSION['currentObject']=$newProj;

$nbErrors=0;
// Save Structure
if (stripos($result,'id="lastOperationStatus" value="OK"')>0 and array_key_exists('copyProjectStructure',$_REQUEST)) {
	$milArray=array();
  $milArrayObj=array();
  $actArray=array();
  $actArrayObj=array();
	$crit=array('idProject'=>$proj->id);
	$items=array();
	// Activities to be copied
  $activity=New Activity();
  $activities=$activity->getSqlElementsFromCriteria($crit, false, null, null, true);
  foreach ($activities as $activity) {
    $act=new Activity($activity->id);
    $items['Activity_'.$activity->id]=$act;
  }
  $mile=New Milestone();
  $miles=$mile->getSqlElementsFromCriteria($crit, false, null, null, true);
  foreach ($miles as $mile) {
    $mil=new Milestone($mile->id);
    $items['Milestone_'.$mile->id]=$mil;
  }
  // Sort by wbsSortable
  uasort($items, "customSortByWbsSortable");
  $itemArrayObj=array();
  $itemArray=array();
  foreach ($items as $id=>$item) {
  	$new=$item->copy();
  	$itemArrayObj[get_class($new) . '_' . $new->id]=$new;
    $itemArray[$id]=get_class($new) . '_' . $new->id;
  }
  foreach ($itemArrayObj as $new) {
		$new->idProject=$newProj->id;
		if ($new->idActivity) {
		 if (array_key_exists('Activity_' . $new->idActivity,$itemArray)) {
		 	$split=explode('_',$itemArray['Activity_' . $new->idActivity]);
		 	$new->idActivity=$split[1];
		 }
		}
		$pe=get_class($new).'PlanningElement';
		$new->$pe->wbs=null;
		$tmpRes=$new->save();
		if (! stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
			errorLog($tmpRes);
			$nbErrors++;
		} 
	}
  // Copy dependencies
  $critWhere="";
  foreach ($itemArray as $id=>$new) {
  	$split=explode('_',$id);
  	$critWhere.=($critWhere)?', ':'';
  	$critWhere.="('" . $split[0] . "','" . $split[1] . "')";
  }
  if ($critWhere) {
    $clauseWhere="(predecessorRefType,predecessorRefId) in (" . $critWhere . ")"
         . " or (successorRefType,successorRefId) in (" . $critWhere . ")";
  } else {
  	$clauseWhere=" 1=0 ";
  }
  $dep=New dependency();
  $deps=$dep->getSqlElementsFromCriteria(null, false, $clauseWhere);
  foreach ($deps as $dep) {
  	if (array_key_exists($dep->predecessorRefType . "_" . $dep->predecessorRefId, $itemArray) ) {
  		$split=explode('_',$itemArray[$dep->predecessorRefType . "_" . $dep->predecessorRefId]);
  		$dep->predecessorRefType=$split[0];
  		$dep->predecessorRefId=$split[1];
      $crit=array('refType'=>$split[0], 'refId'=>$split[1]);
      $pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
      $dep->predecessorId=$pe->id;
  	}
    if (array_key_exists($dep->successorRefType . "_" . $dep->successorRefId, $itemArray) ) {
      $split=explode('_',$itemArray[$dep->successorRefType . "_" . $dep->successorRefId]);
      $dep->successorRefType=$split[0];
      $dep->successorRefId=$split[1];
      $crit=array('refType'=>$split[0], 'refId'=>$split[1]);
      $pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
      $dep->successorId=$pe->id;
    }
  	$dep->id=null;
    $tmpRes=$dep->save();
    if (! stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
      errorLog($tmpRes);
      $nbErrors++;
    } 
  }
	$_SESSION['currentObject']=new Project($newProj->id);
}

if ($nbErrors>0) {
  $result.= '<br/><span class="messageWARNING" >' 
         . i18n('errorMessage',array(i18n('copyProjectStructure'),' x ' . $nbErrors))
         . '<br/>' . i18n('contactAdministrator')
         . '</span>';
  $result=str_replace('id="lastOperationStatus" value="OK"','id="lastOperationStatus" value="ERROR"',$result);
}

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}

function customSortByWbsSortable($a,$b) {
	$pe=get_class($a).'PlanningElement';
	$wbsA=$a->$pe->wbsSortable;
	$pe=get_class($b).'PlanningElement';
  $wbsB=$b->$pe->wbsSortable;
  return ($wbsA > $wbsB)?1:-1;
}
?>