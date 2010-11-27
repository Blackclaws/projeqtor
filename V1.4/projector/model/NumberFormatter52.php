<?php 
/* ============================================================================
 * Class to replace 5.3 NumberFormatter class in 5.2 version.
 */ 
class NumberFormatter52  {

   public $locale;
   public $type;
   public $decimalSeparator;  
   public $thouthandSeparator;
   const DECIMAL=1;
   
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($locale, $type) {
    $this->locale=$locale;
    $this->type=$type;
    $this->thouthandSeparator=''; // Can get better ?
    if (strtolower(substr($locale,0,2))=='fr' or strtolower(substr($locale,0,2))=='de') {
      $this->decimalSeparator=',';
    } else {
      $this->decimalSeparator='.';
    }
    
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
  }

  /** ==========================================================================
   * Format fonction (simulate)
   */ 
  function format($value) {
    return number_format($value,2,$this->decimalSeparator,$this->thouthandSeparator);
  }
}
?>