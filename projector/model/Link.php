<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class Link extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $ref1Type;
  public $ref1Id;
  public $ref2Type;
  public $ref2Id;
  
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
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /**
   * Save object (permuts objects ref if needed)
   * @see persistence/SqlElement#save()
   */
  public function save() {
    if ($this->ref2Type < $this->ref1Type) {
      $type=$this->ref2Type;
      $id=$this->ref2Id;
      $this->ref2Type=$this->ref1Type;
      $this->ref2Id=$this->ref1Id;
      $this->ref1Type=$type;
      $this->ref1Id=$id;
    } 
    return parent::save();
  }
  
  /** ==========================================================================
   * Return a list of Link objects involving one given object
   * @param $obj the object we are looking links for
   * @param $classLink optional reference to a class to restrict links of this class
   * @return array of Link objects
   */
  static function getLinksForObject($obj, $classLink=null) {
    $where=null;
    $orderBy=null;
    $link=new Link();
    $class=get_class($obj);
    if ($classLink) {
      if ($class<$classLink) {
        $where=" ref1Type='" . $class . "' and ref1Id='" . $obj->id . "' and ref2Type='" . $classLink . "' ";
      } else {
        $where=" ref2Type='" . $class . "' and ref2Id='" . $obj->id . "' and ref1Type='" . $classLink . "' ";
      }
    } else {
      $where=" ( ref1Type='" . $class . "' and ref1Id='" . $obj->id . "') ";
      $where.=" or ( ref2Type='" . $class . "' and ref2Id='" . $obj->id . "' ) ";
    }
    //echo $where . "\n";
    $list=$link->getSqlElementsFromCriteria(null,false,$where,$orderBy);
    return $list;
  }
  /** ==========================================================================
   * Return a list of links as "type" and "id" array involving one given object
   * @param $obj the object we are looking links for
   * @param $classLink optional reference to a class to restrict links of this class
   * @return array of "type" and "id" sur array
   */
  static function getLinksAsListForObject($obj, $classLink=null) {
    $list = self::getLinksForObject($obj, $classLink);
    $class=get_class($obj);
    $result=array();
    foreach($list as $listObj) {
      $type="";
      $id="";
      if ($listObj->ref1Type==$class and $listObj->ref1Id==$obj->id ) {
         $type=$listObj->ref2Type;
         $id=$listObj->ref2Id;
      } else {
         $type=$listObj->ref1Type;
         $id=$listObj->ref1Id;
      }
      $res=array("type"=>$type, "id"=>$id);
      $result[$listObj->id]=$res;
    }
    return $result;
  }
  
  static function getLinksAsObjectsForObject($obj, $classLink=null) {
    $list = getLinksForObject($obj, $classLink);
    foreach($list as $lstObj) {
      $type="";
      $id="";
      if ($lisObj->ref1Type=$class and $listObj->ref1Id=$obj->id ) {
         $type=$lisObj->ref2Type;
         $id=$lisObj->ref2Id;
      } else {
         $type=$lisObj->ref1Type;
         $id=$lisObj->ref1Id;
      }
      $resObj=new $type($id);
      $result[$lisObj->id]=$resObj;
    }
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
    $checkCrit=array('ref1Type'=>$this->ref1Type,
                     'ref1Id'=>$this->ref1Id,
                     'ref2Type'=>$this->ref2Type,
                     'ref2Id'=>$this->ref2Id);
    $lnk=new Link();
    $check=$lnk->getSqlElementsFromCriteria($checkCrit);
    if (count($check)>0) {
      $result.='<br/>' . i18n('errorDuplicateLink');
    } 
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
}
?>