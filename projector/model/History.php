<?php 
/* ============================================================================
 * History reflects all changes to any object.
 */ 
class History extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $refType;
  public $refId;
  public $operation;
  public $colName; 
  public $oldValue;
  public $newValue;
  public $operationDate;
  public $idUser;
  
  public $_noHistory=true; // Will never save history for this object
  
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

  /** ===========================================================================
   * Store a new History trace (will call ->save)
   * @param $refType type of object updated
   * @param $refId id of object updated
   * @param $operation 
   * @param $colName name of column updated
   * @param $oldValue old value of column (before update)
   * @param $newValue new value of column (after update)
   * @return boolean true if save is OK, false either
   */
  public static function store ($refType, $refId, $operation, $colName=null, $oldValue=null, $newValue=null) {
    $user=(array_key_exists('user',$_SESSION))?$_SESSION['user']:new User();
    $hist=new History();
    $hist->refType=$refType;
    $hist->refId=$refId;
    $hist->operation=$operation;
    $hist->colName=$colName;
    $hist->oldValue=$oldValue;
    $hist->newValue=$newValue;
    $hist->idUser=$user->id;
    $returnValue=$hist->save();
    if (strpos($returnValue,'<input type="hidden" id="lastOperationStatus" value="OK"')) {
      return true;
    } else {
      return false;
    }
  }
}
?>