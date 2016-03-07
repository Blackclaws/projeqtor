<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
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
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ===========================================================================
 * Acknowledge an operation
 */
if (array_key_exists('resultAck',$_REQUEST)) {
  $result=$_REQUEST['resultAck'];
  $result=str_replace('\"','"',$result);
  $result=str_replace("\'","'",$result);
  echo $result;
} else if (array_key_exists('resultAckDocumentVersion',$_REQUEST)) {
  $result=$_REQUEST['resultAckDocumentVersion'];
  $result=str_replace('\"','"',$result);
  $result=str_replace("\'","'",$result);
  echo $result;
} else {
	echo("ack type not recognized");
  echo 'errorAck';
}
?>