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

/* ============================================================================
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/imputationValidationList.php');

$user=getSessionUser();
$userName="";
$userTeam="";
$currentWeek=date('Y-m-d');
?>

<div dojoType="dijit.layout.BorderContainer" id="imputationValidationParamDiv" name="imputationValidationParamDiv">
  <div style="top:30px !important; left: 200px !important; width: 500px; margin: 0px 8px 4px 8px; padding: 5px;display:none;" 
       id="imputationValidationResultDiv" dojoType="dijit.layout.ContentPane" region="none" >
  </div>   
  <div dojoType="dijit.layout.ContentPane" region="top" id="imputationValidationButtonDiv" class="listTitle" >
  <form dojoType="dijit.form.Form" name="listForm" id="listForm" action="" method="post" >
  <table width="100%" height="64px" class="listTitle">
    <tr height="32px">
    <td style="vertical-align:top; min-width:100px; width:15%;">
      <table >
		    <tr height="32px">
  		    <td width="50px" align="center">
            <?php echo formatIcon('ImputationValidation', 32, null, true);?>
          </td>
          <td width="100px"><span class="title"><?php echo i18n('menuImputationValidation');?></span></td>
  		  </tr>
  		  <tr height="32px">
          <td>
            <button id="refreshImputationValidationButton" dojoType="dijit.form.Button" showlabel="false"
              title="<?php echo i18n('buttonRefreshList');?>"
              iconClass="dijitButtonIcon dijitButtonIconRefresh" class="detailButton">
              <script type="dojo/method" event="onClick" args="evt">
	             refreshImputationValidation();
              </script>
            </button> 
          </td>
        </tr>
		  </table>
    </td>
      <td>   
        <table>
         <tr>
           <td nowrap="nowrap" style="text-align: right;padding-right:5px;"><?php echo i18n("colIdResource");?></td>
           <td>
              <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft" 
                style="width: 150px;"
                name="userName" id="userName"
                <?php echo autoOpenFilteringSelect();?>
                value="<?php if(sessionValueExists('userName')){
                              $userName =  getSessionValue('userName');
                              echo $userName;
                             }else{
                              if($user->isResource){
                                $userName = $user->id;
                              }else{
                                $userName = 0;
                              }
                              echo $userName;
                             }?>">
                  <script type="dojo/method" event="onChange" >
                    saveDataToSession("userName",dijit.byId('userName').get('value'),false);
                    refreshImputationValidation();
                  </script>
                  <?php 
                   $specific='imputation';
                   include '../tool/drawResourceListForSpecificAccess.php';?>  
              </select>
           </td>
           <td nowrap="nowrap" style="text-align: right;padding-left:20px; padding-right:5px;"><?php echo i18n("weekStartLabel");?></td>
           <td>
             <div dojoType="dijit.form.DateTextBox"
              <?php if (sessionValueExists('browserLocaleDateFormatJs')) {
  							echo ' constraints="{datePattern:\''.getSessionValue('browserLocaleDateFormatJs').'\'}" ';
  						 }?>
               id="weekImputationValidation" name="weekImputationValidation"
               invalidMessage="<?php echo i18n('messageInvalidDate')?>"
               type="text" maxlength="10"
               style="width:100px; text-align: center;" class="input roundedLeft"
               hasDownArrow="true"
               value="<?php if(sessionValueExists('weekImputationValidation')){ echo getSessionValue('weekImputationValidation'); }else{ echo $currentWeek; }?>" >
               <script type="dojo/method" event="onChange" >
                 saveDataToSession('weekImputationValidation',formatDate(dijit.byId('weekImputationValidation').get("value")), false);
                 refreshImputationValidation();
               </script>
             </div>
           </td>
           <td nowrap="nowrap" style="text-align: right;padding-left:5px; padding-right:5px;"><?php echo i18n("weekEndLabel");?> <b><?php echo $currentWeek;?></b></td>
           </tr>
           <tr>
             <td nowrap="nowrap" style="text-align: right;padding-left:50px; padding-right:5px;"><?php echo i18n("colIdTeam");?></td>
               <td>
                 <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft" 
                    style="width: 150px;"
                    name="idTeam" id="idTeam"
                    <?php echo autoOpenFilteringSelect();?>
                    value="<?php if(sessionValueExists('idTeam')){
                                  echo getSessionValue('idTeam');
                                  $userTeam = getSessionValue('idTeam');
                                 }?>">
                    <script type="dojo/method" event="onChange" >
                      saveDataToSession("idTeam",dijit.byId('idTeam').get('value'),false);
                      refreshImputationValidation();
                    </script>
                    <?php htmlDrawOptionForReference('idTeam', null)?>
                </select>
             </td>
         </tr>
        </table>
      </td>
      <td style="text-align: right; align: right;">
        <table width="100%"><tr>
          <td style="min-width:80px;">
          <?php echo i18n("colShowDetail");?>
          </td>
          <td width="35px">
            <div title="<?php echo i18n('helpShowDetail')?>" dojoType="dijit.form.CheckBox" 
              type="checkbox" id="showDetail" name="showDetail" class="whiteCheck"
              <script type="dojo/method" event="onChange" >
              refreshImputationValidation();
            </script>
            </div>&nbsp;
          </td>
          <td style="width:80px;">
          <?php echo i18n("colShowAll");?>
          </td>
          <td width="35px">
            <div title="<?php echo i18n('colShowAll')?>" dojoType="dijit.form.CheckBox" 
              type="checkbox" id="showAll" name="showAll" class="whiteCheck"
              <script type="dojo/method" event="onChange" >
              refreshImputationValidation();
            </script>
            </div>&nbsp;
          </td>
          </tr>
          <tr>
            <td style="min-width:80px;"><?php echo i18n("colShowUnsubmitWork");?></td>
            <td>
              <div title="<?php echo i18n('helpShowUnsubmitWork')?>" dojoType="dijit.form.CheckBox" 
                type="checkbox" id="showUnsubmitWork" name="showUnsubmitWork" class="whiteCheck"
                <script type="dojo/method" event="onChange" >
                  refreshImputationValidation();
                </script>
              </div>&nbsp;
            </td>
            <td width="150px"><?php echo i18n("colShowSubmitWork");?></td>
            <td>
              <div title="<?php echo i18n('helpShowSubmitWork')?>" dojoType="dijit.form.CheckBox" 
                type="checkbox" id="showSubmitWork" name="showSubmitWork" class="whiteCheck"
                <script type="dojo/method" event="onChange" >
                  refreshImputationValidation();
                </script>
              </div>&nbsp;
            </td>
          </tr>
          </table>
      </td>
    </tr>
  </table>
  </form>
  </div>
  <div id="imputationValidationWorkDiv" name="imputationValidationWorkDiv" dojoType="dijit.layout.ContentPane" region="center" >
    <div id="listWorkDiv" name="listWorkDiv">
      <?php ImputationValidation::drawUserWorkList($userName, $userTeam); ?>
    </div>
  </div>  
</div>