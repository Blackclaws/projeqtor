<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : Salto Consulting - 2018 
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

// LEAVE SYSTEM
require_once "../tool/projeqtor.php";

?>

<!--------------------------------------------------------------------------------->
<!-- THE DIALOG BOX TO SHOW ERROR IN CALLING API THAT SAVE LEAVE WITH NEW STATUS -->
<!--------------------------------------------------------------------------------->                    
<div id="errorPopup" 
     data-dojo-type="dijit.Dialog" 
     title=<?php echo strtoupper(i18n("ERROR")) ?>>
</div>

<!---------------------------------------------------------------->
<!-- THE DIALOG BOX TO SHOW ERROR IN SAVE LEAVE WITH NEW STATUS -->
<!---------------------------------------------------------------->                    
<div
    dojoType="dijit.layout.ContentPane"
    id="resultPopup"
    style ="width:400px !important; height: 100px; 
            text-align:center; 
            position:absolute; 
            top:50%; left:25%; 
            transform:translate(-50%, -50%);
            z-index: 99999;
            font-weight: bold;
            border: 1px solid #CCCCCC;
            border-radius: 10px;
            box-shadow: 5px 5px 10px #656565;
            cursor:pointer; 
            display: none
           "
    onclick="dojo.byId('resultPopup').style.display='none';"       
    >
</div>
