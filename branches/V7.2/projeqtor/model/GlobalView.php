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
 * Action is establised during meeting, to define an action to be followed.
 */ 
require_once('_securityCheck.php');
class GlobalView extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_description;
  public $id;
  public $objectClass;
  public $objectId;    // redefine $id to specify its visible place 
  public $reference;
  public $name;
  public $idType;
  public $idProject;
  public $idUser;
  public $description;
  public $idStatus;
  public $idResource;
  public $result;
  public $handled;
  public $done;
  public $idle;
  public $cancelled;
  public $_lib_cancelled;
  //public $_sec_linkMeeting;
  //public $_Link_Meeting=array();
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  public $_nbColMax=3;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" width="0%" >${id}</th>
    <th field="objectClass" formatter="classNameFormatter" width="10%" >${refType}</th>
    <th field="objectId" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameType" width="10%" >${type}</th>
    <th field="name" width="35%" >${name}</th>
     <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "name"=>"required", 
                                  "idProject"=>"required",
                                  "idType"=>"required",
                                  "idUser"=>"hidden",
                                  "idStatus"=>"required",
                                  "idle"=>"nobr",
                                  "cancelled"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array('idResource'=>'responsible', 'idType'=>'type', 'objectClass'=>'refType'
  );
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array();
    
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if ($withoutDependentObjects) return;
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
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }

  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

    if ($colName=="idStatus") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
      $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
      $colScript .= '  var setIdle=0;';
      $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
      $colScript .= '  if (setIdle==1) {';
      $colScript .= '    dijit.byId("idle").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idle").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  var setDone=0;';
      $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
      $colScript .= '  if (setDone==1) {';
      $colScript .= '    dijit.byId("done").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("done").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    } else if ($colName=="initialDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("actualDueDate").get("value")==null) { ';
      $colScript .= '    dijit.byId("actualDueDate").set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    } else if ($colName=="actualDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("initialDueDate").get("value")==null) { ';
      $colScript .= '    dijit.byId("initialDueDate").set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';           
    } else     if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("idleDate").get("value")==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("idleDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '    if (! dijit.byId("done").get("checked")) {';
      $colScript .= '      dijit.byId("done").set("checked", true);';
      $colScript .= '    }';  
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idleDate").set("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="done") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("doneDate").get("value")==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("doneDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("doneDate").set("value", null); ';
      $colScript .= '    if (dijit.byId("idle").get("checked")) {';
      $colScript .= '      dijit.byId("idle").set("checked", false);';
      $colScript .= '    }'; 
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
    
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  public static function getTableNameQuery() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    $obj=new GlobalView();
    $query='(';
    foreach (self::$_globalizables as $class=>$convert) {
      if ($query!='(') $query.=' UNION ';
      $query.="SELECT concat('$class',id) as id";
      foreach ($obj as $fld=>$val) {
        if (substr($fld,0,1)=='_' or $fld=='id') continue;
        
        $query.=", ";
        if ($fld=='objectClass') $query.="concat('".i18n($class)."','|','$class')";
        else if ($fld=='objectId') $query.="id";
        else if (isset($convert[$fld])) $query.=$convert[$fld];
        else if ($fld=='idType') $query.="id".$class."Type";
        else $query.=$fld;
        $query.=" as $fld";
      }
      $clsObj=new $class();
      $query.=" FROM ".$clsObj->getDatabaseTableName();
    }
    $query.=')';
    return $query;
  }
  
  public function getGlobalizables() {
    $result=array();
    foreach (self::$_globalizables as $key=>$val) {
      $result[i18n($key)]=$key;
    }
    ksort($result);
    array_flip($result);
    return $result;
  }
  
  static protected $_globalizables=array(
      'Project'=>array('idProject'=>'id','result'=>'null','reference'=>'null'),
      'Ticket'=>array(),
      'Activity'=>array(),
      'Milestone'=>array(),
      'Action'=>array(),
      'Requirement'=>array(),
      'TestCase'=>array(),
      'TestSession'=>array(),
      'Risk'=>array(),
      'Opportunity'=>array(),
      'Issue'=>array(),
      'Meeting'=>array(),
      'Decision'=>array('result'=>'null','handled'=>'null'),
      'Question'=>array(),
      'Incoming'=>array('idType'=>'null','idStatus'=>'null','handled'=>'null','done'=>'null','cancelled'=>'null'),
      'Deliverable'=>array('idType'=>'null','idStatus'=>'null','handled'=>'null','done'=>'null','cancelled'=>'null'),
      //'Delivery'=>array(),
  );

  public static function drawGlobalizableList() {
    
    /*<select title="<?php echo i18n('filterOnType')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                    <?php echo autoOpenFilteringSelect();?>
                    id="listTypeFilter" name="listTypeFilter" style="width:<?php echo $referenceWidth*4;?>px">
                      <?php htmlDrawOptionForReference('id' . $objectClass . 'Type', $objectType, $obj, false); ?>
                      <script type="dojo/method" event="onChange" >
                        refreshJsonList('<?php echo $objectClass;?>');
                      </script>
                    </select>*/
  }
  
}
?>