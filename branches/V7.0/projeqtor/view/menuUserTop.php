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

include_once("../tool/projeqtor.php");
include_once '../tool/formatter.php';

//Param
$user=getSessionUser();
$imgUrl=Affectable::getThumbUrl('User',$user->id, 22,true);
$obj=new Parameter();
$listTheme=array('ProjeQtOrFlatBlue'=>i18n('themeProjeQtOrFlatBlue'),
    'ProjeQtOrFlatRed'=>i18n('themeProjeQtOrFlatRed'),
    'ProjeQtOrFlatGreen'=>i18n('themeProjeQtOrFlatGreen'),
    'ProjeQtOrFlatGrey'=>i18n('themeProjeQtOrFlatGrey'),
    'ProjeQtOr'=>i18n('themeProjeQtOr'),
    'ProjeQtOrFire'=>i18n('themeProjeQtOrFire'),
    'ProjeQtOrForest'=>i18n('themeProjeQtOrForest'),
    'ProjeQtOrEarth'=>i18n('themeProjeQtOrEarth'),
    'ProjeQtOrWater'=>i18n('themeProjeQtOrWater'),
    'ProjeQtOrWine'=>i18n('themeProjeQtOrWine'),
    'ProjeQtOrDark'=>i18n('themeProjeQtOrDark'),
    'ProjeQtOrLight'=>i18n('themeProjeQtOrLight'),
    'Projectom'=>i18n('themeProjectom'),
    'ProjectomLight'=>i18n('themeProjectomLight'),
    'blueLight'=>i18n('themeBlueLight'),
    'blue'=>i18n('themeBlue'),
    'blueContrast'=>i18n('themeBlueContrast'),
    'redLight'=>i18n('themeRedLight'),
    'red'=>i18n('themeRed'),
    'redContrast'=>i18n('themeRedContrast'),
    'greenLight'=>i18n('themeGreenLight'),
    'green'=>i18n('themeGreen'),
    'greenContrast'=>i18n('themeGreenContrast'),
    'orangeLight'=>i18n('themeOrangeLight'),
    'orange'=>i18n('themeOrange'),
    'orangeContrast'=>i18n('themeOrangeContrast'),
    'greyLight'=>i18n('themeGreyLight'),
    'grey'=>i18n('themeGrey'),
    'greyContrast'=>i18n('themeGreyContrast'),
    'white'=>i18n('themeWhite'),
    'ProjectOrRia'=>i18n('themeProjectOrRIA'),
    'ProjectOrRiaContrasted'=>i18n('themeProjectOrRIAContrasted'),
    'ProjectOrRiaLight'=>i18n('themeProjectOrRIALight'),
    'random'=>i18n('themeRandom')); // keep 'random' as last value to assure it is not selected via getTheme()
$userLang = getSessionValue('currentLocale');
$userTheme = getSessionValue('theme');
//deco
echo '<table style=" width:99%;">';
echo'   <tr>';
echo'     <td>';
echo'       <div class="pseudoButton disconnectTextClass" style="border-top:0.1px solid #000000; width:120px;" title="'.i18n('disconnectMessage').'" onclick="disconnect(true);"> ';
echo'         <table style="width:122px;">';
echo'           <tr>';
echo'            <td> <div class="disconnectClass">&nbsp;</div> </td>';
echo'            <td> '.i18n('disconnect').' </td>';
echo'           </tr>';
echo'         </table>';
echo'       </div>';
echo'     </td>';  
echo'   </tr>';
echo'   <tr>';
echo'     <td>';
echo'       <div class="pseudoButton"  title="'. i18n('menuUserParameter').'" onClick="loadMenuBarItem(\'UserParameter\',\'UserParameter\',\'bar\');">';
//user Param
echo'<table style="width:100%">';
echo'<tr>';
if ($imgUrl) {
  echo'            <td style="width:24px;vertical-align:middle;position:relative;">';      
  echo'            <img style="border-radius:13px;height:26px" src=" '.$imgUrl.'" />';
  echo'            </td>';
}else {
  echo'            <td style="width:24px;padding-top:2px;">';
  echo'              <div class="iconUserParameter22">&nbsp;</div> ';
  echo'           </td> ';
}
echo'            <td style="vertical-align:middle;">&nbsp;'.i18n('menuUserParameter').' &nbsp;&nbsp;</td>';
echo'          </tr>';
echo'        </table> ';     
echo'       </div>';
echo'     </td>';
echo'   </tr>';

//lang
echo' <tr>';
echo'   <td>';
echo '    <select dojoType="dijit.form.FilteringSelect" class="input" name="langMenuUserTop" id="langMenuUserTop" ';
echo autoOpenFilteringSelect();
echo '      title="' . i18n('help' . ucfirst('lang')) . '" style="width:200px">';
echo '<script type="dojo/connect" event="onChange" >';
 echo '  changeLocale(this.value,true);';
 echo '</script>';
$listValues=Parameter::getList('lang');
foreach ($listValues as $value => $valueLabel ) {
  $selected = ($userLang==$value)?'selected':'';
  $value=str_replace(',','#comma#',$value); // Comma sets an isse (not selected) when in value
  echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
}
echo '    </select>';
echo'   </td>';
echo' </tr>';

//theme
echo' <tr>';
echo'   <td>';
echo '    <select dojoType="dijit.form.FilteringSelect" class="input" name="themeMenuUserTop" id="themeMenuUserTop" ';
echo autoOpenFilteringSelect();
echo '      title="' . i18n('help' . ucfirst('theme')) . '" style="width:200px">';
echo $obj->getValidationScript('theme');
$listValues=$listTheme;
foreach ($listValues as $value => $valueLabel ) {
  $selected = ($userTheme==$value)?'selected':'';
  $value=str_replace(',','#comma#',$value); // Comma sets an isse (not selected) when in value
  echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
}
echo '    </select>';
echo'   </td>';
echo' </tr>';

echo'</table>';
?>  
