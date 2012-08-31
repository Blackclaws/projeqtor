<?php
class SqlReference {

  public $id;           // every SqlReference has an id !!!
  public $name;         // displayed name
  public $elementClass; // the class of the completely described element

  /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */
  function __construct($id = NULL, $name = NULL, $elementClass = NULL) {
    $this->id=$id;
    $this->elementClass=$elementClass;
    if ($this->id != NULL and $name == NULL) {
      $this->getSqlReference();
    }
  }

  
  function __destruct() {
     // Can be implemented for all the Classes extending SqlReference
  }
  
  
  /**  ==========================================================================
   * Retrieve an object reference from the Database
   * @return void
   */
  private function getSqlReference() {
    $curId=$this->id;
    $curElementClass=$this->elementClass;
    // If id is set, get the element from Database
    if ($curId != NULL and $curElementClass != NULL) {
      $query = "select name from " . strtolower($curElementClass) . " where id ='" . $curId ."'" ;
      $cnx=Pool::getInstance()->getConnection();
      $result = mysql_query($query,$cnx) or die("Error on request : " . mysql_error() . "\n");
      // result must return only 1 line
      if (mysql_num_rows($result)!=1) {
        echo "Error query returned zero or more than one row :\n" . $query ."\n\n";
      }
      if (mysql_num_rows($result) > 0) {
        $line = mysql_fetch_array($result, MYSQL_ASSOC);
        // get all data fetched
        $this->name=$line['name'];
      }
    }
  }
  
  /** 
   * Retrieve a list of References from Database
   * @param $elementClass
   * @param $criteria
   * @return Array of SqlReference objects
   */
  public static function getSqlReferenceList($elementClass, $criteria = NULL, $order = NULL) {
      
      $list = array();
      
      // $query = "select id, name from " . Sql::str(strtolower($elementClass));
      // $query .= ($criteria != NULL) ? " where " . Sql::str($criteria) : " where idle = 0";
      // $query .= ($order != NULL) ? " order by " . Sql::str($order) : " order by name";
      $query = "select id, name from " . strtolower($elementClass);
      $query .= ($criteria != NULL) ? " where " . $criteria : " where idle = 0";
      $query .= ($order != NULL) ? " order by " . $order : " order by name";      
      print $query;
      $result = Sql::query($query) or die("Error on request : " . mysql_error() . "\n");
      // result must return only 1 line
      
      while ($line = Sql::fetchLine($result)) {
        $list[] = new SqlReference($line["id"], $line["name"], $elementClass);  
      }
      
      return $list;
  }

  
}

?>