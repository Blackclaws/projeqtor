<?PHP
/**
 * * COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014-2015 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 *
 * ProjeQtOr is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org
 *
 * ** DO NOT REMOVE THIS NOTICE ***********************************************
 */

/**
 * ===========================================================================
 * Get creation information for given object
 */
require_once "../tool/projeqtor.php";
scriptLog ( '   ->/tool/getObjectCreationInfo.php' );
if (! isset($obj)) 
{
	$objectClass = $_REQUEST ['objectClass'];
	$objectId = $_REQUEST ['objectId'];
	$obj = new $objectClass ( $objectId );
}

if ($obj->id and property_exists ( $obj, 'idUser' )) {
?>
<table style="width:100%">
  <td style="width: 50%; text-align: right;">
    <div  style="white-space: nowrap"><?php echo i18n("colIssuer");?>&nbsp;:&nbsp;</div>
    <div  style="white-space: nowrap"><?php echo i18n("colCreationDate");?>&nbsp;:&nbsp;</div>
  </td>
  <td style="width: 50%;">
      <div style="white-space: nowrap" id="buttonDivIssuer"><?php echo SqlList::getNameFromId('Affectable', $obj->idUser);?> </div>
    	<div style="white-space: nowrap" id="buttonDivCreationDate">
    	<?php
							if (property_exists ( $obj, 'creationDateTime' )) {
								echo htmlFormatDateTime ( $obj->creationDateTime, false );
							} else if (property_exists ( $obj, 'creationDate' )) {
								echo htmlFormatDate ( $obj->creationDate );
							}
			?>
			</div>
    </td>
</table>
<?php }?>