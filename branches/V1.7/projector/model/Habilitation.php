<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class Habilitation extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $idProfile;
  public $idMenu;
  public $allowAccess;
  
  
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
  
  /** ==========================================================================
   * Execute specific query to dispatch updates so that if a sub-menu is activates
   * its main menu is also activated.
   * Also dispatch to unactivate main parameter if no-submenu is activated
   * @return void
   */
  static function correctUpdates() {

  	$query="insert into habilitation (idProfile, idMenu, allowAccess)";
    $query.=" SELECT profile.id, menu.id, 0";
    $query.=" FROM profile, menu";
    $query.=" WHERE (profile.id, menu.id) not in (select idProfile, idMenu from habilitation)";
  	$result=Sql::query($query);
  	
    $habiObj=new Habilitation();
    $menuObj=new Menu();
    
    // Set Main menu to accessible if one of sub-menu is available
    $query="select distinct h.idProfile, m.idMenu from " . $habiObj->getDatabaseTableName() . " h," .  $menuObj->getDatabaseTableName() . " m";
    $query.=" where h.idMenu = m.id and h.allowAccess=1 and m.idMenu<>0";
    $result=Sql::query($query);
    $critList="";
    $critListInsert="";
    if (Sql::$lastQueryNbRows > 0) {
      $line = Sql::fetchLine($result);
      while ($line) {
        $critList.=($critList=='')?'(':',';
        $critListInsert.=($critListInsert=='')?'(':',';
        $critList.="('" . $line['idMenu'] . "', '" . $line['idProfile'] . "')";
        $critListInsert.="('" . $line['idMenu'] . "', '" . $line['idProfile'] . "')";
        $line = Sql::fetchLine($result);
      }
      $critList.=')';
      $query='update ' . $habiObj->getDatabaseTableName() . ' set allowAccess=1 where (idMenu,idProfile) in ' . $critList;
      Sql::query($query);
    }
    
    // Set Main menu to not accessible if none of sub-menu is available
    $query="SELECT h.idProfile, m.idMenu ";
    $query.=" FROM " . $habiObj->getDatabaseTableName(). " h , " . $menuObj->getDatabaseTableName() . " m ";
    $query.=" WHERE h.idMenu = m.id ";
    $query.=" GROUP BY h.idProfile, m.idMenu";
    $query.=" HAVING m.idMenu<>0 and Sum(h.allowAccess) = 0";
    $result=Sql::query($query);
    $critList="";
    if (Sql::$lastQueryNbRows > 0) {
      $line = Sql::fetchLine($result);
      while ($line) {
        $critList.=($critList=='')?'(':',';
        $critList.="('" . $line['idMenu'] . "', '" . $line['idProfile'] . "')";
        $line = Sql::fetchLine($result);
      }
      $critList.=')';
      $query='update ' . $habiObj->getDatabaseTableName() . ' set allowAccess=0 where (idMenu,idProfile) in ' . $critList;
      Sql::query($query);
    }    
        
  }

}
?>