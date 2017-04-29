<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Organization is a structure that provides consolidation over new axis.
 */ 
require_once('_securityCheck.php');
class OrganizationMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place
  public $name;
  public $idOrganizationType;
  public $idResource;
// ADD BY Marc TABARY - 2017-02-28 - DATA CONSTRUCTED BY FUNCTION  
  public $_byMet_hierarchicName;
// ADD BY Marc TABARY - 2017-02-28 - DATA CONSTRUCTED BY FUNCTION  
  public $idOrganization;
  public $idUser;
  public $creationDate;
  public $lastUpdateDateTime;
  
// ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT  
  public $_tab_2_1 = array('idle','idleDate',
                           'idStatus');
  public $idle;
  public $idleDateTime;
// END ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT
  public $description;

// ADD BY Marc TABARY - 2017-03-03 - SET VALUE OF XXX, YYY, ZZZ IN 'alertOverXXXwarningOverYYYokUnderYYY'
  public $_sec_ValueAlertOverWarningOverOkUnder;
  public $_tab_3_1_smallLabel = array('alertOver', 'warningOver', 'okUnder',
                                      'thresholds');
  public $alertOverPct;
  public $warningOverPct;
  public $okUnderPct;
// END ADD BY Marc TABARY - 2017-03-03 - SET VALUE OF XXX, YYY, ZZZ IN 'alertOverXXXwarningOverYYYokUnderYYY'
  
// ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
  public $sortOrder;
// END ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
  public $OrganizationBudgetElementCurrent; // is an object because first Letter is Upper

// ADD BY Marc TABARY - 2017-03-16 - LIST OF PROJECTS LINKED BY HIERARCHY TO ORGANIZATION
  // Section that presents the projects that are linked to this organization and its sub-organizations
  // Want a item's count on section header => ='itemsCount=method to call to get objects to count'
  public $_sec_HierarchicOrganizationProjects='itemsCount=getProjectsOfOrganizationAndSubOrganizations';
  public $_spe_Project=array();
// END ADD BY Marc TABARY - 2017-03-16 - LIST OF PROJECTS LINKED BY HIERARCHY TO ORGANIZATION
  
  
// ADD BY Marc TABARY - 2017-02-24 - OBJECTS LINKED BY ID TO MAIN OBJECT

// ADD BY Marc TABARY - 2017-02-22 - ORGANIZATION'S PROJECTS
  // naming rule to draw list of objects linked by id ('foreign key') to the object
  // _sec_    : For section (it's generic to the FrameWork)
  // _xxxs    : xxx the object linked by id - Don't forget the 's' at the end
  // OfObject : indicate, it's a section for linked by id object
//  public $_sec_ProjectsOfObject;
//  public $_Project=array();
// ADD BY Marc TABARY - 2017-02-22 - ORGANIZATIONS PROJECTS
  
// ADD BY Marc TABARY - 2017-02-21 - ORGANIZATION'S RESOURCES  
  public $_sec_ResourcesOfObject;
  public $_Resource=array();
// ADD BY Marc TABARY - 2017-02-21 - ORGANIZATION'S RESOURCES

// ADD BY Marc TABARY - 2017-02-24 - OBJECTS LINKED BY ID TO MAIN OBJECT
  
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  // hidden
  public $_nbColMax=3;
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameOrganizationType" width="15%" >${type}</th>
    <th field="name" width="30%" >${organizationName}</th>
    <th field="nameResource" width="10%" >${responsible}</th>
    <th field="idle" formatter="booleanFormatter" width="5%" >${idle}</th>  
    ';
  
  private static $_fieldsAttributes=array(
      "name"=>"required",                                   
      "idOrganizationType"=>"required",
// ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
      "sortOrder"=>"hidden,noImport",
      "_byMet_hierarchicName"=>"readonly,noImport",
// END ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
// ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT
      "idleDateTime"=>"readonly,noImport",
// END ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT      
// ADD BY Marc TABARY - 2017-03-18 - FIELD NOT IN LIST
// ADD BY Marc TABARY - 2017-03-20 - FIELD NOT PRESENT FOR FILTER  
      // New value of attribute : noInFilter
      // If set, this attribute will not present in the list of attributes for the filters
      "alertOverPct"=>"noList,notInFilter",
      "warningOverPct"=>"noList,notInFilter",
      "okUnderPct"=>"noList,notInFilter",
// END ADD BY Marc TABARY - 2017-03-18 - FIELD NOT IN LIST
// END ADD BY Marc TABARY - 2017-03-20 - FIELD NOT PRESENT FOR FILTER
// ADD BY Marc TABARY - 2017-03-20 - EXPORT FIELD      
      "_spe_Project"=>"noExport"
// END ADD BY Marc TABARY - 2017-03-20 - EXPORT FIELD      
  );   
 
  private static $_colCaptionTransposition = array(
      'idResource'=>'manager',
      'idUser'=>'issuer',
// ADD BY Marc TABARY - 2017-02-08 - PARENT ORGANIZATION
      'idOrganization'=>'parentOrganization',
      '_byMet_hierarchicName'=>'hierarchicString',      
// END ADD BY Marc TABARY - 2017-02-08 - PARENT ORGANIZATION
// CHANGE BY Marc TABARY - 2017-03-20 - EXPORT FIELD
    'idleDateTime'=>'idleDate',
// END CHANGE BY Marc TABARY - 2017-03-20 - EXPORT FIELD      
  
  );

  // ADD BY Marc TABARY - 2017-03-03 - DRAW SPINNER
  // Spinner for drawing et inputing the alertOverPct, warningOverPct, okUnderPct
  private static $_spinnersAttributes = array(
      'alertOverPct'=>'min:0,max:100,step:5,bkColor:#FFAAAA !important',
      'warningOverPct'=>'min:0,max:100,step:5,bkColor:#FFBE00 !important;',
      'okUnderPct'=>'min:0,max:100,step:5,bkColor:#B5DE8E !important;',      
  );  
// END ADD BY Marc TABARY - 2017-03-03 - DRAW SPINNER
  
// ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION
  private static $_subOrganizationList=array();
  private static $_subOrganizationFlatList=array();
// END ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION

   /** ==========================================================================
   * Constructor
   * @param int             $id the id of the object in the database (null if not stored yet)
   * @param boolean         $withoutDependentObjects
   * @param budgetElement   $budgetElement : the budgetElement for which update synthesis
    *                                         - not null = Do nothing else
    *                                         - null = Normal construct 
   * @return void
   */ 
// CHANGE BY Marc TABARY - 2017-03-13 - PERIODIC YEAR BUDGET ELEMENT - Add BudgetElement
  function __construct($id = NULL, $withoutDependentObjects=false, $budgetElement=null) {
  // Old    
//  function __construct($id = NULL, $withoutDependentObjects=false) {  
// END CHANGE BY Marc TABARY - 2017-03-13 - PERIODIC YEAR BUDGET ELEMENT - Add BudgetElement
      
  	parent::__construct($id,$withoutDependentObjects);

// ADD BY Marc TABARY - 2017-03-13 - PERIODIC YEAR BUDGET ELEMENT - Add BudgetElement
        if($budgetElement!=null and $id!=null and trim($id)!='') {
            $this->updateBudgetElementSynthesis($budgetElement);
            return;
  }
// END ADD BY Marc TABARY - 2017-03-13 - PERIODIC YEAR BUDGET ELEMENT - Add BudgetElement

// ADD BY Marc TABARY - 2017-02-28 - ORGANIZATION BUDGET
        if ($id != NULL and trim($id)!='') {
            if (is_object($this->OrganizationBudgetElementCurrent)) {
                $this->setHierarchicString();
                if ($this->OrganizationBudgetElementCurrent->id) {
                        $this->OrganizationBudgetElementCurrent->setDaughtersBudgetElementAndPlanningElement();
// ADD BY Marc TABARY - 2017-03-03 - SET VALUE OF XXX, YYY, ZZZ IN 'alertOverXXXwarningOverYYYokUnderYYY'
                        $this->OrganizationBudgetElementCurrent->setValueOfAlertOverWarningOverOkUnder(
                                                                 $this->alertOverPct,
                                                                 $this->warningOverPct,
                                                                 $this->okUnderPct);
// END ADD BY Marc TABARY - 2017-03-03 - SET VALUE OF XXX, YYY, ZZZ IN 'alertOverXXXwarningOverYYYokUnderYYY'
// ADD BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
                        $this->OrganizationBudgetElementCurrent->hideOrganizationBudgetElementMsg(true);
                        $this->OrganizationBudgetElementCurrent->setWorkCostExpenseTotalCostBudgetElement();
                        $this->OrganizationBudgetElementCurrent->hideSynthesisBudgetAndProjectElement(false);
                } else {
                    $this->OrganizationBudgetElementCurrent->hideSynthesisBudgetAndProjectElement(true);
                }
            }
// END ADD BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
        }
// END ADD BY Marc TABARY - 2017-02-28 - ORGANIZATION BUDGET
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
  
  
// ADD BY Marc TABARY - 2017-03-03 - DRAW SPINNER        
  /** ==========================================================================
   * Return the generic spinnerAttributes
   * @return array[name,value] : the generic $_spinnerAttributes
   */
  protected function getStaticSpinnersAttributes() {
      if(!isset(self::$_spinnersAttributes)) {return array();}
      return self::$_spinnersAttributes;
  }
// END ADD BY Marc TABARY - 2017-03-03 - DRAW SPINNER

  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    if(!isset(self::$_layout)) {return array();}
    return self::$_layout;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    if(!isset(self::$_colCaptionTransposition)) {return array();}
    return self::$_colCaptionTransposition;
  }  

    /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    if(!isset(self::$_fieldsAttributes)) {return array();}
    return self::$_fieldsAttributes;
  }
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

 
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  

// ADD BY Marc TABARY - 2017-03-16 - DRAW LIST OF PROJECTS LINKED TO THE ORGANIZATION AND ITS SUB-ORGANIZATION
/** =====================================================================================
 * Draw section of an object linked by an id with the object to which we draw the detail
 * Sample : drawObjectLinkedByIdToObject($obj, 'Project', true)
 *          Draw a section for projects with idxxxx (where xxxx the name of the $obj's classe)
 * --------------------------------------------------------------------------------------
 * @global type $cr
 * @global type $print
 * @global type $outMode
 * @global type $comboDetail
 * @global type $displayWidth
 * @global type $printWidth
 * @param boolean $refresh
 * @return nothing
   */
function drawProjectsOfOrganizationAndSubOrganizations($item, $refresh=false) {
  global $cr, $print, $outMode, $comboDetail, $displayWidth, $printWidth;

    if ($comboDetail) {
        return;
    }

    $goto='';  
    $obj = $this;
    $objects=array();

    $objLinkedByIdObject = 'Project';

    // Get the visible list of linked Object
    $listVisibleLinkedObj = getUserVisibleObjectsList($objLinkedByIdObject);

    $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj) == "YES";
    if ($canUpdate) {$canUpdate = securityGetAccessRightYesNo('menu' . $objLinkedByIdObject, 'update', $obj) == "YES";}

    if($obj->id!=null and trim($obj->id)!='') {
        if ($obj->idle == 1) {
          $canUpdate=false;
        }
        // Retrieve the projects
        $objects = $obj->getProjectsOfOrganizationAndSubOrganizations();
        
        // Retrieve organization et suborganization in an array ('id'=>array('name','idle')
        $listOrgaAndSubOrga = $obj->getRecursiveSubOrganizationsIdNameIdleList(false,true);
    } // if($obj->id!=null and trim($obj->id)!='')
    
    if (!$refresh and !$print) echo '<tr><td colspan="2">';
    echo '<input type="hidden" id="objectIdle" value="' . htmlEncode($obj->idle) . '" />';

    if (! $print) {
      echo '<table width="99.9%">';
    }  
    echo '<tr>';
    if (!$print) {
      echo '<td class="assignHeader smallButtonsGroup" style="width:5%">';
      if ($obj->id != null and !$print and $canUpdate) {
        // Parameters passed at addLinkObjectToObject
        // 1 - The main object's class name
        // 2 - The id of main object
        // 3 - The linked object's class name
        echo '<a onClick="addLinkObjectToObject(\'' . get_class($obj) . '\',\'' . htmlEncode($obj->id) . '\',\'' . $objLinkedByIdObject .'\');" title="' . i18n('addLinkObject') . '" >'.formatSmallButton('Add').'</a>';

      }
      echo '</td>';
    }
    echo '<td class="assignHeader" style="width:5%">' . i18n('colId') . '</td>';
    echo '<td class="assignHeader" style="width:' . (($print)?'45':'40') . '%">' . i18n('Project') . '</td>';
    echo '<td class="assignHeader" style="width:' . (($print)?'5':'10') . '%">' . i18n('colIdle') . '</td>';
    echo '<td class="assignHeader" style="width:' . (($print)?'45':'40') . '%">' . i18n('Organization') . '</td>';
    echo '</tr>';
    $nbObjects=0;
    foreach ( $objects as $theObj ) {
      $nbObjects++;
      // Name of it organization
      if (array_key_exists($theObj->idOrganization, $listOrgaAndSubOrga)) {
        $orgaNameIdle = $listOrgaAndSubOrga[$theObj->idOrganization];
        $orgaName = $orgaNameIdle['name'];
      } else {
          $orgaName='';
      }
      echo '<tr>';
      if (!$print) {
        echo '<td class="assignData smallButtonsGroup">';
        if (!$print  and 
                $canUpdate 
                and array_key_exists($theObj->id, $listVisibleLinkedObj)
           ) {
           // Implement to following rule :
           // Can't remove link (idOrganization) for suborganizations
           if (get_class($obj)=='Organization' and get_class($theObj)=='Project' and $obj->id != $theObj->idOrganization) {
              echo ' <a title="' . i18n('ownToSubOrganization') . '" >'.formatSmallButton('SubOrganization').'</a>';
           } else {
                  if($theObj->idle==0) {
                      // Parameters passed at removeLinkObjectFromObject
                      // 1 - The main object's class name
                      // 2 - The linked object's class name
                      // 3 - The id of the selected linked object
                      // 4 - The name of the selected linked object  
                      echo ' <a onClick="removeLinkObjectFromObject(\'' . 
                                                                    get_class($obj) . 
                                                                    '\',\'' . $objLinkedByIdObject . 
                                                                    '\',\'' . htmlEncode($theObj->id) . 
                                                                    '\',\'' . htmlEncode(str_replace("'"," ",$theObj->name)) .
                                                                    '\');" title="' . i18n('removeLinkObject') . '" > '.formatSmallButton('Remove').'</a>';
                  }
           }
        }
        echo '</td>';
      }
      if (array_key_exists($theObj->id, $listVisibleLinkedObj)) {
          echo '<td class="assignData" style="width:5%">#' . htmlEncode($theObj->id) . '</td>';
          if (!$print and 
              securityCheckDisplayMenu(null, get_class($theObj)) and 
              securityGetAccessRightYesNo('menu'.get_class($theObj), 'read', '') == "YES")
          {
            $goto=' onClick="gotoElement(\''.get_class($theObj).'\',\'' . htmlEncode($theObj->id) . '\');" style="cursor: pointer;" ';
          }
          echo '<td '. $goto .' class="assignData hyperlink" style="width:' . (($print)?'45':'40') . '%">' . htmlEncode($theObj->name) . '</td>';
      } else {
          echo '<td class="assignData" style="width:5%"></td>';
          echo '<td class="assignData" style="width:' . (($print)?'45':'40') . '%">' . i18n('isNotVisible') . '</td>';        
      }
          echo '<td class="assignData dijitButtonText" style="width:' . (($print)?'5':'10') . '%">' . htmlDisplayCheckbox($theObj->idle) . '</td>';                
          echo '<td class="assignData" style="width:' . (($print)?'45':'40') . '%">' . htmlEncode($orgaName) . '</td>';

      echo '</tr>';
    }
    if (!$print) {
      echo '</table>';
    }
    if (!$refresh and !$print) echo '</td></tr>';
}

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item,$readOnly=false,$refresh=false){
    $result="";
        switch($item) {
            // Draw the message that say if BudgetElement exits or not
            case 'Project' :
                $this->drawProjectsOfOrganizationAndSubOrganizations('_spe_'.$item, $refresh);
                break;
        }    
     return $result;
  }
// END ADD BY Marc TABARY - 2017-03-16 - DRAW LIST OF PROJECTS LINKED TO THE ORGANIZATION AND ITS SUB-ORGANIZATION
  
// ADD BY Marc TABARY - 2017-02-21

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawCalculatedItem($item){
    $result="";
     return $result;
  }

  public function simpleSave() {
    return parent::save();
  }
// END ADD BY Marc TABARY - 2017-02-21

// ADD BY Marc TABARY - 2017-02-28 - HIERARCHIC STRING
  public function setHierarchicString() {
    if ($this->id==NULL or trim($this->id)=="") {
          $this->_byMet_hierarchicName = '';
    } else { 
        $orga = $this;
        $hierarchicName="";
        while ($orga->idOrganization and trim($orga->idOrganization)!='') {
            $orga = new Organization($orga->idOrganization);
            $hierarchicName=$orga->name.' - '.$hierarchicName;
        }
        if ($hierarchicName==='') {$this->_byMet_hierarchicName='';} else {$this->_byMet_hierarchicName = substr($hierarchicName, 0, -3);}
    }
  }
// END ADD BY Marc TABARY - 2017-02-28 - HIERARCHIC STRING
              
   /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {	
    $old=$this->getOld();
    
// ADD BY Marc TABARY - 2017-03-08 - PERIODIC YEAR BUDGET ELEMENT
    // The idleDate
    if ($old->idle != $this->idle) {
        $this->idleDateTime = ($this->idle?date('Y-m-d H:i:s'):null);        
    }
// END ADD BY Marc TABARY - 2017-03-08 - PERIODIC YEAR BUDGET ELEMENT
    
    
// MOVE BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION
// ADD BY Marc TABARY - 2017-03-08 - PERIODIC YEAR BUDGET ELEMENT
    if ($this->OrganizationBudgetElementCurrent->id or   # The Budget Element exist for this organization et selected period
        $this->id==null or trim($this->id)==''           # The organization is to create
       ) {
// END ADD BY Marc TABARY - 2017-03-08 - PERIODIC YEAR BUDGET ELEMENT        
        if ($this->name !== $old->name) {$this->OrganizationBudgetElementCurrent->refName=$this->name;}
        // 'unclose' organization ==> BudgetElement is 'unclose' to.
        if ($this->idle !== $old->idle and $this->idle) {
            $this->OrganizationBudgetElementCurrent->idle=$this->idle;            
            $this->OrganizationBudgetElementCurrent->idleDateTime=$this->idleDateTime;            
// ADD BY Marc TABARY - 2017-03-08 - PERIODIC YEAR BUDGET ELEMENT
        }
    }

    $result = parent::save();
    $lastStatus = getLastOperationStatus($result);
    if ($lastStatus!='OK') {
    return $result; 
    }
// END MOVE BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION

    
// ADD BY Marc TABARY - 2017-03-14 - BUG CORRECTION - Store sortOrder if new organization
// Init sortOrder if new organization
if($old->id==null or trim($old->id)=='') {
    $this->sortOrder = sprintf("%04d", $this->id);    
    $this->simpleSave();
  }
// END ADD BY Marc TABARY - 2017-03-14 - BUG CORRECTION - Store sortOrder if new organization
        
// ADD BY Marc TABARY - 2017-03-03 - ORGANIZATION'S MANAGER
   // If manager change and new manager is'nt empty
   if ($old->idResource !=$this->idResource and $this->idResource!=null) {
       // Check if the manager has an organization.
       $resOrgaList = $this->getResourcesOfOrganizationsListAsArray();
       if (!array_key_exists($this->idResource,$resOrgaList)) {
           $manager = new Resource($this->idResource);
           $manager->idOrganization = $this->id;
           $manager->save();
       }
   }  
// END ADD BY Marc TABARY - 2017-03-03 - ORGANIZATION'S MANAGER
    
// ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
    // Use database colum sortOrder to have the organization level
    if ($old->idOrganization != $this->idOrganization) {
// ADD BY Marc TABARY - 2017-02-17 - Optimization ?
        self::$_subOrganizationList=array();
        self::$_subOrganizationFlatList=array();
// END ADD BY Marc TABARY - 2017-02-17 - Optimization ?
        $this->sortOrder = $this->getOrganizationSortOrder();
        // Only save sortOrder of the Organization
        $this->simpleSave();

        // New level of the subOrganizations
        $subOrga = $this->getRecursiveSubOrganizationsFlatList();
        foreach($subOrga as $key=>$name) {
            $orga = new Organization($key);
            $orga->sortOrder = $orga->getOrganizationSortOrder();
            // Only save sortOrder of the subOrganization
            $orga->simpleSave();
        }
    }
// END ADD BY Marc TABARY - 2017-02-12 - PARENT ORGANIZATION
    
// ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION
    if ($this->idOrganization != $old->idOrganization) {
        // Change the current BudgetElement
        if ($this->idOrganization and trim($this->idOrganization)!='') {
          $this->OrganizationBudgetElementCurrent->topRefType='Organization';
          $this->OrganizationBudgetElementCurrent->topRefId=$this->idOrganization;
          $this->OrganizationBudgetElementCurrent->topId=null;
        } else {
          $this->OrganizationBudgetElementCurrent->topId=null;
          $this->OrganizationBudgetElementCurrent->topRefType=null;
          $this->OrganizationBudgetElementCurrent->topRefId=null;
        } 
                
        // UpdateSynthesis of the old parent organization
        if ($old->idOrganization and trim($old->idOrganization)!="") {
            $oldParentOrganization = new Organization($old->idOrganization);
            $oldParentOrganization->updateSynthesis();
        }
        
        // Update synthesis of the current organization
        // I don't understand why $this->udpateSynthesis does not work
        // $this->updateSynthesis();
        // Then i do that
        $thisOrga = new Organization($this->id);
// CHANGE BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT
        // Take oportunity of updateSynthesis for updating others datas of all BudgetElement of the organization
        $thisOrga->updateSynthesis(
                (($this->idle!=$old->idle and $this->idle==1)?true:false), # Close BudgetElement only on change idle 0 => 1
                ($this->name!=$old->name?true:false)
                );
        // Old
//        $thisOrga->updateSynthesis();
// END CHANGE BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT        
    } else {
        if($this->idle!=$old->idle or $this->name!=$old->name) {
            
            $this->saveOrganizationBudgetElement( # Close BudgetElement only on change idle 0 => 1
                                                 (($this->idle!=$old->idle and $this->idle==1)?$this->idle:null),
                                                 $this->idleDateTime,
                                                 ($this->name!=$old->name?$this->name:null)
                                                );
        }
    }
// END ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION            
    
    return $result; 

  }
  
  
// ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT
/** ===================================================================
 * Save idle, idleDateTime et name of all not closed BudgetElement of this organization
 * @param integer $idle
 * @param datetime $idleDateTime
 * @param string $name
 * @return Result : The Result Class
 */  
public function saveOrganizationBudgetElement($idle=null,$idleDateTime=null,$name=null) {
    if (($idle==null and $name==null) or $this->id==null or trim($this->id)=='') {return null;}

    $crit = array('refType'=>'Organization',
                  'refId'=>$this->id,
                  'idle'=>'0'
                  );
      $result=null;
      $budgetElement = new BudgetElement();
      $budgetElementList = $budgetElement->getSqlElementsFromCriteria($crit,false,null,null,true,true,null);
      foreach($budgetElementList as $budgetElement) {
          if($idle==1) {
              $budgetElement->idle=1;
              $budgetElement->idleDateTime = $idleDateTime;
          }
          if($name!=null) {
              $budgetElement->refName = $name;
          }
          $result=$budgetElement->save();
          if(getLastOperationStatus($result)!='OK') {return $result;}
      }
      return $result;

}  
// END ADD BY Marc TABARY - 2017-03-09 - PERIODIC YEAR BUDGET ELEMENT


  public function delete() {
  	$result = parent::delete();
    return $result;
  }
  

  
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
// ADD BY Marc TABARY - 2017-02-08 - PARENT ORGANIZATION
    // Can't be it's own parent organization
    if ($this->id and $this->id==$this->idOrganization) {
      $result.='<br/>' . i18n('errorHierarchicLoop');
    }  else if (trim($this->idOrganization)){
      // Can't be a sub Organizaton of one of its sub Organizations  
      $parentList=array();
    	$parent=new Organization($this->idOrganization);
    	while ($parent->idOrganization) {
    		$parentList[$parent->idOrganization]=$parent->idOrganization;
    		$parent=new Organization($parent->idOrganization);
    	}
      if (array_key_exists($this->id,$parentList)) {
        $result.='<br/>' . i18n('errorHierarchicLoop');
      }
    }
// END ADD BY Marc TABARY - 2017-02-08 - PARENT ORGANIZATION            

// ADD BY Marc TABARY - 2017-03-03 - ORGANIZATION'S MANAGER
    // An organization's manager must be attached to the organization
    $res = new Resource($this->idResource);
    if ($res->idOrganization!=null and $this->id!=$res->idOrganization) {
        $result.='<br/>' . i18n('organizationManagerDifferentOfThisOrganization');        
    }
// END ADD BY Marc TABARY - 2017-03-03 - ORGANIZATION'S MANAGER
        
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  /** ====================================================================
   * Update the BudgetElement
   * @param sqlElement budgetElement
   */
  public function updateBudgetElementSynthesis($bE=null) {
    if($bE==null) {return;}
    
    // Retrieve organization's projects (idle=0 and 1)
    $prjOrgaList = $this->getRecursiveOrganizationProjects(true,false);

    $periodValue = $bE->year;
    $bE->validatedWork=0;
    $bE->assignedWork=0;
    $bE->realWork=0;
    $bE->leftWork=0;
    $bE->plannedWork=0;
    $bE->validatedCost=0;
    $bE->assignedCost=0;
    $bE->realCost=0;
    $bE->leftCost=0;
    $bE->plannedCost=0;
    $bE->expenseValidatedAmount=0;
    $bE->expenseAssignedAmount=0;
    $bE->expenseRealAmount=0;
    $bE->expenseLeftAmount=0;
    $bE->expensePlannedAmount=0;
    $bE->reserveAmount=0;
    $bE->totalValidatedCost=0;
    $bE->totalAssignedCost=0;
    $bE->totalRealCost=0;
    $bE->totalLeftCost=0;
    $bE->totalPlannedCost=0;

    foreach($prjOrgaList as $keyPrjOrga => $name) {
        // Calculate BudgetElement
        // For Validated, Assigned AND Left => Based on PlanningElement
        $pe=new ProjectPlanningElement();
        $whereClause='(refId='.$keyPrjOrga.' and refType="Project") and ';
        // BudgetElement period based on 
        //      - realStartDate and realEndDate if PlanningElement.idle=1
        //      - validatedStartDate and validatedEndDate if PlanningElement.idle = 0 
        // xxxStartDate = null : No Filter >
        // xxxEndDate = null : No filter <
        // Else filter > and < on selected period
        // This will not work on PostgreSql
        /*$whereClause .= '(
                            (idle=1 and
                                (
                                    (isnull(realStartDate) and isnull(realEndDate)) or
                                    (isnull(realStartDate) and year(realEndDate)=YYYY) OR
                                    (isnull(realEndDate)) OR
                                    (year(realStartDate)=YYYY or year(realEndDate)=YYYY)
                                )
                            ) or
                            (idle=0 and
                                (
                                    (isnull(validatedStartDate) and isnull(validatedEndDate)) or
                                    (isnull(validatedStartDate) and year(validatedEndDate)=YYYY) OR
                                    (isnull(validatedEndDate)) OR
                                    (year(validatedStartDate)=YYYY or year(validatedEndDate)=YYYY)
                                )
                            )
                         )';
        $whereClause = str_replace('YYYY', $periodValue, $whereClause);*/
        // Better proposal to avoid count same project on several years
        $whereClause .= "( ".Sql::getYearFunction('coalesce(validatedStartDate,realStartDate,plannedStartDate,initialStartDate)')."=$periodValue )";
        
        $arrayFields=array('validatedWork',
                           'assignedWork',
                           'realWork',
                           'leftWork',
                           'plannedWork',
                           'validatedCost',
                           'assignedCost',
                           'realCost',
                           'leftCost',
                           'plannedCost',
                           'expenseValidatedAmount',
                           'expenseAssignedAmount',
                           'expenseRealAmount',
                           'expenseLeftAmount',
                           'expensePlannedAmount',
                           'reserveAmount',
                           'totalValidatedCost',
                           'totalAssignedCost',
                           'totalRealCost',
                           'totalLeftCost',
                           'totalPlannedCost'
                          );
        $peSum = $pe->sumSqlElementsFromCriteria($arrayFields, null,$whereClause);

        $bE->validatedWork+=$peSum['sumvalidatedwork'];
        $bE->assignedWork+=$peSum['sumassignedwork'];
        $bE->realWork+=$peSum['sumrealwork'];
        $bE->leftWork+=$peSum['sumleftwork'];
        $bE->plannedWork+=$peSum['sumplannedwork'];
        $bE->validatedCost+=$peSum['sumvalidatedcost'];
        $bE->assignedCost+=$peSum['sumassignedcost'];
        $bE->realCost+=$peSum['sumrealcost'];
        $bE->leftCost+=$peSum['sumleftcost'];
        $bE->plannedCost+=$peSum['sumplannedcost'];
        $bE->expenseValidatedAmount+=$peSum['sumexpensevalidatedamount'];
        $bE->expenseAssignedAmount+=$peSum['sumexpenseassignedamount'];
        $bE->expenseRealAmount+=$peSum['sumexpenserealamount'];
        $bE->expenseLeftAmount+=$peSum['sumexpenseleftamount'];
        $bE->expensePlannedAmount+=$peSum['sumexpenseplannedamount'];
        $bE->reserveAmount+=$peSum['sumreserveamount'];
        $bE->totalValidatedCost+=$peSum['sumtotalvalidatedcost'];
        $bE->totalAssignedCost+=$peSum['sumtotalassignedcost'];
        $bE->totalRealCost+=$peSum['sumtotalrealcost'];
        $bE->totalLeftCost+=$peSum['sumtotalleftcost'];
        $bE->totalPlannedCost+=$peSum['sumtotalplannedcost'];

        // If periodValue < current year
        // Real based on work & expense
        if($periodValue < date('Y')) {
            $bE->realWork=0;
            $bE->realCost=0;
            $bE->totalRealCost=0;

            $bE->expenseAssignedAmount=0;
            $bE->expenseRealAmount=0;
            $bE->expensePlannedAmount=0;                
            $bE->expenseLeftAmount=0;

            //  - Real => based on Work
            $work = new Work();
            $whereClause = 'year<='.$periodValue.' and idProject='.$keyPrjOrga;
            $workSum = $work->sumSqlElementsFromCriteria(array('work','cost'),null,$whereClause);
            $bE->realWork+=$workSum['sumwork'];
            $bE->realCost+=$workSum['sumcost'];
            $bE->totalRealCost+=$workSum['sumcost'];

            // For Expense => based on Expense (real - planned - left=if(planned-real>0 THEN planned-real ELSE 0) - Assigned=planned
            $expense = new Expense();
            $whereClause = 'year<='.$periodValue.' and idProject='.$keyPrjOrga;                
            $expenseSum = $expense->sumSqlElementsFromCriteria(array('plannedAmount','realAmount'), null, $whereClause);
            $bE->expenseAssignedAmount+=$expenseSum['sumplannedamount'];
            $bE->expenseRealAmount+=$expenseSum['sumrealamount'];
            $bE->expensePlannedAmount+=$expenseSum['sumplannedamount'];
            $bE->expenseLeftAmount+=($expenseSum['sumplannedamount']-$expenseSum['sumrealamount']>0?$expenseSum['sumplannedamount']-$expenseSum['sumrealamount']:0);

          // Do again work, plannedWork, expense for each sub-project of project
          $prj = new Project($keyPrjOrga,true);
          $prjList = $prj->getRecursiveSubProjectsFlatList();
          foreach($prjList as $keyPrj=>$prjName) {
                // For Real => based on Work 
                $work = new Work();
                $whereClause = 'year<='.$periodValue.' and idProject='.$keyPrj;
                $workSum = $work->sumSqlElementsFromCriteria(array('work','cost'),null,$whereClause);
                $bE->realWork+=$workSum['sumwork'];
                $bE->realCost+=$workSum['sumcost'];
                $bE->totalRealCost+=$workSum['sumcost'];

                // For Expense => based on Expense (real - planned - left=if(planned-real>0 THEN planned-real ELSE 0) - Assigned=planned
                $expense = new Expense();
                $whereClause = 'year<='.$periodValue.' and idProject='.$keyPrj;
                $expenseSum = $expense->sumSqlElementsFromCriteria(array('plannedAmount','realAmount'), null, $whereClause);
                $bE->expenseAssignedAmount+=$expenseSum['sumplannedamount'];
                $bE->expenseRealAmount+=$expenseSum['sumrealamount'];
                $bE->expensePlannedAmount+=$expenseSum['sumplannedamount'];
                $bE->expenseLeftAmount+=($expenseSum['sumplannedamount']-$expenseSum['sumrealamount']>0?$expenseSum['sumplannedamount']-$expenseSum['sumrealamount']:0);
          } // SubProject
        }
    } // Organization's projects

    // periodValue < current year
    //     - Left = assigned - real
    if($periodValue < date('Y')) {
        $bE->leftWork = ($bE->assignedWork-$bE->realWork<0?0:$bE->assignedWork-$bE->realWork);
        $bE->leftCost = ($bE->assignedCost-$bE->realCost<0?0:$bE->assignedCost-$bE->realCost);
        $bE->totalLeftCost = $bE->leftCost + ($bE->expenseAssignedAmount-$bE->expenseRealAmount<0?0:$bE->expenseAssignedAmount-$bE->expenseRealAmount);
        }
    //Planned (in fact reevaluate) = real + left then assigned
    $bE->plannedCost = $bE->realCost+$bE->leftCost;
    $bE->plannedWork = $bE->realWork+$bE->leftWork;
    $bE->expensePlannedAmount = $bE->expenseRealAmount+$bE->expenseLeftAmount;
    $bE->totalPlannedCost = $bE->totalRealCost+$bE->totalLeftCost;

    $bE->save();
  
  }
// END ADD BY Marc TABARY - 2017-03-13 - PERIODIC YEAR BUDGET ELEMENT - Add BudgetElement

  
  
// ADD BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
  /** ====================================================================
   * Update BudgetElement of :
   *    - the organization
   *    - its parent organizations
   * for each Budget period
   * @param boolean $updateIdle : If true, Updade the BudgetElement's idle
   * @param boolean $updateName : If true, Update the BudgetElement's name
   */
  public function updateSynthesis($updateIdle=true, $updateName=true) {
    // Retrieve organization's projects (idle=0 and 1)
    $prjOrgaList = $this->getRecursiveOrganizationProjects(true,false);

    // Retrieve each BudgetElement of this organization  
    $budgetElement = new BudgetElement();
    // No update for closed BudgetElement
    $scritBe = array('idle'=>'0', 'refType'=>'Organization', 'refId'=>$this->id);
    $budgetElementList=$budgetElement->getSqlElementsFromCriteria($scritBe,FALSE,NULL,NULL,TRUE,TRUE,NULL);
    foreach($budgetElementList as $bE) {
        // Update the idle et idleDateTime of BudgetElement
        if ($updateIdle) {
            $bE->idle = $this->idle;
            $bE->idleDateTime = $this->idleDateTime;
        }
        // Update the BudgetElement's name
        if ($updateName) {
            $bE->refName = $this->name;
        }
        $periodValue = $bE->year;
        $bE->validatedWork=0;
        $bE->assignedWork=0;
        $bE->realWork=0;
        $bE->leftWork=0;
        $bE->plannedWork=0;
        $bE->validatedCost=0;
        $bE->assignedCost=0;
        $bE->realCost=0;
        $bE->leftCost=0;
        $bE->plannedCost=0;
        $bE->expenseValidatedAmount=0;
        $bE->expenseAssignedAmount=0;
        $bE->expenseRealAmount=0;
        $bE->expenseLeftAmount=0;
        $bE->expensePlannedAmount=0;
        $bE->reserveAmount=0;
        $bE->totalValidatedCost=0;
        $bE->totalAssignedCost=0;
        $bE->totalRealCost=0;
        $bE->totalLeftCost=0;
        $bE->totalPlannedCost=0;
        
        foreach($prjOrgaList as $keyPrjOrga => $name) {
            // Calculate BudgetElement
            // For Validated, Assigned AND Left => Based on PlanningElement
            $pe=new ProjectPlanningElement();
            $whereClause='(refId='.$keyPrjOrga.' and refType=\'Project\') and ';
            // BudgetElement period based on 
            //      - realStartDate and realEndDate if PlanningElement.idle=1
            //      - validatedStartDate and validatedEndDate if PlanningElement.idle = 0 
            // xxxStartDate = null : No Filter >
            // xxxEndDate = null : No filter <
            // Else filter > and < on selected period
            /*$whereClause .= '(
                                (idle=1 and
                                    (
                                        (isnull(realStartDate) and isnull(realEndDate)) or
                                        (isnull(realStartDate) and year(realEndDate)=YYYY) OR
                                        (isnull(realEndDate)) OR
                                        (year(realStartDate)=YYYY or year(realEndDate)=YYYY)
                                    )
                                ) or
                                (idle=0 and
                                    (
                                        (isnull(validatedStartDate) and isnull(validatedEndDate)) or
                                        (isnull(validatedStartDate) and year(validatedEndDate)=YYYY) OR
                                        (isnull(validatedEndDate)) OR
                                        (year(validatedStartDate)=YYYY or year(validatedEndDate)=YYYY)
                                    )
                                )
                             )';
            $whereClause = str_replace('YYYY', $periodValue, $whereClause);*/
            $whereClause .= "( ".Sql::getYearFunction('coalesce(validatedStartDate,realStartDate,plannedStartDate,initialStartDate)')."=$periodValue )";
            $arrayFields=array('validatedWork',
                               'assignedWork',
                               'realWork',
                               'leftWork',
                               'plannedWork',
                               'validatedCost',
                               'assignedCost',
                               'realCost',
                               'leftCost',
                               'plannedCost',
                               'expenseValidatedAmount',
                               'expenseAssignedAmount',
                               'expenseRealAmount',
                               'expenseLeftAmount',
                               'expensePlannedAmount',
                               'reserveAmount',
                               'totalValidatedCost',
                               'totalAssignedCost',
                               'totalRealCost',
                               'totalLeftCost',
                               'totalPlannedCost'
                              );
            $peSum = $pe->sumSqlElementsFromCriteria($arrayFields, null,$whereClause);

            $bE->validatedWork+=$peSum['sumvalidatedwork'];
            $bE->assignedWork+=$peSum['sumassignedwork'];
            $bE->realWork+=$peSum['sumrealwork'];
            $bE->leftWork+=$peSum['sumleftwork'];
            $bE->plannedWork+=$peSum['sumplannedwork'];
            $bE->validatedCost+=$peSum['sumvalidatedcost'];
            $bE->assignedCost+=$peSum['sumassignedcost'];
            $bE->realCost+=$peSum['sumrealcost'];
            $bE->leftCost+=$peSum['sumleftcost'];
            $bE->plannedCost+=$peSum['sumplannedcost'];
            $bE->expenseValidatedAmount+=$peSum['sumexpensevalidatedamount'];
            $bE->expenseAssignedAmount+=$peSum['sumexpenseassignedamount'];
            $bE->expenseRealAmount+=$peSum['sumexpenserealamount'];
            $bE->expenseLeftAmount+=$peSum['sumexpenseleftamount'];
            $bE->expensePlannedAmount+=$peSum['sumexpenseplannedamount'];
            $bE->reserveAmount+=$peSum['sumreserveamount'];
            $bE->totalValidatedCost+=$peSum['sumtotalvalidatedcost'];
            $bE->totalAssignedCost+=$peSum['sumtotalassignedcost'];
            $bE->totalRealCost+=$peSum['sumtotalrealcost'];
            $bE->totalLeftCost+=$peSum['sumtotalleftcost'];
            $bE->totalPlannedCost+=$peSum['sumtotalplannedcost'];
            
            // If periodValue < current year
            // Real based on work & expense
            if($periodValue<date('Y')) {
                $bE->realWork=0;
                $bE->realCost=0;
                $bE->totalRealCost=0;

                $bE->expenseAssignedAmount=0;
                $bE->expenseRealAmount=0;
                $bE->expensePlannedAmount=0;                
                $bE->expenseLeftAmount=0;
                
                // For Real => based on Work 
                $work = new Work();
                $whereClause = 'year<=\''.$periodValue.'\' and idProject='.$keyPrjOrga;
                $workSum = $work->sumSqlElementsFromCriteria(array('work','cost'),null,$whereClause);
                $bE->realWork+=$workSum['sumwork'];
                $bE->realCost+=$workSum['sumcost'];
                $bE->totalRealCost+=$workSum['sumcost'];

                // For Expense => based on Expense (real - planned - left=if(planned-real>0 THEN planned-real ELSE 0) - Assigned=planned
                $expense = new Expense();
                $whereClause = 'year<=\''.$periodValue.'\' and idProject='.$keyPrjOrga;                
                $expenseSum = $expense->sumSqlElementsFromCriteria(array('plannedAmount','realAmount'), null, $whereClause);
                $bE->expenseAssignedAmount+=$expenseSum['sumplannedamount'];
                $bE->expenseRealAmount+=$expenseSum['sumrealamount'];
                $bE->expensePlannedAmount+=$expenseSum['sumplannedamount'];
                $bE->expenseLeftAmount+=($expenseSum['sumplannedamount']-$expenseSum['sumrealamount']>0?$expenseSum['sumplannedamount']-$expenseSum['sumrealamount']:0);

              // Do again work, plannedWork, expense for each sub-project of project
              $prj = new Project($keyPrjOrga,true);
              $prjList = $prj->getRecursiveSubProjectsFlatList();
              foreach($prjList as $keyPrj=>$prjName) {
                  // For Real => based on Work 
                  $work = new Work();
                  $whereClause = 'year<=\''.$periodValue.'\' and idProject='.$keyPrj;
                  $workSum = $work->sumSqlElementsFromCriteria(array('work','cost'),null,$whereClause);
                  $bE->realWork+=$workSum['sumwork'];
                  $bE->realCost+=$workSum['sumcost'];
                  $bE->totalRealCost+=$workSum['sumcost'];

                  // For Expense => based on Expense (real - planned - left=if(planned-real>0 THEN planned-real ELSE 0) - Assigned=planned
                  $expense = new Expense();
                  $whereClause = 'year<=\''.$periodValue.'\' and idProject='.$keyPrj;                
                  $expenseSum = $expense->sumSqlElementsFromCriteria(array('plannedAmount','realAmount'), null, $whereClause);
                  $bE->expenseAssignedAmount+=$expenseSum['sumplannedamount'];
                  $bE->expenseRealAmount+=$expenseSum['sumrealamount'];
                  $bE->expensePlannedAmount+=$expenseSum['sumplannedamount'];
                  $bE->expenseLeftAmount+=($expenseSum['sumplannedamount']-$expenseSum['sumrealamount']>0?$expenseSum['sumplannedamount']-$expenseSum['sumrealamount']:0);
              } // SubProject
            }
        } // Organization's projects        
        
        // periodValue < current year
        //     - Left = assigned - real
        if($periodValue<date('Y')) {
            $bE->leftWork = ($bE->assignedWork-$bE->realWork<0?0:$bE->assignedWork-$bE->realWork);
            $bE->leftCost = ($bE->assignedCost-$bE->realCost<0?0:$bE->assignedCost-$bE->realCost);
            $bE->totalLeftCost = $bE->leftCost + ($bE->expenseAssignedAmount-$bE->expenseRealAmount<0?0:$bE->expenseAssignedAmount-$bE->expenseRealAmount);
            }
        //Planned (in fact reevaluate) = real + left then assigned
        $bE->plannedCost = $bE->realCost+$bE->leftCost;
        $bE->plannedWork = $bE->realWork+$bE->leftWork;
        $bE->expensePlannedAmount = $bE->expenseRealAmount+$bE->expenseLeftAmount;
        $bE->totalPlannedCost = $bE->totalRealCost+$bE->totalLeftCost;
        $bE->save();
    }
  
    // Repeat for parent organization
    if ($this->idOrganization and trim($this->idOrganization)!='') {
       $orga = new Organization($this->idOrganization);
       // Don't update idle or name for the parent organizations
       $orga->updateSynthesis(false, false);
    }
  }
// END ADD BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT

  
// ADD BY Marc TABARY - 2017-02-10 - PARENT ORGANIZATION
  /** ====================================================================
   * Update BudgetElement of :
   *    - the organization
   *    - its parent organizations
   * only for the current BudgetElement
   */
  public function updateSynthesisWithoutPeriod() {      
    // Update current budgetElement
    $bec=$this->OrganizationBudgetElementCurrent;
    
    $bec->validatedWork=0;
    $bec->assignedWork=0;
    $bec->realWork=0;
    $bec->leftWork=0;
    $bec->plannedWork=0;
    $bec->validatedCost=0;
    $bec->assignedCost=0;
    $bec->realCost=0;
    $bec->leftCost=0;
    $bec->plannedCost=0;
    $bec->expenseValidatedAmount=0;
    $bec->expenseAssignedAmount=0;
    $bec->expenseRealAmount=0;
    $bec->expenseLeftAmount=0;
    $bec->expensePlannedAmount=0;
    $bec->reserveAmount=0;
    $bec->totalValidatedCost=0;
    $bec->totalAssignedCost=0;
    $bec->totalRealCost=0;
    $bec->totalLeftCost=0;
    $bec->totalPlannedCost=0;

    // Retrieve organization's projects
    
// CHANGE BY Marc TABARY - 2017-03-07 - INCLUDE PROJECTS WITH IDLE=1 OR 0 
    $prjOrgaList = $this->getRecursiveOrganizationProjects(true,false);
    // Old
//    $prjOrgaList = $this->getRecursiveOrganizationProjects(true);
// END CHANGE BY Marc TABARY - 2017-03-07 - INCLUDE PROJECTS WITH IDLE=1 OR 0 
    
    foreach($prjOrgaList as $keyPrjOrga => $name) {
        // Calculate BudgetElement 
    $pe=new ProjectPlanningElement();
// CHANGE BY Marc TABARY - 2017-03-07 - BUDGET ELEMENT WITH PLANNING ELEMENT'S IDLE=1 AND 0 
        $crit=array('refId'=>$keyPrjOrga, 'refType'=>'Project');
        //Old
//        $crit=array('refId'=>$keyPrjOrga, 'refType'=>'Project', 'idle'=>'0');
        $peList=$pe->getSqlElementsFromCriteria($crit);
// END CHANGE BY Marc TABARY - 2017-03-07 - BUDGET ELEMENT WITH PLANNING ELEMENT'S IDLE=1 AND 0 
        foreach($peList as $pe) {
            $bec->validatedWork+=$pe->validatedWork;
            $bec->assignedWork+=$pe->assignedWork;
            $bec->realWork+=$pe->realWork;
            $bec->leftWork+=$pe->leftWork;
            $bec->plannedWork+=$pe->plannedWork;
            $bec->validatedCost+=$pe->validatedCost;
            $bec->assignedCost+=$pe->assignedCost;
            $bec->realCost+=$pe->realCost;
            $bec->leftCost+=$pe->leftCost;
            $bec->plannedCost+=$pe->plannedCost;
            $bec->expenseValidatedAmount+=$pe->expenseValidatedAmount;
            $bec->expenseAssignedAmount+=$pe->expenseAssignedAmount;
            $bec->expenseRealAmount+=$pe->expenseRealAmount;
            $bec->expenseLeftAmount+=$pe->expenseLeftAmount;
            $bec->expensePlannedAmount+=$pe->expensePlannedAmount;
            $bec->reserveAmount+=$pe->reserveAmount;
            $bec->totalValidatedCost+=$pe->totalValidatedCost;
            $bec->totalAssignedCost+=$pe->totalAssignedCost;
            $bec->totalRealCost+=$pe->totalRealCost;
            $bec->totalLeftCost+=$pe->totalLeftCost;
            $bec->totalPlannedCost+=$pe->totalPlannedCost;
        }
    } 
    $bec->save();
    
    // Repeat for parent organization
    if ($this->idOrganization and trim($this->idOrganization)!='') {
       $orga = new Organization($this->idOrganization);
// CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
  //Old
       $orga->updateSynthesisWithoutPeriod();
//       $orga->updateSynthesis();
// END CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
    }
  }
// END ADD BY Marc TABARY - 2017-02-10 - PARENT ORGANIZATION

// CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
  public function updateSynthesisWithOutPeriodAndWithOutHierarchic() {
  //Old
//  public function updateSynthesis() {
// END CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
      
    // Update current budgetElement
    $bec=$this->OrganizationBudgetElementCurrent;
    
    $bec->validatedWork=0;
    $bec->assignedWork=0;
    $bec->realWork=0;
    $bec->leftWork=0;
    $bec->plannedWork=0;
    $bec->validatedCost=0;
    $bec->assignedCost=0;
    $bec->realCost=0;
    $bec->leftCost=0;
    $bec->plannedCost=0;
    $bec->expenseValidatedAmount=0;
    $bec->expenseAssignedAmount=0;
    $bec->expenseRealAmount=0;
    $bec->expenseLeftAmount=0;
    $bec->expensePlannedAmount=0;
    $bec->reserveAmount=0;
    $bec->totalValidatedCost=0;
    $bec->totalAssignedCost=0;
    $bec->totalRealCost=0;
    $bec->totalLeftCost=0;
    $bec->totalPlannedCost=0;
    
    // Add all Projects
    $pe=new ProjectPlanningElement();
    $crit=array('idOrganization'=>$this->id, 'idle'=>'0');
    $peList=$pe->getSqlElementsFromCriteria($crit);
    foreach ($peList as $pe) {
      $bec->validatedWork+=$pe->validatedWork;
      $bec->assignedWork+=$pe->assignedWork;
      $bec->realWork+=$pe->realWork;
      $bec->leftWork+=$pe->leftWork;
      $bec->plannedWork+=$pe->plannedWork;
      $bec->validatedCost+=$pe->validatedCost;
      $bec->assignedCost+=$pe->assignedCost;
      $bec->realCost+=$pe->realCost;
      $bec->leftCost+=$pe->leftCost;
      $bec->plannedCost+=$pe->plannedCost;
      $bec->expenseValidatedAmount+=$pe->expenseValidatedAmount;
      $bec->expenseAssignedAmount+=$pe->expenseAssignedAmount;
      $bec->expenseRealAmount+=$pe->expenseRealAmount;
      $bec->expenseLeftAmount+=$pe->expenseLeftAmount;
      $bec->expensePlannedAmount+=$pe->expensePlannedAmount;
      $bec->reserveAmount+=$pe->reserveAmount;
      $bec->totalValidatedCost+=$pe->totalValidatedCost;
      $bec->totalAssignedCost+=$pe->totalAssignedCost;
      $bec->totalRealCost+=$pe->totalRealCost;
      $bec->totalLeftCost+=$pe->totalLeftCost;
      $bec->totalPlannedCost+=$pe->totalPlannedCost;
      $crit=array('topId'=>$pe->id,'refType'=>'Project');
      // Remove sub-projects : will remove sub-projects of same Organization (already included) and of different Organization (must not be included)
      // This way, for projects with sub-projects we count only work on main project, sub-projects are added separately
      // It is importatn to di this way to remove sub-projects of different Organization 
      $subList=$pe->getSqlElementsFromCriteria($crit);
      foreach ($subList as $sub) {
        $bec->validatedWork-=$sub->validatedWork;
        $bec->assignedWork-=$sub->assignedWork;
        $bec->realWork-=$sub->realWork;
        $bec->leftWork-=$sub->leftWork;
        $bec->plannedWork-=$sub->plannedWork;
        $bec->validatedCost-=$sub->validatedCost;
        $bec->assignedCost-=$sub->assignedCost;
        $bec->realCost-=$sub->realCost;
        $bec->leftCost-=$sub->leftCost;
        $bec->plannedCost-=$sub->plannedCost;
        $bec->expenseValidatedAmount-=$sub->expenseValidatedAmount;
        $bec->expenseAssignedAmount-=$sub->expenseAssignedAmount;
        $bec->expenseRealAmount-=$sub->expenseRealAmount;
        $bec->expenseLeftAmount-=$sub->expenseLeftAmount;
        $bec->expensePlannedAmount-=$sub->expensePlannedAmount;
        $bec->reserveAmount-=$sub->reserveAmount;
        $bec->totalValidatedCost-=$sub->totalValidatedCost;
        $bec->totalAssignedCost-=$sub->totalAssignedCost;
        $bec->totalRealCost-=$sub->totalRealCost;
        $bec->totalLeftCost-=$sub->totalLeftCost;
        $bec->totalPlannedCost-=$sub->totalPlannedCost;
      }
      
    }
    if ($bec->expenseValidatedAmount<0) $bec->expenseValidatedAmount=0;
    if ($bec->expenseAssignedAmount<0) $bec->expenseAssignedAmount=0;
    if ($bec->expenseRealAmount<0) $bec->expenseRealAmount=0;
    if ($bec->expenseLeftAmount<0) $bec->expenseLeftAmount=0;
    if ($bec->expensePlannedAmount<0) $bec->expensePlannedAmount=0;
    $bec->save();
  }
  
  
  /** ===========================================
   * Get the idOrganization of the user connected
   * @return idOrganization
   */
  public static function getUserOrganization() {
    $res=new Affectable(getSessionUser()->id);
    return $res->idOrganization;
  }
  
// ADD BY Marc TABARY - 2017-02-24 - LIST OF RESOURCES LINKED TO THE ORGANIZATION
  /** ===================================================================
   * Get the list of resources linked by id with the organization
   * @return array of resources key-name
   */
  public function getResourcesOfOrganizationsListAsArray($limitToActiveResource=false) {
      if ($limitToActiveResource) {$crit['idle'] = '0';}
      $crit['idOrganization'] = $this->id;
      $resource = new Resource();
      $listRes = SqlElement::transformObjSqlElementInArrayKeyName($resource->getSqlElementsFromCriteria($crit));
      return $listRes;
  }
// END ADD BY Marc TABARY - 2017-02-24 - LIST OF RESOURCES LINKED TO THE ORGANIZATION
  
  
  
// ADD BY Marc TABARY - 2017-02-22 - ORGANIZATION VISIBILITY      
  /** ===========================================================================
   * Get the list of organizations (with sub_organizations) of the connected user
   * @return array of organization's key-name
   */
  public static function getUserOrganizationsListAsArray() {
    $userConnected = new Affectable(getSessionUser()->id);
    if($userConnected->idOrganization and trim($userConnected->idOrganization)!='') {
        $userOrga = new Organization($userConnected->idOrganization);
        return $userOrga->getRecursiveSubOrganizationsFlatList(true,true);
    } else {return array();}        
}
// END ADD BY Marc TABARY - 2017-02-22 - ORGANIZATION VISIBILITY

  
  /** ===========================================================================
   * Get the list of organizations (with sub_organizations) of the connected user
   * @return string of organization's id separated by commas ('0' if no organization)
   */
  public static function getUserOrganizationList() {
// ADD BY Marc TABARY - 2017-02-20 - ORGANIZATION VISIBILITY      
    $userConnected = new Affectable(getSessionUser()->id);
    if($userConnected->idOrganization and trim($userConnected->idOrganization)!='') {
        $userOrga = new Organization($userConnected->idOrganization);
        $orgaList = $userOrga->getRecursiveSubOrganizationsFlatList(true,true);
        if (count($orgaList) === 0 ) {return '0';} 
        $orgaListId='';
        foreach($orgaList as $key => $name) {
            $orgaListId.= $key . ',';
        }        
        return substr($orgaListId, 0, -1);;
    } else {return '0';}
// END ADD BY Marc TABARY - 2017-02-20 - ORGANIZATION VISIBILITY
    
// COMMENT BY Marc TABARY - 2017-02-20 - ORGANIZATION VISIBILITY    
//    $userOrga = self::getUserOrganization(); // TODO : include sub-organizations
//    return $userOrga;
// END COMMENT BY Marc TABARY - 2017-02-20 - ORGANIZATION VISIBILITY    
    
  }


// ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION
  
  /** ==========================================================================
   * Retrieve sortOrder of a organization that represents it hierarchie
   * Top Level = xxxx - Level 1 = xxxx.xxxx - Etc.
   * with xxxx the organization id of the level
   * Rem : This format is used to be coherent with sortOrder of project
   * @return the sortOrder
   */
  public function getOrganizationSortOrder() {
    $orga = $this;
    $sortOrder=sprintf("%04d", $orga->id).'.';
    while ($orga->idOrganization and trim($orga->idOrganization)!='') {
        $orga = new Organization($orga->idOrganization);
        $sortOrder=sprintf("%04d", $orga->id).'.'.$sortOrder;
    }
    return substr($sortOrder, 0, -1);
  }
  
  /** ==========================================================================
   * Recusively retrieves all the hierarchic sub-organization of the current organization
   * @return an array containing id, name, suborganization (recursive array)
   */
  public function getRecursiveSubOrganizations($limitToActiveOrganizations=false) {
    // ADD BY Marc TABARY - 2017-02-17 - Optimization ?      
    if (array_key_exists($this->id, self::$_subOrganizationList)) {
        return self::$_subOrganizationList[$this->id];
    }
    // END ADD BY Marc TABARY - 2017-02-17 - Optimization ?
    
    $crit=array('idOrganization'=>$this->id);
    if ($limitToActiveOrganizations) {
      $crit['idle']='0';
    }

    $subOrganizations=$this->getSqlElementsFromCriteria($crit, false,null,null,null,true) ;
    $subOrganizationsList=null;
    foreach ($subOrganizations as $subOrga) {
      $recursiveList=null;
      $recursiveList=$subOrga->getRecursiveSubOrganizations($limitToActiveOrganizations);
      $arrayOrga=array('id'=>$subOrga->id, 'name'=>$subOrga->name, 'idle'=>$subOrga->idle, 'subItems'=>$recursiveList);
//      $arrayOrga=array('id'=>$subOrga->id, 'name'=>$subOrga->name, 'subItems'=>$recursiveList);
      $subOrganizationsList[]=$arrayOrga;
    }
    self::$_subOrganizationList[$this->id]=$subOrganizationsList;
    return $subOrganizationsList;
  }
  
  /** ==========================================================================
   * Get string (x,y,z) containing recursive sub-Organization
   * Used for idOrganization in
   * @return string
   */
  public function getRecursiveSubOrganizationInString($limitToActiveOrganizations=false, $includeSelf=false) {
      $orgaList = $this->getRecursiveSubOrganizationsFlatList($limitToActiveOrganizations, $includeSelf);
        if (count($orgaList) === 0 ) {return '(0)';} 
        $orgaListId='(';
        foreach($orgaList as $key => $name) {
            $orgaListId.= $key . ',';
        }        
        return substr($orgaListId, 0, -1).')';      
  }
  
// ADD BY Marc TABARY - 2017-03-16 - DRAW LIST OF PROJECTS LINKED TO THE ORGANIZATION AND ITS SUB-ORGANIZATION
    /** ==========================================================================
   * Recusively retrieves all the sub-organization of the current organization
   * and presents it as an array list (id,name,idle)
   * @return an array containing the list of suborganizations (id=>array('name'=>name,'idle'=>idle))
   * 
   */
  public function getRecursiveSubOrganizationsIdNameIdleList($limitToActiveOrganizations=false, $includeSelf=false) {

    $tab=$this->getRecursiveSubOrganizations($limitToActiveOrganizations);
    $list=array();
    if ($includeSelf) {
      $list[$this->id]=array('name'=>$this->name,'idle'=>$this->idle);      
    }
    if ($tab) {
      foreach($tab as $subTab) {
        $id=$subTab['id'];
        $name=$subTab['name'];
        $idle=$subTab['idle'];
        $list[$id]=array('name'=>$name,'idle'=>$idle);
//        $subobj=new Organization($id, false);
        $subobj=new Organization();
        $subobj->id = $id;
        $sublist=$subobj->getRecursiveSubOrganizationsIdNameIdleList($limitToActiveOrganizations);
        if ($sublist) {
          $list=array_merge_preserve_keys($list,$sublist);
        }
      }
    }
    return $list;
  }
// END ADD BY Marc TABARY - 2017-03-16 - DRAW LIST OF PROJECTS LINKED TO THE ORGANIZATION AND ITS SUB-ORGANIZATION

  
  /** ==========================================================================
   * Recusively retrieves all the sub-organization of the current organization
   * and presents it as a flat array list of id=>name
   * @return an array containing the list of suborganizations as id=>name
   * 
   */
  public function getRecursiveSubOrganizationsFlatList($limitToActiveOrganizations=false, $includeSelf=false) {
    // ADD BY Marc TABARY - 2017-02-17 - Optimization ?      
    if (array_key_exists($this->id, self::$_subOrganizationFlatList)) {
        return self::$_subOrganizationFlatList[$this->id];
    }
    // END ADD BY Marc TABARY - 2017-02-17 - Optimization ?

    $tab=$this->getRecursiveSubOrganizations($limitToActiveOrganizations);
    $list=array();
    if ($includeSelf) {
      $list[$this->id]=$this->name;
    }
    if ($tab) {
      foreach($tab as $subTab) {
        $id=$subTab['id'];
        $name=$subTab['name'];
        $list[$id]=$name;
//        $subobj=new Organization($id, false);
        $subobj=new Organization();
        $subobj->id = $id;
        $sublist=$subobj->getRecursiveSubOrganizationsFlatList($limitToActiveOrganizations);
        if ($sublist) {
          $list=array_merge_preserve_keys($list,$sublist);
        }
      }
    }
    self::$_subOrganizationFlatList[$this->id]=$list;
    return $list;
  }

  /** ==========================================================================
   * Retrieve projects of an organization
   * @return an array containing the list of projects as id=>name
   * 
   */
  public function getOrganizationProjects($limitToActiveProjects=false) {
    $crit=array('idOrganization'=>$this->id);
    if ($limitToActiveProjects) {
      $crit['idle']='0';
    }
    $prj = new Project();
    $prjOrgaList=$prj->getSqlElementsFromCriteria($crit);
    $prjList=array();
    foreach($prjOrgaList as $prjOrga) {
        $id = $prjOrga->id;
        $name = $prjOrga->name;
        $prjList[$id] = $name;
    }
    return $prjList;
  }

  public function getProjectsOfOrganizationAndSubOrganizations($obj=null) {
    if($obj==null) {$obj = $this;}  
    $objects=array();
    // Retrieve organization et suborganization in an array ('id'=>array('name','idle')
    $listOrgaAndSubOrga = $obj->getRecursiveSubOrganizationsIdNameIdleList(false,($this->id)?true:false);
    // construct in() string for getSqlElementFromCriteria
    $inString = '';
    foreach($listOrgaAndSubOrga as $orgaAndSubOrga=>$nameIdle) {
        if ($orgaAndSubOrga) $inString.= ','.$orgaAndSubOrga;
    }
    if ($inString!='' and $inString!=',') {
        $inString = '(0'.$inString.')';
        // Retrieve the projects of this organization and its suborganizations
        $whereClose = 'idOrganization in '.$inString;
        $prj = new Project();
        $objects = $prj->getSqlElementsFromCriteria(null,false,$whereClose,null,false,true);        
    }
    
    return $objects;  
  }
  
  /** ==========================================================================
   * Retrieve projects of organization
   * Retrieve projects of its suborganization recursively
   * Output recursively subprojets of projects of organization
   * and presents it as a flat array list of id=>name
   * @return an array containing the list of projects as id=>name
   * 
   */
// CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
    public function getRecursiveOrganizationProjects($limitToActiveOrganizations=false,$limitToActiveProjects=true) {  
    //Old    
//  public function getRecursiveOrganizationProjects($limitToActiveOrganizations=false) {
// END CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT  

    if ($limitToActiveOrganizations and $this->idle === 0) {
        return NULL;
    }
    
    // Projects of Organization
// CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
    $prjList=$this->getOrganizationProjects($limitToActiveProjects);
    //Old        
//    $prjList=$this->getOrganizationProjects(true);
// END CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT  
    
    // SubOrganizations of Organization
    $subOrgaList = $this->getRecursiveSubOrganizationsFlatList($limitToActiveOrganizations);
    foreach($subOrgaList as $keySubOrga=>$val) {
        // Projects of SubOrganization
        $Orga = new Organization($keySubOrga, false);
// CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT
        $prjSubOrgaList=$Orga->getOrganizationProjects($limitToActiveProjects);
    //Old        
//        $prjSubOrgaList=$Orga->getOrganizationProjects(true);
// END CHANGE BY Marc TABARY - 2017-03-07 - PERIODIC YEAR BUDGET ELEMENT  
        foreach($prjSubOrgaList as $keyPrjSubOrga=>$name) {
            $id = $keyPrjSubOrga;
            $prjList[$id] = $name;            
        }
    }
    $prjList = array_unique($prjList);
    // Output SubProjects of projects from projects list
    $prjWithOutSubPrjList = $prjList;
    foreach($prjList as $keyPrj => $name) {
        // List of SubProjects
        $project = new Project();
        $project->id = $keyPrj;
        $subPrjList = $project->getRecursiveSubProjectsFlatList($limitToActiveProjects);
      
        foreach($subPrjList as $keySubPrj => $name) {
          if (array_key_exists($keySubPrj, $prjWithOutSubPrjList)) {
              unset($prjWithOutSubPrjList[$keySubPrj]);
          }  
        }
    }
    return $prjWithOutSubPrjList;
  }
  
// END ADD BY Marc TABARY - 2017-02-09 - PARENT ORGANIZATION
  
}?>