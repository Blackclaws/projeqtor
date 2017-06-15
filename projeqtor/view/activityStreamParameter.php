<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
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

/*
 * ============================================================================ Presents an object.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
$user = getSessionUser ();
$showClosed=Parameter::getUserParameter("activityStreamShowClosed");
$activityStreamNumberElement=Parameter::getUserParameter("activityStreamNumberElement");
?>
<div id="resultDiv" style="padding: 5px; padding-bottom: 20px; max-height: 100px; padding-left: 300px; z-index: 999"></div>
<table width="100%">
	<tr height="32px">
		<td width="50px" align="center"><?php echo formatIcon('ActivityStream', 32, null, true);?></td>
		<td><span class="title"><?php echo i18n('menuActivityStream');?>&nbsp;</span></td>
	</tr>
</table>

<div style="width: 100%; margin: 0 auto; height: 90px; padding-bottom: 15px; border-bottom: 1px solid #CCC;background-color:#FFFFFF">
  <form id="activityStreamForm" name="activityStreamForm">
		<table width="100%" class="activityStream">
			<tr>
				<td valign="top" width="10%">
					<table style="margin-left:20px;margin-top:10px;">
					  <input type="hidden" id="activityStreamShowClosed" name="activityStreamShowClosed" value="<?php echo $showClosed;?>" />
						<tr>
							<td align="left" style="white-space:nowrap;padding-right:20px">
							  <a onclick="resetActivityStreamListParameters();refreshActivityStreamList();" href="#" style="cursor: pointer;">
							    <?php echo i18n("activityStreamResetParameters");?>
							  </a>
							  
							</td>
						</tr>
						<tr>
						<td align="left" style="white-space:nowrap;padding-right:20px">
							  <a onclick="switchActivityStreamListShowClosed();refreshActivityStreamList();" href="#" style="cursor: pointer;">
							    <?php echo i18n("activityStreamShowClosed");?>
							  </a><?php $displayShowClosedCheck=($showClosed)?'block':'none';?><span id="activityStreamShowClosedCheck" style="display:<?php echo $displayShowClosedCheck;?>";><img src="css/images/iconSelect.png"/></span>
							</td>
						</tr>
						<tr>
						<td align="left"><?php echo i18n("limitDisplayActivityStream");?>&nbsp;:&nbsp;
						<select title="<?php echo i18n('limitDisplayActivityStream')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
						value="<?php echo $activityStreamNumberElement;?>"
            <?php echo autoOpenFilteringSelect();?> 
            id="activityStreamNumberElement" name="activityStreamNumberElement" style="width:80px;margin-left:16px;" onChange="refreshActivityStreamList();">
                <option value="10">10</option>
                <option value="50">50</option>
                <option value= "100">100</option>
                <option value= "500">500</option>
                <option value= "1000">1000</option>
				    </select></td>
					</tr>
					</table>
				</td>
				<td valign="top" width="20%">
					<table class="activityStreamFilter" style="margin-top:10px;">
						<tr>
							<td align="left">
							 <?php echo i18n('filterOnAuthor');?>
							  <select title="<?php echo i18n('filterOnAuthor')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?> 
                id="activityStreamAuthorFilter" name="activityStreamAuthorFilter" style="width:200px">
                  <?php 
                    $selectedAuthor=Parameter::getUserParameter('activityStreamAuthorFilter');
                    htmlDrawOptionForReference('idUser', $selectedAuthor, null, false); ?>
                  <script type="dojo/method" event="onChange" >
                    refreshActivityStreamList();
                  </script>
                </select>
							</td>
						</tr>
					</table>
				</td>
				<td valign="top" width="20%">
					<table class="activityStreamFilter" style="margin-top:10px;">		
						<tr>
							<td align="left">
							 <?php echo i18n('filterOnType');?>
							  <select title="<?php echo i18n('filterOnType')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?> 
                id="activityStreamTypeNote" name="activityStreamTypeNote" style="width:200px;margin-left:16px;">
                  <?php 
                    $selectedElementType=Parameter::getUserParameter('activityStreamElementType');
                    htmlDrawOptionForReference('idLinkable', $selectedElementType, null, false); ?>
                  <script type="dojo/method" event="onChange" >
                    refreshActivityStreamList();
                  </script>
                </select>
							</td>
						</tr>
						<tr>
					  <td style="width:5px;display:inline;">
					   <?php echo i18n('colId');?>
              <div style="width:15px;" class="filterField rounded" dojoType="dijit.form.TextBox" value=""
               type="text" id="listIdFilterStream" name="listIdFilterStream" onChange="dojo.byId('activityStreamAllItems').value=1;refreshActivityStreamList();">
              </div>
            </td>
           </tr>
					</table>
        </td>
       <td valign="top" width="50%">
        <table style="margin-top: 10px;">
        <input type="hidden" id="activityStreamRecently" name="activityStreamRecently" value="<?php echo Parameter::getUserParameter("activityStreamAllItems");?>" />
						
					<tr>
						<td align="left" >
							 <a onclick="dojo.byId('activityStreamAllItems').value='added';refreshActivityStreamList();" href="#" style="cursor: pointer;">
							   <?php echo i18n("dashboardTicketMainAddedRecently");?>
							 </a>
						</td>
					</tr>
					<tr>
						<td align="left">
							 <a onClick="dojo.byId('activityStreamAllItems').value=2;refreshActivityStreamList();" href="#" style="cursor: pointer;">
							   <?php echo i18n("Old Added");?>
							 </a>
						</td>
					</tr>
					
				 </table>
        </td>
			</tr>
		</table>
	</form>
</div>
