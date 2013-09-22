<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class BbPost extends SqlElement {

  // extends SqlElement, so has $id
  
  public $id;    // redefine $id to specify its visible place 
  public $poster;
  public $poster_id;
  public $poster_ip;
  public $poster_email;
  public $message;
  public $hide_smilies;
  public $posted;
  public $edited;
  public $edited_by;
  public $topic_id;
    
  private static $_databaseTableName = 'o101506_projectorForum.forum_posts';

  
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