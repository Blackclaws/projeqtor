<?php 
/* ============================================================================
 * Menu defines list of items to present to users.
 */ 
class StatusMail extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $idMailable;
  public $idStatus;
  public $idle;
  public $_col_2_2_SendMail;
  public $_tab_3_1 = array('mailToUser', 'mailToResource', 'mailToProject', 'sendMail');
  public $mailToUser;
  public $mailToResource;
  public $mailToProject;

  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameMailable" formatter="translateFormatter" width="20%" >${idMailable}</th>
    <th field="colorNameStatus" width="25%" formatter="colorNameFormatter">${newStatus}</th>    
    <th field="mailToUser" width="15%" formatter="booleanFormatter" >${mailToUser}</th>
    <th field="mailToResource" width="15%" formatter="booleanFormatter" >${mailToResource}</th>
    <th field="mailToProject" width="15%" formatter="booleanFormatter" >${mailToProject}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("nameMailable"=>"required", 
                                  "nameStatus"=>"required",
  );  
  
  private static $_colCaptionTransposition = array('idStatus'=>'newStatus');
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
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
  
}
?>