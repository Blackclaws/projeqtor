<?php 
/* ============================================================================
 * Stauts defines list stauts an activity or action can get in (lifecylce).
 */ 
require_once('_securityCheck.php');
class Document extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $documentReference;
  public $externalReference;
  public $idProject;
  public $idProduct;
  public $idDocumentDirectory;
  public $idDocumentType;
  public $name;
  public $idAuthor;
  public $idle;
  public $cancelled;
  public $_lib_cancelled;
  public $_sec_Lock;
  public $_spe_lockButton;
  public $locked;
  public $idLocker;
  public $lockedDate;
  public $_col_2_2_Version; 
  public $idVersioningType;
  public $idDocumentVersion;
  public $idDocumentVersionRef;
  public $idStatus;
  public $_DocumentVersion=array();
  public $_sec_approvers;
  public $_Approver=Array();
  public $_spe_buttonSendMail;
  public $version;
  public $revision;
  public $draft;
  public $_col_1_1_Link;
  public $_Link=array();
  public $_Note=array();
    
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="nameProject" width="10%">${idProject}</th>
    <th field="nameProduct" width="10%">${idProduct}</th>
    <th field="nameDocumentType" width="10%">${type}</th>
    <th field="name" width="25%">${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameDocumentVersion" width="10%">${currentDocumentVersion}</th>
    <th field="nameDocumentVersionRef" width="10%">${reference}</th>
    <th field="locked" width="5%" formatter="booleanFormatter">${locked}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';
//<th field="nameCurrentVersion" width="10%">${idCurrentVersion}</th>
//<th field="nameCurrentRefVersion" width="10%">${idCurrentRefVersion}</th>
    
   private static $_fieldsAttributes=array(
    "id"=>"nobr",
    "idStatus"=>"required",
    "locked"=>"readonly",
    "idLocker"=>"readonly",
    "lockedDate"=>"readonly",
    "idDocumentDirectory"=>"required",
    "idDocumentType"=>"required",
    "idVersioningType"=>"required",
    "idDocumentVersion"=>"readonly",
    "idDocumentVersionRef"=>"hidden",
    "version"=>"hidden",
    "revision"=>"hidden",
    "draft"=>"hidden",
    "idStatus"=>"readonly",
    "documentReference"=>"readonly",
   	"idle"=>"nobr",
    "cancelled"=>"nobr"
   );
   
   private static $_colCaptionTransposition = array('idDocumentType' => 'type',
   'idDocumentVersion' => 'currentDocumentVersion');
   
   
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
    if (!$this->id and array_key_exists('Directory',$_SESSION)) {
    	$this->idDocumentDirectory=$_SESSION['Directory'];
    	self::$_fieldsAttributes['idDocumentDirectory']="readonly";
    	$dir=new DocumentDirectory($this->idDocumentDirectory);
    	$this->idDocumentType=$dir->idDocumentType;
    	$this->idProduct=$dir->idProduct;
    	$this->idProject=$dir->idProject;
    } 
    if ($this->id and $this->idDocumentVersion) {
    	self::$_fieldsAttributes['idVersioningType']="readonly";
    }
    if (!$this->id and ! $this->idAuthor and array_key_exists('user',$_SESSION)) {
    	$user=$_SESSION['user'];
    	$this->idAuthor=$user->id;
    }
    
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
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
    
  protected function getStaticFieldsAttributes() {
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
  }
 
    /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }
  
  public function drawSpecificItem($item){
  	global $print;
    $result="";
    if ($item=='lockButton' and !$print) {
    	if ($this->locked) {
        $canUnlock=false;
        $user=$_SESSION['user'];
        if ($user->id==$this->idLocker) {
        	$canUnlock=true;
    	  } else {
          $right=SqlElement::getSingleSqlElementFromCriteria('habilitationOther', array('idProfile'=>$user->idProfile, 'scope'=>'document'));        
          if ($right) {
            $list=new ListYesNo($right->rightAccess);
            if ($list->code=='YES') {
              $canUnlock=true;
            }
          }  
    	  }
    	  if ($canUnlock) {
	    		$result .= '<tr><td></td><td>';
	        $result .= '<button id="unlockDocument" dojoType="dijit.form.Button" showlabel="true"'; 
	        $result .= ' title="' . i18n('unlockDocument') . '" >';
	        $result .= '<span>' . i18n('unlockDocument') . '</span>';
	        $result .=  '<script type="dojo/connect" event="onClick" args="evt">';
	        $result .=  '  unlockDocument();';
	        $result .= '</script>';
	        $result .= '</button>';
	        $result .= '</td></tr>';
    	  }
    	} else {
	    	$result .= '<tr><td></td><td>';
	    	$result .= '<button id="lockDocument" dojoType="dijit.form.Button" showlabel="true"'; 
	      $result .= ' title="' . i18n('lockDocument') . '" >';
	      $result .= '<span>' . i18n('lockDocument') . '</span>';
	      $result .=  '<script type="dojo/connect" event="onClick" args="evt">';
	      $result .=  '  lockDocument();';
	      $result .= '</script>';
	      $result .= '</button>';
	      $result .= '</td></tr>';
    	}
    	$result .= '<input type="hidden" id="idCurrentUser" name="idCurrentUser" value="' . $_SESSION['user']->id . '" />';
    	return $result;
    }
    if ($item=='buttonSendMail') {
    	if ($print) {
    		return "";
    	}
    	$result .= '<tr><td colspan="2">';
    	$result .= '<button id="sendInfoToApprovers" dojoType="dijit.form.Button" showlabel="true"';
    	$result .= ' title="' . i18n('sendInfoToApprovers') . '" >';
    	$result .= '<span>' . i18n('sendInfoToApprovers') . '</span>';
    	$result .=  '<script type="dojo/connect" event="onClick" args="evt">';
    	$result .= '   if (checkFormChangeInProgress()) {return false;}';
    	$result .=  '  var email="";';
    	$result .=  '  if (dojo.byId("email")) {email = dojo.byId("email").value;}';
    	$result .=  '  loadContent("../tool/sendMail.php","resultDiv","objectForm",true);';
    	$result .= '</script>';
    	$result .= '</button>';
    	$result .= '</td></tr>';
    	return $result;
    }
  }
  
  public function control() {
  	$result="";

  	if (!trim($this->idProject) and !trim($this->idProduct)) {
  		$result.="<br/>" . i18n('messageMandatory',array(i18n('colIdProject') . " " . i18n('colOrProduct')));
  	}
  	
  	$defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;  	 
  }

  public function getNewVersion($type, $draft) {
    if ($type=="major") {
      
    } else if ($type=="minor") {
      
    } else { // 'none'
      
    }
  }
  
  public function save() {
  	$old=$this->getOld();
  	$sep=Parameter::getGlobalParameter('paramPathSeparator');
  	if ($old->name!=$this->name) {
  		$this->documentReference=str_replace($old->name, $this->name, $this->documentReference);
  	}
  	$result=parent::save();
  	if ($old->idDocumentDirectory!=$this->idDocumentDirectory) {
  		// directory changed, must must files !
  		$oldDir=New DocumentDirectory($old->idDocumentDirectory);
  		$oldLoc=$oldDir->getLocation();
  		$newDir=New DocumentDirectory($this->idDocumentDirectory);
  		$newLoc=$newDir->getLocation();
  		if ($oldLoc!=$newLoc) {
  			if (! is_dir($newLoc)) {
  				mkdir($newLoc,0777,true);
  			}
  			$vers=new DocumentVersion();
  			$versList=$vers->getSqlElementsFromCriteria(array('idDocument'=>$this->id));
	  		foreach ($versList as $vers) {
	  		  rename($oldLoc.$sep.$vers->fileName.'.'.$vers->id,$newLoc.$sep.$vers->fileName.'.'.$vers->id);
	  		}
  		}
  	}
  	if ($old->documentReference!=$this->documentReference) {
  	  $vers=new DocumentVersion();
      $versList=$vers->getSqlElementsFromCriteria(array('idDocument'=>$this->id));
      foreach ($versList as $vers) {
        $vers->save(true);
      }
  	}
  	return $result;
  }
  
  public function sendMailToApprovers($onlyNotApproved=true) {
  	$crit=array('refType'=>'Document', 'refId'=>$this->id);
  	if ($onlyNotApproved) {
  		$crit['approved']='0';
  	}
  	$app=new Approver();
  	$appList=$app->getSqlElementsFromCriteria($crit);
  	$dest="";
  	foreach ($appList as $app) {
  		$res=new Affectable($app->idAffectable);
  		$resMail=(($res->name)?$res->name:$res->userName);
  		$resMail.=(($res->email)?' <'.$res->email.'>':'');
  		$resMail=$res->email;
  		$dest.=($dest)?', ':'';	
  		$dest.=$resMail;
  	}
  	$arrayFrom=array();
  	$arrayTo=array();
  	$arrayFrom[]='${dbName}';
  	$arrayTo[]=Parameter::getGlobalParameter('paramDbDisplayName');
  	// url (direct access to item
  	$arrayFrom[]='${url}';
  	$arrayTo[]=$this->getReferenceUrl();
  	// item (class)
  	$arrayFrom[]='${item}';
  	$arrayTo[]=i18n('Document');
    // id
  	$arrayFrom[]='${id}';
  	$arrayTo[]=$this->id;
  	// name
  	$arrayFrom[]='${name}';
  	$arrayTo[]=(property_exists($this, 'name'))?$this->name:'';
  	// status
  	$arrayFrom[]='${status}';
  	$arrayTo[]=(property_exists($this, 'idStatus'))?SqlList::getNameFromId('Status', $this->idStatus):'';
  	// project
  	$arrayFrom[]='${project}';
  	$arrayTo[]=(property_exists($this, 'idProject'))?SqlList::getNameFromId('Project', $this->idProject):'';
  	// type
  	$typeName='idDocumentType';
  	$arrayFrom[]='${type}';
  	$arrayTo[]=(property_exists($this, $typeName))?SqlList::getNameFromId('DocumentType', $this->$typeName):'';
  	// reference
  	$arrayFrom[]='${reference}';
  	$arrayTo[]=(property_exists($this, 'reference'))?$this->reference:'';
  	// externalReference
  	$arrayFrom[]='${externalReference}';
  	$arrayTo[]=(property_exists($this, 'externalReference'))?$this->externalReference:'';
  	// issuer
  	$arrayFrom[]='${issuer}';
  	$arrayTo[]=(property_exists($this, 'idUser'))?SqlList::getNameFromId('User', $this->idUser):'';
  	// responsible
  	$arrayFrom[]='${responsible}';
  	$arrayTo[]=(property_exists($this, 'idResource'))?SqlList::getNameFromId('Resource', $this->idResource):'';
  	// db display name
  	$arrayFrom[]='${dbName}';
  	$arrayTo[]=Parameter::getGlobalParameter('paramDbDisplayName');
  	// sender
  	$arrayFrom[]='${sender}';
  	$user=$_SESSION['user'];
  	$arrayTo[]=($user->resourceName)?$user->resourceName:$user->name;
  	$title=Parameter::getGlobalParameter('paramMailTitleUser');
  	$msg=Parameter::getGlobalParameter('paramMailBodyUser');
  	$result=(sendMail($dest,$title,$msg))?'OK':'';
  	return $result;
  }
}
?>