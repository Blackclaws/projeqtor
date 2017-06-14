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
					  <input type="hidden" id="activityStreamAllItems" name="activityStreamAllItems" value="<?php echo Parameter::getUserParameter("activityStreamAllItems");?>" />
						<tr>
							<td align="left" >
							  <a onclick="dojo.byId('activityStreamAllItems').value=0;refreshActivityStreamList();" href="#">
							    <?php echo i18n("activityStreamAllItems");?>
							  </a>
							</td>
						</tr>
						<tr>
					  <td style="width:5px;display:inline;">
					   <?php echo i18n('colId');?>
              <div style="width:15px;" class="filterField rounded" dojoType="dijit.form.TextBox" 
               type="text" id="listIdFilterStream" name="listIdFilterStream" onChange="dojo.byId('activityStreamAllItems').value=1;refreshActivityStreamList();">
              </div>
            </td>
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
                    $selectedAuthor=Parameter::getUserParameter('activityStreamParameter');
                    htmlDrawOptionForReference('idUser', $selectedAuthor, null, false); ?>
                  <script type="dojo/method" event="onChange" >
                    refreshActivityStreamList();
                  </script>
                </select>
							</td>
						</tr>
						<tr>
							<td align="left">
							 <?php echo i18n('filterOnType');?>
							  <select title="<?php echo i18n('filterOnType')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?> 
                id="activityStreamTypeNote" name="activityStreamTypeNote" style="width:200px;margin-left:16px;">
                  <?php 
                    htmlDrawOptionForReference('idLinkable', null, null, false); ?>
                  <script type="dojo/method" event="onChange" >
                    dojo.byId('activityStreamAllItems').value=4;refreshActivityStreamList();
                  </script>
                </select>
							</td>
						</tr>
					</table>
        </td>
       <td valign="top" width="50%">
        <table style="margin-top: 10px;">
					<tr>
						<td align="left" >
							 <a onclick="dojo.byId('activityStreamAllItems').value=3;refreshActivityStreamList();" href="#">
							   <?php echo i18n("dashboardTicketMainAddedRecently");?>
							 </a>
						</td>
					</tr>
					<tr>
						<td align="left">
							 <a onClick="dojo.byId('activityStreamAllItems').value=2;refreshActivityStreamList();" href="#">
							   <?php echo i18n("Old Added");?>
							 </a>
						</td>
					</tr>
					<tr>
						<td align="left"><?php echo i18n("limitDisplayActivityStream");?>&nbsp;:&nbsp;
						<select title="<?php echo i18n('limitDisplayActivityStream')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
            <?php echo autoOpenFilteringSelect();?> 
            id="activityStreamNumberElement" name="activityStreamNumberElement" style="width:80px;margin-left:16px;" onChange="dojo.byId('activityStreamAllItems').value=5;refreshActivityStreamList();">
                <option></option>
                <option>10</option>
                <option>50</option>
                <option>100</option>
                <option>500</option>
                <option>1000</option>
				    </div></td>
					</tr>
				 </table>
        </td>
			</tr>
		</table>
	</form>
</div>
