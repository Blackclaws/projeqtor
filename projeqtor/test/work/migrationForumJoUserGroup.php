<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class JoUserGroup extends SqlElement {

  // extends SqlElement, so has $id
  
  public $user_id;    // redefine $id to specify its visible place 
  public $group_id;

  private static $_databaseTableName = 'o101506_jo161.jos_user_usergroup_map';

  
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

  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
}
?>