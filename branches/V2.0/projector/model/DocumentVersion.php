<?php 
/* ============================================================================
 * Stauts defines list stauts an activity or action can get in (lifecylce).
 */ 
class DocumentVersion extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;
  public $name;
  public $version;
  public $revision;
  public $draft;
  public $fileName;
  public $fileSize;
  public $mimeType;
  public $versionDate;
  public $extension;
  public $idDocument;
  public $idAuthor;
  public $idStatus;
  public $description;
  public $isRef;
  public $idle;
  
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
  
}
?>