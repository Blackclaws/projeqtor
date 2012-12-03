<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 

class JoMessage extends SqlElement {

  public $id;    // redefine $id to specify its visible place 
  public $parent;
  public $thread;
  public $catid;
  public $name;
  public $userid;
  public $email;
  public $subject;
  public $time;
  public $ip;
  public $locked;
  public $hold;
  public $ordering;
  public $hits;
  public $moved;
  public $modified_by;
  public $modified_time;
  public $modified_reason;
    
  private static $_databaseTableName = 'o101506_jo161.jos_kunena_messages';
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