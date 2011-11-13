<?php
/** ===========================================================================
 * Copy an object as a new one (of the same class) : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

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

// Save Structure

if (stripos($result,'id="lastOperationStatus" value="OK"')>0 and array_key_exists('copyProjectStructure',$_REQUEST)) {
	$milArray=array();
  $milArrayObj=array();
  $actArray=array();
  $actArrayObj=array();
	$crit=array('idProject'=>$proj->id);
	// Copy activities
  $activity=New Activity();
  $activities=$activity->getSqlElementsFromCriteria($crit, false, null, null, true);
  foreach ($activities as $activity) {
debugLog($activity->id);
    $new=$activity->copyTo('Activity',$activity->idActivityType, $activity->name, false);
debugLog($new->_copyResult);   
    $actArrayObj[$new->id]=$new;
    $actArray[$activity->id]=$new->id;
  }
	foreach ($actArrayObj as $new) {
		$new->idProject=$newProj->id;
		if ($new->idActivity) {
		 if (array_key_exists($new->idActivity,$actArray)) {
		 	$new->idActivity=$actArray[$new->idActivity];
		 }
		}
		$new->save();
	}
  // Copy milestones
	$mile=New Milestone();
	$miles=$mile->getSqlElementsFromCriteria($crit, false, null, null, true);
	foreach ($miles as $mile) {
		$new=$mile->copyTo('Milestone',$mile->idMilestoneType, $mile->name, false);
    $milArrayObj[$new->id]=$new;
    $milArray[$mile->id]=$new->id;
	}
  foreach ($milArrayObj as $new) {
    $new->idProject=$newProj->id;
    if ($new->idActivity) {
     if (array_key_exists($new->idActivity,$actArray)) {
      $new->idActivity=$actArray[$new->idActivity];
     }
    }
    $new->save();
  }	
	$_SESSION['currentObject']=new Project($newProj->id);
}

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>