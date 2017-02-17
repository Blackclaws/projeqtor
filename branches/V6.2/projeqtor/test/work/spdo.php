<?php 
class SPDO {
  // tableau des objects PDO
  private static $arrayPDO = array();
  // tableau des chaines de connexion
  private static $arrayConnectionString = array(
    'db1' => '...',   // Connexion pour DB1
    'db2' => '...'   // Connexion pour DB2
    );
  
  private function __construct() {}
  
  public static function getPDO($typeDB) {
    if ( isset(self::$arrayPDO[$typeDB]) ) {
      // Si l'objet PDO recherché est déjà instancié
      return self::$arrayPDO[$typeDB];
    } elseif ( isset(self::$arrayConnectionString[$typeDB]) ) {
      // Si l'objet PDO recherché n'est pas déjà instancié
      // et que la chaine de connexion est connue 
      $pdo=new PDO(self::$arrayConnectionString[$typeDB]);
      self::$arrayPDO[$typeDB]=$pdo;
      return $pdo;
    } else {
      // Si l'objet PDO recherché n'est pas déjà instancié
      // et que la chaine de connexion n'est pas connue 
      print "ERROR unknown DB '$typeDB' \n";
    }
  }
}
?>