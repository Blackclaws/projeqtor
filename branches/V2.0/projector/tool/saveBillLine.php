<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";

// Get the line info
if (! array_key_exists('billLineRefType',$_REQUEST)) {
  throwError('billLineRefType parameter not found in REQUEST');
}
$refType=$_REQUEST['billLineRefType'];

if (! array_key_exists('billLineRefId',$_REQUEST)) {
  throwError('billLineRefId parameter not found in REQUEST');
}
$refId=$_REQUEST['billLineRefId'];

if (! array_key_exists('billLineLine',$_REQUEST)) {
	throwError('billLineLine parameter not found in REQUEST');
}
$Line=$_REQUEST['billLineLine'];

$quantity=null;
if (array_key_exists('billLineQuantity',$_REQUEST)) {
  $quantity=$_REQUEST['billLineQuantity'];
}

$description=null;
if (array_key_exists('billLineDescription',$_REQUEST)) {
  $description=$_REQUEST['billLineDescription'];
}

$reference=null;
if (array_key_exists('billLineReference',$_REQUEST)) {
  $reference=$_REQUEST['billLineReference'];
}

$price=null;
if (array_key_exists('billLinePrice',$_REQUEST)) {
  $price=$_REQUEST['billLinePrice'];
}

$sum=null;
if ($price!=null && $quantity!=null) {
	$sum=$price * $quantity; 
}

$lineId=null;
if (array_key_exists('billLineId',$_REQUEST)) {
  $lineId=$_REQUEST['billLineId'];
}
$lineId=trim($lineId);
if ($lineId=='') {
  $lineId=null;
} 

if( $lineId!=null)
{
	$line = new BillLine($lineId);
	$idTerm = $line->idTerm;
}
else $idTerm=null;

if (array_key_exists('billLineIdTerm',$_REQUEST)) {
  $idTerm=$_REQUEST['billLineIdTerm'];
}

//if($description!='') $idTerm=null;

if (!is_numeric($idTerm) || is_numeric($billLineId)) {
	$line=new BillLine($lineId);

	$line->description=$description;
	$line->line=$Line;
	$line->price=$price;
	$line->quantity=$quantity;
	$line->reference=$reference;
	$line->sum=$sum;
	$line->refId=$refId;
	$line->refType=$refType;
	$result=$line->save();
} else {
	$terms = new Term($idTerm);
	$idTerm=$terms->id;
	$sum=null;	
	$quantity=1;
	$reference=$terms->name;
	$terms->isBilled = 1;
	$terms->save();
	
	//$line = new BillLine($lineId);
	//$line->line=$Line;
	//$line->refId=$refId;
	//$line->refType=$refType;
	//$line->idTerm=$idTerm;
	//$line->price=null;
	//$line->quantity=null;
	//$line->sum=null;
	//if ($description!='') $line->description=$description;
	//else $line->description = "Echeance du ".$terms->date;
	//if ($reference!='') $line->reference=$reference;
	//else $line->reference = "";
	
	//$result = $line->save();
	
	if ($terms->amount!=null) {
		$price=$terms->amount;
		$sum=$terms->amount;
		$line = new BillLine();
		$line->line=$Line;
		$line->refId=$refId;
		$line->refType=$refType;
		$line->idTerm=$idTerm;
		$line->price=$price;
		$line->quantity=1;
		$line->sum=$sum;
		$line->description = "Montant fixe";		
		$line->reference = $terms->name;
		$line->startDate = $terms->date;
		$result = $line->save();
	}
	else {
				
		$dep = new Dependency();
		$crit = array("successorRefType"=>"Term","successorRefId"=>$idTerm);
	    $depList = $dep->getSqlElementsFromCriteria($crit,false);
		$list = array();
	    $i = 0;
	    
	    foreach ($depList as $dep)
	    {
	    	if ($dep->predecessorRefType == "Activity")
	    	{
	    		if (!in_array($dep->predecessorRefId, $list))
	    		{
	    			$list[$i]=$dep->predecessorRefId;
	    			$i++;
	    		}
	    	}
	    	elseif ($dep->predecessorRefType == "Project")
	    	{
	    		$act = new Activity();
	    		$crit = array("idProject"=>$dep->predecessorRefId);
	    		$actList = $act->getSqlElementsFromCriteria($crit,false);
	    		foreach ($actList as $act)
	    		{
		    		if (!in_array($act->id, $list))
		    		{
		    			$list[$i]=$act->id;
		    			$i++;
		    		}
	    		}
	    	}
	    }
	    
	    if (count($list)==0) $list[0]=0;
	    
	    $in = "( ";
	    
	    for ($i=0;$i<count($list);$i++)
	    {
	    	if ($i!=0) $in .=", ";
	    	$in .= $list[$i];
	    }
	    $in .=")";

	    $elt = new PlanningElement();
	    $crit = "refType = 'Activity' and refId in ".$in;
	    $crit .= " and isBilled = 0";
	    $eltList = $elt->getSqlElementsFromCriteria(null,false,$crit);
		$number = 0;
		foreach ($eltList as $elt)
		{
			$sum = 0;
			$price = 0;
			$elt->isBilled = $idTerm;
			$elt->save();
			if ($elt->validatedWork != null)
    		{
    			$act = new Activity($elt->refId);
    			$actPrice = new ActivityPrice();
    			$crit = array("idActivityType"=>$act->idActivityType,"idProject"=>$act->idProject);
    			$priceList = $actPrice->getSqlElementsFromCriteria($crit);
    			if (count($priceList)!=0)
    			{
    				$price += $priceList[0]->priceCost * $elt->validatedWork;
    				$sum = $price;
    			}
    		}
    		else if ($elt->assignedWork != null)
    		{
    			$act = new Activity($elt->refId);
    			$actPrice = new ActivityPrice();
    			$crit = array("idActivityType"=>$act->idActivityType);
    			$priceList = $actPrice->getSqlElementsFromCriteria($crit);
    			
    			if (count($priceList)!=0)
    			{
    				$price += $priceList[0]->priceCost * $elt->assignedWork;
    				$sum = $price;
    			}
    		}
    		
    		$line = new BillLine();
    		$line->line=$Line + $number;
			$line->refId=$refId;
			$line->refType=$refType;
			$line->idTerm=$idTerm;
			$line->price=$price;
			$line->quantity=1;
			$line->sum=$sum;
			$line->idActivity=$act->id;
			
			$prj = new Project($act->idProject);
			
			$line->description = 'Projet '.$prj->name;
			$line->reference = $act->name;
			$result = $line->save();
			$number++;
		}  
	}
}


// get the modifications (from request)



// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>