<?php
/** ============================================================================
 * 
 */

require_once "../tool/projector.php";
$id=$_REQUEST['id'];
$txt=new PredefinedNote($id);
echo $txt->text;