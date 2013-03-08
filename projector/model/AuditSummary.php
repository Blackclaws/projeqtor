<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class AuditSummary extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $auditDay;
  public $firstConnexion;
  public $lastConnexion;
  public $numberSessions;
  public $minDuration;
  public $maxDuration;
  public $meanDuration;
  
  public $_noHistory;
  public $_readOnly=true;
  
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
  
  static function updateAuditSummary($day) {
  	$audit=new Audit();
  	$crit=array('auditDay'=>$day);
  	$summary=SqlElement::getSingleSqlElementFromCriteria('AuditSummary', $crit);
  	$summary->numberSessions=0;
  	$summary->auditDay=$day;
  	$summary->firstConnexion=null;
  	$summary->minDuration=null;
  	$totDuration=0;
  	$list=$audit->getSqlElementsFromCriteria($crit);
  	foreach($list as $audit) {
      if (! $summary->firstConnexion or $audit->connexion<$summary->firstConnexion) {
  		  $summary->firstConnexion=$audit->connexion;
      }  
      if ($audit->disconnexion>$summary->lastConnexion) {
        $summary->lastConnexion=$audit->disconnexion;
      }
      $summary->numberSessions++;
      if (! $summary->minDuration or $audit->duration<$summary->minDuration) {
      	$summary->minDuration=$audit->duration;
      } 
      if ($audit->duration>$summary->maxDuration) {
        $summary->maxDuration=$audit->duration;
      }
      $totDuration+=$audit->duration;
      $summary->meanDuration=$totDuration/$summary->numberSessions;
  	}
  	$result=$summary->save();
  	return $result;
  }
  
}
?>