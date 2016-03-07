<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projeqtor.php";

$idType=$_REQUEST['idType'];

$detail=new ExpenseDetailType($idType);

if (array_key_exists('expenseDetailId',$_REQUEST)) {
	$expenseDetailId=$_REQUEST['expenseDetailId'];
	$detail=new ExpenseDetail($expenseDetailId);
}

echo "<table>";

showLine('01',$detail->value01, $detail->unit01);
showLine('02',$detail->value02, $detail->unit02);
showLine('03',$detail->value03, $detail->unit03);

function showLine($nb, $value, $unit) {
	if ($unit) {			
		echo '<tr>';
		echo '<td class="dialogLabel" >';
	    echo '<label for="expenseDetailValue' . $nb . '" >' . ($nb=='01'?'':'x&nbsp;') . '</label>';
	    echo '</td>';
	    echo '<td>';
	    //if ($value) {
	    //  echo $value . " ";	
		  //echo '<input id="expenseDetailValue' . $nb . '" name="expenseDetailValue' . $nb . '" value="' . $value . '"'; 
		  //echo '  type="hidden"/>';	
	    //} else {
	      echo '<input id="expenseDetailValue' . $nb . '" name="expenseDetailValue' . $nb . '" value="' . $value . '"'; 
          echo '  dojoType="dijit.form.NumberTextBox"'; 
          echo '  constraints="{min:0}" ';
          echo '  onChange=expenseDetailRecalculate();';
          echo '  style="width:97px"';              
          echo '  />';	
	    //}
	    echo  " " . $unit;
		echo '</td>';
		echo '</tr>';
	} else {
		echo '<input id="expenseDetailValue' . $nb . '" name="expenseDetailValue' . $nb . '" value=""'; 
		echo '  type="hidden"/>';	
	}
	echo '<input id="expenseDetailUnit' . $nb . '" name="expenseDetailUnit' . $nb . '" value="' . $unit .'"';
	echo '  type="hidden"/>';	
}

?>