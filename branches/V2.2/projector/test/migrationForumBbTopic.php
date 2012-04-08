<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class BbTopic extends SqlElement {

  // extends SqlElement, so has $id
  
  public $id;    // redefine $id to specify its visible place 
  public $poster;
  public $subject;
  public $posted;
  public $first_post_id;
  public $last_post;
  public $last_post_id;
  public $last_poster;
  public $num_views;
  public $num_replies;
  public $closed;
  public $sticky;
  public $moved_to;
  public $forum_id;
    
  private static $_databaseTableName = 'o101506_projectorForum.forum_topics';

  
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