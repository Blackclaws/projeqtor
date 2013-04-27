<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class JoUser extends SqlElement {

  // extends SqlElement, so has $id
  
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $username;
  public $email;
  public $password;
  public $usertype;
  public $block;
  public $sendEmail;
  public $registerDate;
  public $lastvisitDate;
  public $activation;
  public $params;
    
  private static $_databaseTableName = 'o101506_jo161.jos_users';
	
  private static $_fieldsAttributes=array('name'=>'hidden');  
  
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
  public function control () {
  	return 'OK';
  }
  
}
?>