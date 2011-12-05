<?php 
/** ============================================================================
 * creation of the description of the content for a bill.
 */ 
class Bill extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idBillType;
  public $name;
  public $date;
  public $idProject;
  public $idClient;
  public $idRecipient;
  public $idStatus;
  public $idle;
  public $billId;
  public $_col_2_2_regie;
  public $startDate;
  public $endDate;
  public $idResource;
  public $_Line=array();
  public $_Note=array();


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="name" width="10%" >${name}</th>
    <th field="date" formatter="dateFormatter" width="5%" >${date}</th>
    <th field="startDate" formatter="dateFormatter" width="5%" >${startDate}</th>
    <th field="endDate" formatter="dateFormatter" width="5%" >${endDate}</th>
    <th field="nameProject" width="15" >${idProject}</th>
    <th field="nameClient" width="20%" >${idClient}</th>
    <th field="nameRecipient" width="15%" >${idRecipient}</th>
    <th field="billId" width="10%" ># ${billId}</th>
    <th field="idle" formatter="booleanFormatter" width="5%" >${idle}</th>
    ';
  

  private static $_fieldsAttributes=array('name'=>'required',
  										'idStatus'=>'required',
                                        'idBillType'=>'required',
  										'billId'=>'readonly',
  										'idPrec'=>'required');  
  
  private static $_colCaptionTransposition = array();
  
  private static $_databaseColumnName = array();
    
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }


// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
  
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }

  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  

/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    
    if(new DateTime($this->startDate) <= new DateTime($this->endDate))
    {
    	$result='OK';
    }
    else $result='dateError';
    
    if ($this->id)
    {
    	$bill = new Bill($this->id);
    	if ($this->idStatus != 1 && $this->idStatus != 5 && ($bill->idStatus == 1 || $bill->idStatus == 5) && $this->date == null)
    	{
    		$result = "Date requise";
    	}
    }
    
    if ($this->idStatus != 1 && $this->idStatus != 5)
    {    	
    	if(!$this->id)
    	{
    		$result = "Facture vide";
    	}
    	else 
    	{   	
    		$line = new Line();
    		$crit = array("refId"=>$this->id);
    		$lineList = $line->getSqlElementsFromCriteria($crit,false);
    		if (count($lineList)==0)
    		{
    			$result="Facture Vide";
    		}
    	}
    }
    
    return $result;
  }
  

  /** =========================================================================
   * Overrides SqlElement::deleteControl() function to add specific treatments
   * @see persistence/SqlElement#deleteControl()
   * @return the return message of persistence/SqlElement#deleteControl() method
   */  
  
  public function deleteControl()
  {
  	$result = "OK";
  	if ($this->idStatus != 1 && $this->idStatus != 5)
  	{
  		$result = "Facture traite : suppression interdite.";
  	}
  	
  	$line = new Line();
  	$crit = array("refType"=>"bill","refId"=>$this->id);
  	$lineList = $line->getSqlElementsFromCriteria($crit,false);
  	
  	if (count($lineList)!= 0)
  	{
  		$result = "Suppression interdite : Facture non vide";
  	}
  	
  	return $result;
  }
  
  
  /** =========================================================================
   * Overrides SqlElement::delete() function to add specific treatments
   * @see persistence/SqlElement#delete()
   * @return the return message of persistence/SqlElement#delete() method
   */  
  
  public function delete()
  {
  	if (($result = parent::delete()) == "OK")
  	{
	  	if ($this->startDate!=null && $this->endDate!=null && $this->idProject!=null)
		{
			$crit = "idProject=".$this->idProject;
			
			$crit.=" and ";
			$crit.="workDate>=\"".$this->startDate."\"";
			$crit.=" and ";
			$crit.="workDate<=\"".$this->endDate."\"";
			$crit.=" and isBilled = ".$this->id;
			
			if ($this->idResource!=null)
			{
				$crit.=" and idResource = ".$this->idResource;
			}
		
			$work = new Work();
			$workList = $work->getSqlElementsFromCriteria(null,false,$crit);
			
			foreach ($workList as $work)
			{
				$work->isBilled = 0;
				$work->save();
			}	
		}
  	}
	
	return $result;
  }
    

  /** =========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */  

	public function save() {
		
		$bill = new Bill($this->id);
		global $paramDbPrefix;
		if($bill->startDate!=$this->startDate || $bill->endDate!=$this->endDate)
		{
			$line = new Line();
			$crit = array("startDate"=>$bill->startDate,"endDate"=>$bill->endDate);
			$lineList = $line->getSqlElementsFromCriteria($crit, false);
			foreach ($lineList as $line)
			{
				$line->delete();
			}
		}
	
		if ((($bill->date != $this->date) 
		|| ($bill->endDate != $this->endDate)
		|| ($bill->startDate != $this->startDate)
		|| ($bill->name != $this->name)
		|| (trim($bill->idBillType) != trim($this->idBillType))
		|| (trim($bill->idClient) != trim($this->idClient))
		|| (trim($bill->idProject) != trim($this->idProject))
		|| (trim($bill->idRecipient) != trim($this->idRecipient))
		|| (trim($bill->idResource) != trim($this->idResource )))
		&& ($bill->idStatus != 1 && $bill->idStatus != 5 && $this->id))
		{
		  $result='<b>' . i18n('messageInvalidControls') . '</b><br/>' . "Facture Verrouillee";
	      $result .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
	      $result .= '<input type="hidden" id="lastOperation" value="control" />';
	      $result .= '<input type="hidden" id="lastOperationStatus" value="INVALID" />';
		}
		else 
		{
			if ($this->idStatus!=1 && $this->idStatus != 5 && $this->billId == null)
			{
				global $defaultBillCode;
				$bill = new Bill();
				$crit = "idStatus != 1 AND idStatus != 5";
				$billList = $bill->getSqlElementsFromCriteria(null,false,$crit);
				$this->billId = count($billList)+ $defaultBillCode;
			}
			
			if(is_numeric($this->idClient) && is_numeric($this->idProject)!=1)
			{
				$query = "SELECT DISTINCT * FROM `".$paramDbPrefix."project` WHERE idClient=".$this->idClient;
				$temp = Sql::query($query);
				
				$tab = "( ";
				$i=0;
				while ($sortie = Sql::fetchLine($temp))
				{
					if ($i!=0) $tab .= ", ";
					$tab .= $sortie["id"];
					$i++;
				}
				$tab .= ")";
				 
			} elseif (is_numeric($this->idProject))
			{
				$tab = "( ".$this->idProject." )";
			}
			
			if (is_numeric($this->idClient)!=1 && is_numeric($this->idProject)==1)
			{
				$prj = new Project($this->idProject);
				$this->idClient = $prj->idClient;
			}

			$result= parent::save();
			
			if ($this->startDate!=$bill->startDate || $this->endDate!=$bill->endDate && $tab!=null)// && $lock==0)
			{			
				$crit1 = "idProject in ".$tab;
				if($this->idResource!=' ')
				{
					$crit1.=" and ";
					$crit1.= "idResource=".$this->idResource;
				}
				
				$crit1.=" and ";
				$crit1.="workDate>=\"".$this->startDate."\"";
				$crit1.=" and ";
				$crit1.="workDate<=\"".$this->endDate."\"";
				$crit1.=" and isBilled = 0";
			
				$work = new Work();
				$workList = $work->getSqlElementsFromCriteria(null,false,$crit1);
				
				foreach ($workList as $work)
				{
					$query = "SELECT COUNT(line) AS compteur1 FROM `".$paramDbPrefix."line` WHERE 
					refType=\"Bill\"
					AND refId=".$this->id." 
					AND idResource=".$work->idResource." 
					AND idActivity=".$work->refId;
					$sortie = Sql::query($query);
					$sortie = Sql::fetchLine($sortie);
					
					$line = new Line();
					$crit=array("refId"=>$this->id,"idResource"=>$work->idResource,"idActivity"=>$work->refId);
					$lineList=$line->getSqlElementsFromCriteria($crit,false);
					
					if ($sortie["compteur1"]==0)
					{
						$query = "SELECT COUNT(line) AS compteur FROM `".$paramDbPrefix."line` WHERE refId=".$this->id;
						$sortie = Sql::query($query);
						$sortie = Sql::fetchLine($sortie);
						$number=$sortie["compteur"]+1;
						
						if(count($lineList)!=0)	$line = new Line($lineList[0]->id);
						else $line = new Line();
						
						$prj = new Project($work->idProject); 
						$type = new Type($prj->idProjectType);
						$act = new Activity($work->refId);
						$actPrice = new ActivityPrice();
						$crit = array("idActivityType"=>$act->idActivityType,"idProject"=>$work->idProject);
						$actPriceList = $actPrice->getSqlElementsFromCriteria($crit,false);
						if (count($actPriceList)==0) $temp = 0.0;
						else $temp = $actPriceList[0]->priceCost;
												
						
						if ($type->internalData == "P")
						{
							$ass = new Assignment($work->idAssignment);
							if (($ass->billedWork + $work->work) < $ass->assignedWork)
							{
								$line->quantity =$work->work;
								$line->sum =$temp * $work->work;
							}
							else 
							{
								$diff = $ass->assignedWork - $ass->billedWork;
								if ($diff<0) $diff=$ass->assignedWork;
								$line->quantity =$diff;
								$line->sum = $temp*$diff;//($temp*$diff)/$work->work;
							}
						}
						else 
						{						
							$line->quantity=$work->work;
							$line->sum=$temp*$work->work;
							$ass = new Assignment($work->idAssignment);
						}
						
						$line->line=$number;
						$line->idResource=$work->idResource;	
						$line->refId=$this->id;
						$line->startDate = $this->startDate;
						$line->endDate = $this->endDate;
						$line->refType="Bill";
						$line->description="Ressource ".SqlList::getNameFromId("Resource",$work->idResource);
						$line->idResource = $work->idResource;
						$line->idActivity = $work->refId;
						$line->reference="Activite ".SqlList::getNameFromId("Activity",$work->refId);					
					}
					else 
					{
						$line = new Line($lineList[0]->id);
						
						$prj = new Project($work->idProject); 
						$type = new Type($prj->idProjectType);
						$act = new Activity($work->refId);
						$actPrice = new ActivityPrice();
						$crit = array("idActivityType"=>$act->idActivityType,"idProject"=>$work->idProject);
						$actPriceList = $actPrice->getSqlElementsFromCriteria($crit,false);
						if (count($actPriceList)==0) $temp = 0.0;
						else $temp = $actPriceList[0]->priceCost;
						
						if ($type->internalData == "P")
						{
							$ass = new Assignment($work->idAssignment);
							if (($ass->billedWork + $work->work) < $ass->assignedWork)
							{
								$line->quantity+=$work->work;
								$line->sum+=$temp*$work->work;
							}
							else 
							{
								$diff = $ass->assignedWork - $ass->billedWork;
								if ($diff<0) $diff=0.0;
								$line->quantity+=$diff;
								$line->sum+= $temp * $diff;
								$line->save();
							}							
						}
						else 
						{
							$line->quantity+=$work->work;
							$line->sum+= $temp*$work->work;
						}
					}
					if ($line->quantity!= 0) $line->price = $line->sum / $line->quantity;
					else $line->price = 0;
					$line->save();
					$query = "UPDATE `".$paramDbPrefix."assignment` SET billedWork = billedWork + ".$work->work." WHERE id =".$work->idAssignment;
					Sql::query($query);					
				}
				$query = "UPDATE `".$paramDbPrefix."work` SET isBilled=".$this->id." WHERE ".$crit1;
				Sql::query($query);
			}			
		}

		return $result;
	}  

}
?>