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
 * Manage RST files
 */
include "File.php";
$dir=File::getDir();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="keywork" content="projeqtor, project management" />
  <meta name="author" content="projeqtor" />
  <meta name="Copyright" content="Pascal BERNARD" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <title>RST2HTML</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $dir;?>_static/classic.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $dir;?>_static/projeqtor.css" />
  <link rel="stylesheet" type="text/css" href="editor.css" />
  <script type="text/javascript" src="jquery-3.3.1.min.js" ></script>
  <script type="text/javascript" src="editor.js" ></script>

</head>

<body class="ProjeQtOrFlatBlue" style="overflow: hidden;" >
 <table style="width:100%;height:100%">
   <tr >
     <td style="width:10%" class="title">File</td>
     <td style="width:45%" class="title">Editor</td>
     <td style="width:45%" class="title">Preview</td>
   </tr>
     <tr style="height:100%">
     <td style="width:200px">
       <select id="selectedFile" multiple style="height:100%;width:200px" onClick="selectFile(this.value);">
       <?php foreach (File::getRstList() as $file) {?>
         <option value="<?php echo $file?>"><?php echo $file?></option>
       <?php }?>
       </select>
     </td>
     <td style="width:90%">
       <div id="buttonDiv" >
         <table style="width:100%;"><tr>
         <td style="width:5%"><div class="button" id="saveButton" onClick="saveFile();">Save</div></td>
         <td style="width:90%;position:relative;"><div class="result" id="resultMsg" ></div></td>
         <td style="width:5%"><div class="button" id="undoButton" onClick="undoFile();">Undo</div></td>
         </tr></table>
       </div>
       <form id="editorForm" name="editorForm">
       <input type="hidden" id="action" name="action" value=""/>
       <input type="hidden" id="file" name="file" value=""/>
       <textarea id="editor" style="" name="editor" class="editor" placeholder="select a file" onKeyup="convertEditor();" onKeydown="detectKey(event);"></textarea>
       </form>
     </td>
     <td style="width:750px">
            <div id="errorDiv" ></div>
       <div id="preview" class="body" style="width:750px;height:100%">
       </div>
     </td>
   </tr>
 </table>

  
</body>
</html>
