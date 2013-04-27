<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class BbUser extends SqlElement {

  // extends SqlElement, so has $id
  
  public $id;    // redefine $id to specify its visible place 
  public $group_id;
  public $username;
  public $password;
  public $email;
  public $title;
  public $realname;
  public $registered;
  public $last_visit;
  public $url;
  public $jabber;
  public $icq;
  public $msn;
  public $aim;
  public $yahoo;
  public $signature;
  public $location;
  public $num_posts;
  public $registration_ip;
    
  private static $_databaseTableName = 'o101506_projectorForum.forum_users';

  
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