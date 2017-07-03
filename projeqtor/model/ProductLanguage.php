<?php
/*
 *	@author: qCazelles 
 */
require_once('_securityCheck.php');
class ProductLanguage extends ProductLanguageMain {
	
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id = NULL, $withoutDependentObjects=false) {
		parent::__construct($id,$withoutDependentObjects);
	}
	
	/** ==========================================================================
	 * Destructor
	 * @return void
	 */
	function __destruct() {
		parent::__destruct();
	}
	
	
}
?>