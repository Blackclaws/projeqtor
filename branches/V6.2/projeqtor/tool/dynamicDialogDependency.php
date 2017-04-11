<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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
include_once ("../tool/projeqtor.php");
$id=RequestHandler::getId('id',true);
$dep=new Dependency($id);
$delayDep=$dep->dependencyDelay;
$commentDep=$dep->comment;


?>
<div class="contextMenuDiv" style="height:152px;">
  <table >
    <tr>
      <td>
        <span>
        <div class="section" style="width:180px;border-radius:1px 1px 0px 0px;">
          <p  style="text-align:center;color:white;height:20px;font-size:15px;"><?php echo i18n("operationUpdate");?></p>
        </div>
			     <form dojoType="dijit.form.Form" id='dynamicRightClickDependencyForm' 
					       name='dynamicRightClickDependencyForm' onSubmit="return false;" style="padding:5px;">
					     <input id="dependencyRightClickId" name="dependencyRightClickId" type="hidden"
						          value="<?php echo $id;?>" />
				       <label for="dependencyDelay" style="text-align: left;display:inline-block;width:100px;"><?php echo i18n("colDependencyDelay");?>&nbsp;:&nbsp;</label>
					     <input id="delayDependency" name="delayDependency" dojoType="dijit.form.NumberTextBox" 
                   constraints="{min:-999, max:999}" 
	                 style="width:25px; text-align: right;display:inline-block;margin-left:-23px;" 
						       value="<?php echo $delayDep;?>" />
						   <div style="display:inline-block;margin-left:38px;">
				          <a onclick="saveDependencyRightClick(<?php $typeDep;?>);">
                      <?php echo formatMediumButton('Save') ;?>
                  </a> 
               </div>   
					     <label for="commentDependency" style="text-align: left;"><?php echo i18n("colComment");?>&nbsp;:&nbsp;</label>
					     <input id="commentDependency" name="commentDependency"  dojoType="dijit.form.Textarea"
						             value="<?php echo $commentDep;?>" />

                             
				   </form>

				  <div style="width:180px;height:25px;"> 
				    <div class="section" style="display: inline-block;width:50%;margin-left:6px;">
			       <p style="text-align:center;color:white;height:20px;font-size:15px;display:inline-block;"><?php echo i18n("deleteButton");?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a>                 		      
			      </div>			      
			      <div div class="section" style="display: inline-block;width:50%;margin-top:2px;margin-left:6px;"> 
			       <p style="text-align:center;color:white;height:20px;font-size:15px;display:inline-block;"><?php echo i18n("close");?></a>		       	    
	          </div>
	          <div style="width:60px;float:right;margin-top:-25px;margin-right:-19px;">		    
	           <a style="margin-left:25%;"><?php echo formatMediumButton('Remove') ;?></a>	
	           <a style="margin-left:25%;"><?php echo formatMediumButton('Mark') ;?></a>
	          </div>
			    </div> 
			    	
			    
			    
			 </span>
			</td>
		</tr>
    <span></span>

  </table>
</div>