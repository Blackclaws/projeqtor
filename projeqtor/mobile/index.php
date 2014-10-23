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

/* ============================================================================
 * Default page. Redirects to view directory
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html style="margin: 0px; padding: 0px;">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="shortcut icon" href="../view/img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="../view/img/logo.ico" type="image/x-icon" />
  <title>ProjeQtOr</title>
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='parseOnLoad: false, 
              isDebug: false'></script>
  <script type="text/javascript">             
     dojo.addOnLoad(function(){
       window.setTimeout('dojo.byId("indexForm").submit();',10);
     });
  </script>
</head>

<body class="ProjeQtOr" style='background-color: #000000' >
  <div id="wait">
  &nbsp;
  </div> 
  <table align="center" width="100%" height="100%" >
    <tr height="100%">
      <td width="100%" align="center">
        <div >
        <table  align="center" >
          <tr style="height:10px;" >
            <td align="left" style="height: 1%;" valign="top">
              <div style="width: 300px; height: 54px; background-size: contain; background-repeat: no-repeat;
              background-image: url(<?php echo (file_exists("../logo.gif"))?'../logo.gif':'../view/img/titleSmall.png';?>);">
              </div>
            </td>
          </tr>
          <tr style="height:100%" height="100%">
            <td style="height:99%" align="left" valign="middle">
              <div  id="formDiv" dojoType="dijit.layout.ContentPane" region="center" style="overflow:hidden">
  				<form id="indexForm" name="indexForm" action="main.php" method="post">
  				</form>
              </div>
            </td>
          </tr>
        </table>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>
