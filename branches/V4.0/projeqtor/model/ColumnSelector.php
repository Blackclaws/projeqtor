<?php 
/* ============================================================================
 * Client is the owner of a project.
 */ 
class ColumnSelector extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visiblez place 
  public $scope;
  public $objectClass;
  public $idUser;
  public $field;
  public $attribute;
  public $hidden;
  public $sortOrder;
  public $widthPct;
  public $_name;
  public $_displayName;
  public $_formatter;
  public $_from;
  
  private static $cachedLists=array(); 
  private static $allFields=false; // Keep it to false as long as addAllFields() is not fiabilized
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
  public static function getColumnsList($classObj) {	
  	// scope = "list"
  	if (isset(self::$cachedLists['list#'.$classObj])) {
  		return self::$cachedLists['list#'.$classObj];
  	}
    // retrieve from database, in correct order
  	$user=$_SESSION['user'];
  	$cs=new ColumnSelector();
  	$crit=array('scope'=>'list', 'objectClass'=>$classObj, 'idUser'=>$user->id);
  	$csList=$cs->getSqlElementsFromCriteria($crit, false, null, 'sortOrder asc');    
  	$result=array();
    foreach ($csList as $cs) {
    	$result[$cs->field]=$cs;
    }
  
    // retrieve (complete) from layout
    $cpt=count($result);  
  	$obj=new $classObj();
    $layout=$obj->getStaticLayout();
    $dom = new DOMDocument();
		$dom->loadHTML($layout);
		$domx = new DOMXPath($dom);
		$entries = $domx->evaluate("//th");
		foreach ($entries as $entry) {
			  $field=$entry->getAttribute("field");
			  $cpt++;
			  if (array_key_exists($field, $result)) {
			  	$cs=$result[$field];
			  } else {
			    $cs=new ColumnSelector();			  
			    $cs->scope="list";
			    $cs->objectClass=$classObj;
			    $cs->idUser=$user->id;
			    $cs->field=$field;
			    $cs->attribute=$field;
			    if (substr($cs->attribute,0,4)=="name" and $cs->attribute!="name") {$cs->attribute='id'.substr($cs->attribute,4);}
		      if (substr($cs->attribute,0,9)=="colorName") {$cs->attribute='id'.substr($cs->attribute,9);}
			    $cs->hidden=(strtolower($entry->getAttribute("hidden"))=="true")?1:0;
			    $cs->sortOrder=$cpt;
			    $cs->widthPct=str_replace('%','',$entry->getAttribute("width"));
			  }
			  $cs->_name=str_replace(array('# ','${','}'), array('','',''), $entry->nodeValue);
        $cs->_displayName=i18n('col'.ucfirst($cs->_name));
        $cs->_formatter=$entry->getAttribute("formatter");
        $cs->_from=$entry->getAttribute("from");
        $cpt++;
			  if (!$cs->id) { $cs->save(); }
			  $result[$field]=$cs;
		}
		if (self::$allFields) {
			$result=self::addAllFields($result,$obj);
		}
		foreach ($result as $id=>$cs) {
			if (! $cs->_name) {
				if ($cs->id) {
					$cs->delete();
				}
				unset($result[$id]);
			}
		}
		self::$cachedLists['list#'.$classObj]=$result;
    return $result;
  }
  
  private static function addAllFields($result, $obj, $included=false, $sourceClass=null) {
  // TODO : fiabilize this function
    $fieldsArray=$obj->getFieldsArray();     
    $user=$_SESSION['user'];  
    $cpt=count($result);
    foreach($obj as $col => $val) {
      if ( $included and ($col=='id' or $col=='refId' or $col=='refType' or $col=='refName') ) {
        continue;
      }
    	if (substr($col,0,1)=='_') {
      	continue;
      }
      if ($obj->isAttributeSetToField($col,'hidden')) {
      	continue;
      }
      if ($col=="password" or $col=="Origin") {
        continue;
      }
      if (is_object($val)) {
        $result=self::addAllFields($result, $val, true, get_class($obj));
        continue;
      }
      
      $dataType = $obj->getDataType($col);
      $dataLength = $obj->getDataLength($col);
      if ($dataLength>100) {
      	continue;
      } 
      $cpt++;
      $cs=new ColumnSelector();       
      $cs->scope="list";
      if ($included) {
      	$cs->_from=get_class($obj);
      	$cs->objectClass=$sourceClass;
      } else {	
        $cs->objectClass=get_class($obj);
      }    
      $cs->idUser=$user->id;
      $cs->field=$col;
      if (substr($cs->field,0,2)=='id' and strlen($cs->field)>2 and substr($col,2,1)==strtoupper(substr($col,2,1)) ) {
        $cs->field='name'.substr($cs->field,2);
      }	
      if (array_key_exists($cs->field,$result)) {
      	continue;
      }
      $cs->attribute=$col;
      $cs->sortOrder=$cpt;
      $cs->widthPct=5;
      $cs->_name=$col;
      $cs->_displayName=$obj->getColCaption($col);
      $cs->_formatter='';
      $cs->hidden=true;
      if ($col=='id') {
        $cs->_formatter="numericFormatter"; 
      } else if ($dataType=='date' or $dataType=='datetime' or $dataType=='time') {
        $cs->_formatter="dateFormatter";
      } else if ($col=='color' and $dataLength == 7 ) {
        $cs->_formatter="colorFormatter";
      } else if ($dataType=='int' and $dataLength==1) {
        $cs->_formatter="booleanFormatter";
      } else if (substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 and substr($col,2,1)==strtoupper(substr($col,2,1)) ) {
        if($col=='idStatus') {
          $formatter="colorNameFormatter";
        } else if($col=='idProfile') {
          $formatter="translateFormatter";
        } else {
          $formatter="nameFormatter";
        }
      } else if ($dataType=='int' or $dataType=='decimal') {
      	$cs->_formatter="numericFormatter"; 
      }
      $cs->id=1000000+$cpt;
      $result[$cs->field]=$cs;
    }
  	return $result;
  }
}
?>