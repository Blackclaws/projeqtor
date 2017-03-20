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
 * List of items subscribed by a user.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/dynamicSubscriptionForOhter.php');
  
$objectClass=RequestHandler::getClass('objectClass',true); 
$objectId=RequestHandler::getId('objectId',true);

$res=new Affectable();
$crit=array("idle"=>"0");
$lstRes=$res->getSqlElementsFromCriteria($crit,false,null,null,true);
debugLog($lstRes);
$sub=new Subscription();
$crit=array("refType"=>$objectClass,"refId"=>$objectId);
$lstSub=$sub->getSqlElementsFromCriteria($crit,false,null,null,true);
debugLog($lstRes);
foreach ($lstSub as $sub) {
  if (isset($lstRes['#'.$sub->idAffectable])) unset($lstRes['#'.$sub->idAffectable]);
}

echo '<input type="hidden" id="subscriptionObjectClass" value="'.$objectClass.'" />';
echo '<input type="hidden" id="subscriptionObjectClass" value="'.$objectId.'" />';
echo '<table style="width:100%;height:100%;min-height:300px">';
echo '<tr height="20px">';
echo '<td class="section" style="width:200px">'.i18n('available').'</td>';
echo '<td class="" style="width:50px">&nbsp;</td>';
echo '<td class="section" style="width:200px">'.i18n('subscibers').'</td>';
echo '</tr>';
echo '<tr><td colspan="3">&nbsp;</td></tr>';
echo '<tr><td ><input dojoTpe="dijit.form.TextBox" id="subscriptionAvailableSearch" class="input" style="width:210px" value="" onKeyUp="filterDnDList(\'subscriptionAvailableSearch\',\'subscriptionAvailable\',\'div\');" /></td>';
echo '<td >&nbsp;</td>';
echo '<td><input dojoTpe="dijit.form.TextBox" id="subscriptionSubscribedSearch" class="input" style="width:210px" value="" onKeyUp="filterDnDList(\'subscriptionSubscribedSearch\',\'subscriptionSubscribed\',\'div\');" /></td></tr>';
echo '<tr>';
echo '<td style="max-width:200px;vertical-align:top" id="subscriptionAvailable" dojotype="dojo.dnd.Source" dndType="subsription" withhandles="false" class="dijitAccordionTitle" data-dojo-props="accept: [ \'subscription\' ]">';
foreach($lstRes as $res) {
  drawResourceTile($res);
}
echo '</td>';
echo '<td class="" ></td>';
echo '<td style="max-width:200px;vertical-align:top" id="subscriptionSubscribed" dojotype="dojo.dnd.Source" dndType="subsription" withhandles="false" class="dijitAccordionTitle " data-dojo-props="accept: [ \'subscription\' ]">';
foreach($lstSub as $sub) {
  $res=new Affectable($sub->idAffectable);
  drawResourceTile($res);
}
echo '</td>';
echo '</tr>';
echo '</table>';
echo'<br/><table style="width: 100%;" ><tr><td style="width: 100%;" align="center">'
    .'<button dojoType="dijit.form.Button" type="button" onclick="dijit.byId(\'dialogSubscriptionForOthers\').hide();">'.i18n("close").'</button>'
    .'</td></tr></table>';

function drawResourceTile($res){
  global $objectClass, $objectId;
  $name=($res->name)?$res->name:$res->userName;
  echo '<div class="dojoDndItem" id="subscription'.$res->id.'" value="'.str_replace('"','',$name).'" objectclass="'.$objectClass.'" objectid="'.$objectId.'" userid="'.$res->id.'" dndType="subscription" style="position:relative;padding: 2px 5px 3px 5px;margin:0px 3px 5px 3px;color:#707070;min-height:22px;background-color:#ffffff; border:1px solid #707070" >'
    .formatUserThumb($res->id, "", "")
    .$name
    .'</div>';
}
?>