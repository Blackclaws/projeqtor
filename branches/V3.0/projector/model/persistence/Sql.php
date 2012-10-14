<?php
/** ===========================================================================
 * Static method defining all persistance methods
 * TODO : extend to other than MySql Database
 */
class Sql {

  private static $connexion = NULL;
   
  // Database informations
  private static $dbType;
  private static $dbHost;
  private static $dbUser;
  private static $dbPassword;
  private static $dbName;
  private static $dbVersion=NULL;

  // Visible Information
  public static $lastQuery=NULL;           // the string of the last executed query
  public static $lastQueryType=NULL;       // the type of the last executed query : SELECT or UPDATE
  public static $lastQueryResult=NULL;     // the result of the last executed query
  public static $lastQueryNbRows=NULL;     // the number of rows returns of affected by the last executed query
  public static $lastQueryNewid=NULL;      // the new id of the last executed query, if it was an INSERT query
  public static $lastQueryNewObjectId=NULL;
  public static $lastQueryErrorMessage=NULL;
  public static $lastQueryErrorCode=NULL;
  public static $lastConnectError=NULL;  

  /** ========================================================================
   * Constructor (private, because static access only) 
   * => no destructor for this class
   * @return void
   */
  private function __construct() {
  }
	
  /** =========================================================================
   * Execute a query on database and return the result
   * @param $sqlRequest the resquest to be executed. Can be SELECT, UPDATE, INSERT, DELETE or else
   * @return resource of result if query is SELECT, false either
   */
  static function query($sqlRequest=NULL) {
	scriptLog('Sql::query('.$sqlRequest.')');
    if ($sqlRequest==NULL) {
      echo "SQL WARNING : empty query";
      return FALSE;
    }
    // Execute query
    $cnx = self::getConnection();
    self::$lastQueryErrorMessage=NULL;
    self::$lastQueryErrorCode=NULL;
    enableCatchErrors();
    $result = new PDOStatement();
    $checkResult="OK";
    try { 
      $result = $cnx->query($sqlRequest);  
      //traceLog($sqlRequest);
      if (! $result) {
        self::$lastQueryErrorMessage=i18n('sqlError'). ' : ' .$cnx->errorCode() . "<br/><br/>" . $sqlRequest;
        self::$lastQueryErrorCode=$cnx->errorInfo(); 
        errorLog('Error-[' . self::$lastQueryErrorCode . '] ' .self::$lastQueryErrorMessage);
        $checkResult="ERROR";       
      }
    } catch (PDOException $e) {
      $checkResult="EXCEPTION";
      self::$lastQueryErrorMessage=$e->getMessage();
      self::$lastQueryErrorCode=$e->getCode();
      errorLog('Exception-[' . self::$lastQueryErrorCode . '] ' .self::$lastQueryErrorMessage);
      errorLog('   For query : '.$sqlRequest);
      errorLog('   Strack trace :');
      $traces = debug_backtrace();
      foreach ($traces as $idTrace=>$arrayTrace) {
      	errorLog("   #$idTrace "
      	  . ((isset($arrayTrace['class']))?$arrayTrace['class'].'->':'')
      	  . ((isset($arrayTrace['function']))?$arrayTrace['function'].' called at ':'')
      	  . ((isset($arrayTrace['file']))?'['.$arrayTrace['file']:'')
      	  . ((isset($arrayTrace['line']))?':'.$arrayTrace['line']:'')
      	  . ((isset($arrayTrace['file']))?']':'')
      	  );
      }
    }
    disableCatchErrors();
    // store informations about last query
    self::$lastQuery=$sqlRequest;
    self::$lastQueryResult=$result;
    self::$lastQueryType= (is_resource($result)) ? "SELECT" : "UPDATE";
    self::$lastQueryNbRows = (self::$lastQueryType=="SELECT") ? $result->rowCount() : $result->rowCount();
    self::$lastQueryNewid = ($cnx->lastInsertId()) ? $cnx->lastInsertId() : NULL ;
    // return result
    if ($checkResult!='OK') {
    	return false;
    }
    return $result;
  }

  /** =========================================================================
   * Fetch the next line in a result set
   * @param $result
   * @return array of data, or false if no more line
   */
  static function fetchLine($result) {
    if ($result) {
      return $result->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  }
  
  /** =========================================================================
   * Begin a transaction
   * @return void
   */
  public static function beginTransaction() {
    $cnx=self::getConnection();
    if ( $cnx != NULL ) {
      error_reporting(E_ALL ^ E_WARNING);
      if (!$cnx->beginTransaction()) {      
        echo htmlGetErrorMessage("SQL ERROR : Error on Begin Transaction");
        errorLog("SQL ERROR : Error on Begin Transaction");
        //errorLog("[" . mysql_errno($cnx) . "] " . mysql_error($cnx));
        exit; 
      }
      error_reporting(E_ALL ^ E_WARNING);
    }    
  }

  
  /** =========================================================================
   * Commit a transaction (validate the changes)
   * @return void
   */
  public static function commitTransaction() {
    $cnx=self::getConnection();
    if ( $cnx != NULL ) {
      error_reporting(E_ALL ^ E_WARNING);
      if (! $cnx->commit()) {      
        echo htmlGetErrorMessage("SQL ERROR : Error on Commit Transaction");
        errorLog("SQL ERROR : Error on Commit Transaction");
        //errorLog("[" . mysql_errno($cnx) . "] " . mysql_error($cnx));
        exit; 
      }
      error_reporting(E_ALL ^ E_WARNING);
    }
  }

  
  /** =========================================================================
   * RoolBack a transaction (cancel the changes)
   * @return void
   */
  public static function rollbackTransaction() {
    $cnx=self::getConnection();
    if ( $cnx != NULL ) {
      error_reporting(E_ALL ^ E_WARNING);
      if (! $cnx->rollBack() ) {      
        echo htmlGetErrorMessage("SQL ERROR : Error on Rollback Transaction");
        errorLog("SQL ERROR : Error on Rollback Transaction");
        //errorLog("[" . mysql_errno($cnx) . "] " . mysql_error($cnx));
        exit; 
      }
    }
  }
  
  
  /** =========================================================================
   * Replace in the string all the special caracters to ensure a valid query syntax
   * @param $string the string to be protected
   * @return the string, protected to ensure a correct sql query
   */
  public static function str($string, $objectClass=null) {
    // OK, validated, values are not escaped any more on check, but just while writing the query 
    /*if ($objectClass and $objectClass=="History") {
    	return $string; // for history saving, value have just been escaped yet, don't do it twice !
    }*/
  	$str=$string;
    // To be kept : if magic_quote_gpc is on, it would insert \' instead of ' and so on
  	if (get_magic_quotes_gpc()) {
      $str=str_replace('\"','"',$str);
      $str=str_replace("\'","'",$str);
      $str=str_replace('\\\\','\\',$str);
    }   
    $cnx=self::getConnection();
    return $cnx->quote($str);
  }
   
  
  /** =========================================================================
   * Return the connexion. Private. Only for internal use.
   * @return resource connexion to database
   */
  private static function getConnection() {
    $logLevel=Parameter::getGlobalParameter('logLevel');
    if (self::$connexion != NULL) {
      return self::$connexion;
    }

    if (self::$dbType == null) {
      self::$dbType=Parameter::getGlobalParameter('paramDbType');
      self::$dbHost=Parameter::getGlobalParameter('paramDbHost');
      self::$dbUser=Parameter::getGlobalParameter('paramDbUser');
      self::$dbPassword=Parameter::getGlobalParameter('paramDbPassword');
      self::$dbName=Parameter::getGlobalParameter('paramDbName');     
    }
    
    if (self::$dbType != "mysql") {
      if ($logLevel>=3) {
        echo htmlGetErrorMessage("SQL ERROR : Database type unknown '" . self::$dbType . "' \n");
      } else {
        echo htmlGetErrorMessage("SQL ERROR : Database type unknown");
      }
      errorLog("SQL ERROR : Database type unknown '" . self::$dbType . "'");
      self::$lastConnectError="TYPE";
      exit;
    }

    //restore_error_handler();
    //error_reporting(0);
    enableCatchErrors();
    // defines the connection to MySql Database
    ini_set('mysql.connect_timeout', 10);
    try {
    	$dsn = 'mysql:host='.self::$dbHost.';dbname='.self::$dbName;
    	    
    	self::$connexion = new PDO($dsn, self::$dbUser, self::$dbPassword);
    	self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
    	echo htmlGetErrorMessage($e->getMessage( )).'<br />';
    }
    
    /*
    if ( ! self::$connexion = mysql_connect(self::$dbHost, self::$dbUser, self::$dbPassword) ) { 
      if ($logLevel>=3) {
        echo htmlGetErrorMessage(i18n("errorConnectionCNX",array(self::$dbHost, self::$dbUser))) ;
      } else {
        echo htmlGetErrorMessage(i18n("errorConnectionCNX",array('*****', '*****'))) ;
      }     
      errorLog("SQL ERROR : Connexion error, on '" . self::$dbHost . "' for user '" . self::$dbUser . "' ");
      errorLog("[" . mysql_errno() . "] " . mysql_error());
      self::$lastConnectError="USER";
      exit;
    }
    // defines de database name
    if ( ! mysql_select_db(self::$dbName, self::$connexion) ) {
      if ($logLevel>=3) {
        echo htmlGetErrorMessage(i18n("errorConnectionDB",array(self::$dbName))) ;
      } else {
        echo htmlGetErrorMessage(i18n("errorConnectionDB",array('*****'))) ;
      }     
      errorLog("SQL ERROR : Connexion error, Database unknown '" . self::$dbName . "' ");
      errorLog("[" . mysql_errno() . "] " . mysql_error());
      self::$lastConnectError="BASE";
      exit;
    }
    */
    
    ini_set('mysql.connect_timeout', 60);
    //set_error_handler('errorHandler');
    //error_reporting(E_ALL);
    disableCatchErrors();
    self::$lastConnectError=NULL;
    return self::$connexion;
  }

   /** =========================================================================
   * Return the version of the DataBase
   * @return the version of the DataBase, as String Vx.y.z or empty string if never initialized
   */
  public static function getDbVersion() {
    if (self::$dbVersion!=NULL) {
      return self::$dbVersion;
    }
    $crit['idUser']=null;
    $crit['idProject']=null;
    $crit['parameterCode']='dbVersion';
    $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
    if (! $obj or $obj->id==null) {
      return "";
    } else {
      return $obj->parameterValue;
    }
  }
  
   /** =========================================================================
   * Save the version of the DataBase
   * @return void
   */
  public static function saveDbVersion($vers) {
    $crit['idUser']=null;
    $crit['idProject']=null;
    $crit['parameterCode']='dbVersion';
    $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
    $obj->parameterValue=$vers;
    $obj->save();
  }
}
?>