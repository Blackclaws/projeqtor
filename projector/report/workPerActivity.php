<?PHP
  require_once "../tool/projector.php";  

// Création de l'objet table correspondant à la table où se trouve les infos désirées pour le rapport 
  $objectClass='PlanningElement';
  $obj=new $objectClass();
  $table=$obj->getDatabaseTableName();
  
  
  $print=false;
  if ( array_key_exists('print',$_REQUEST) ) {
    $print=true;
    include_once('../tool/formatter.php');
  }
  
  // Header
  $headerParameters="";
  if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
    $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $_REQUEST['idProject']) . '<br/>';
  }
  include "header.php";

  
  $accessRightRead=securityGetAccessRight('menuProject', 'read');
  
  // Préparation de la requête ///
  $querySelect = '';
  $queryFrom='';
  $queryWhere='';
  $queryOrderBy='';
  $idTab=0;
  if (! array_key_exists('idle',$_REQUEST) ) {
    $queryWhere= $table . ".idle=0 ";
  }
  
  // Création du WHERE. Jointure entre la table PlanningElement et la table Activity
  $queryWhere.= ($queryWhere=='')?'':' and ';
  $queryWhere.=getAccesResctictionClause('Activity',$table);
  if (array_key_exists('idProject',$_REQUEST) and $_REQUEST['idProject']!=' ') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList(true, $_REQUEST['idProject']) ;
  }
  
  // Création du SELECT de la requête (select *)
  $querySelect .= $table . ".* ";
  
  // Création du FROM de la requête
  $queryFrom .= $table;  

  // Création du ORDER BY (par wbs)
  $queryOrderBy .= $table . ".wbsSortable ";

  // Construction et execution de la requete
  $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
  $query='select ' . $querySelect 
       . ' from ' . $queryFrom
       . ' where ' . $queryWhere 
       . ' order by ' . $queryOrderBy;
  $result=Sql::query($query);
  
  // Test de la bonne execution de la requête
  $test=array();
  if (Sql::$lastQueryNbRows > 0) $test[]="OK";
  if (checkNoData($test))  exit;

  // Vérifie que le requête n'est pas vide
  if (Sql::$lastQueryNbRows > 0) {
    
    // Création des colonnes tu tableau ou s'affichera le resultat
    echo '<table>';
    echo '<TR>';
    echo '  <TD class="reportTableHeader" style="width:10px; border-right: 0px;"></TD>';
    echo '  <TD class="reportTableHeader" style="width:200px; border-left:0px; text-align: left;">' . i18n('colTask') . '</TD>';
    echo '  <TD class="reportTableHeader" style="width:60px" nowrap>' . i18n('colValidated') . '</TD>' ;
    echo '  <TD class="reportTableHeader" style="width:60px" nowrap>' . i18n('colAssigned') . '</TD>' ;
    echo '  <TD class="reportTableHeader" style="width:60px" nowrap>' . i18n('colPlanned') . '</TD>' ;
    echo '  <TD class="reportTableHeader" style="width:60px" nowrap>' . i18n('colReal') . '</TD>' ;
    echo '  <TD class="reportTableHeader" style="width:60px" nowrap>' . i18n('colLeft') . '</TD>' ;
    echo '  <TD class="reportTableHeader" style="width:70px" nowrap>' . i18n('progress') . '</TD>' ;
	echo '  <TD class="reportTableHeader" style="width:70px" nowrap>Indicator</TD>' ;
    echo '</TR>';       
    
    // Traitement de chaque ligne du résultat de la requête
    while ($line = Sql::fetchLine($result)) {
    
  	  // Récupération des éléments de resultat dans des variables
      $validatedWork=round($line['validatedWork'],2);
      $assignedWork=round($line['assignedWork'],2);
      $plannedWork=round($line['plannedWork'],2);
      $realWork=round($line['realWork'],2);
      $leftWork=round($line['leftWork'],2);
      $progress=' 0';
      
      // Calcul et création de la variable Progress
      if ($plannedWork>0) {
        $progress=round(100*$realWork/$plannedWork);
      } else {
        if ($line['done']) {
          $progress=100;
        }
      }
      
      // Vérifie si la tâche est une tâche parente ou non
          $pGroup=($line['elementary']=='0')?1:0;
      $compStyle=""; // Variable dédiée au style CSS
	  $compStyleWarning=""; // Variable dédiée au style CSS
	$indicator=""; // Variable dédiée à l'indicateur (Smiley)
	 
	  // Tests de comparaison entre le temps planifié et le temps assigné	
	  // Suivant le resultat, l'indicateur peut être happy, unhappy ou neutral	
	  if($plannedWork >$assignedWork) {
			$indicator="unhappy"; 
		  if( $pGroup) { // Si c'est un parent, on ajuste le style de texte
			$rowType = "group";
			$compStyle="font-weight: bold; background: #E8E8E8 ;";
		  } else if( $line['refType']=='Milestone'){ // Si c'est un Jalon, on ajuste le style de texte
			$rowType  = "mile";
			$compStyle="font-weight: light; font-style:italic;";
		  } else { // Si c'est une simple tâche, on ajuste le style de texte suivant s'il est happy ou non
			$rowType  = "row";
			$compStyleWarning="color: #FF1C32 ;";
		  }
		// Idem que le précédent. Seul le style pour les tâches change suivant s'il est unhappy ou non
	  }	 else if($plannedWork<$assignedWork) {
			$indicator="happy"; 
			if( $pGroup) {
			$rowType = "group";
			$compStyle="font-weight: bold; background: #E8E8E8 ;";
		  } else if( $line['refType']=='Milestone'){
			$rowType  = "mile";
			$compStyle="font-weight: light; font-style:italic;";
		  } else {
			$rowType  = "row";
			$compStyleWarning="color: #65FF2D ;";
		  }
		  // Idem que le précédent. Seul le style pour les tâches change suivant s'il est neutral ou non	
		} else if($plannedWork == $assignedWork) {
			$indicator="neutral"; 
			if( $pGroup) {
			$rowType = "group";
			$compStyle="font-weight: bold; background: #E8E8E8 ;";
		  } else if( $line['refType']=='Milestone'){
			$rowType  = "mile";
			$compStyle="font-weight: light; font-style:italic;";
		  } else {
			$rowType  = "row";
		  }
		  $indicator="neutral"; 
		}
	
	// Création des lignes du tableau contenant les variables voulues et application des styles correspondants
      $wbs=$line['wbsSortable'];
      $level=(strlen($wbs)+1)/4;
      $tab="";
      for ($i=1;$i<$level;$i++) {
        $tab.='<span class="ganttSep">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
      }
      echo '<TR>';
      echo '  <TD class="reportTableData" style="border-right:0px;' . $compStyle . '"><img style="width:16px" src="../view/css/images/icon' . $line['refType'] . '16.png" /></TD>';
      echo '  <TD class="reportTableData" style="border-left:0px; text-align: left;' . $compStyle . '" nowrap>' . $tab . $line['refName'] . '</TD>';
      echo '  <TD class="reportTableData" style="' . $compStyle . '">' . $validatedWork . '</TD>' ;
      echo '  <TD class="reportTableData" style="' . $compStyle."".$compStyleWarning . '">' . $assignedWork . '</TD>' ;
      echo '  <TD class="reportTableData" style="' . $compStyle."".$compStyleWarning  . '">' . $plannedWork . '</TD>' ;
      echo '  <TD class="reportTableData" style="' . $compStyle . '">' . $realWork . '</TD>' ;
      echo '  <TD class="reportTableData" style="' . $compStyle."".$compStyleWarning  . '">' . $leftWork . '</TD>' ;
      echo '  <TD class="reportTableData" style="' . $compStyle . '">'  . percentFormatter($progress) . '</TD>' ;
	  echo '  <TD class="reportTableData" style="border-right:0px;' . $compStyle . '"><img style="width:16px" src="../view/css/images/indicator_' . $indicator . '.png" /></TD>';
      echo '</TR>';        
    }
  }
  echo "</table>"; 
?>