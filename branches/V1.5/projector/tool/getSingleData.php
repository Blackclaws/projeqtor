<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projector.php"; 
    $type=$_REQUEST['dataType'];
    if ($type=='resourceCost') {
      $idRes=$_REQUEST['idResource'];
      if (! $idRes) return;
      $idRol=$_REQUEST['idRole'];
      if (! $idRol) return;
      $r=new Resource($idRes);
      echo htmlDisplayNumeric($r->getActualResourceCost($idRol));
    } else if ($type=='resourceRole') {
      $idRes=$_REQUEST['idResource'];
      if (! $idRes) return;
      $r=new Resource($idRes);
      echo $r->idRole;
    } else {    
      echo '';
    } 
?>
