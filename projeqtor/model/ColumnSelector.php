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
  	if (isset($cachedLists['list#'.$classObj])) {
  		return $cachedLists['list#'.$classObj];
  	}
    // retrieve from database
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
		    //debugLog("$entry->tagName => $entry->nodeValue");
		    //debugLog("field=$cs->field, name=$cs->_name, displayName=$cs->_displayName, hidden=$cs->hidden, widthPct=$cs->widthPct");
		}
		foreach ($result as $id=>$cs) {
			if (! $cs->_name) {
				if ($cs->id) {
					$cs->delete();
				}
				unset($result[$id]);
			}
		}
		$cachedLists['list#'.$classObj]=$result;
    return $result;
  }
}
?>