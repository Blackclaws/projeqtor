<?php
/* ============================================================================
 * Default page. Redirects to view directory
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html style="margin: 0px; padding: 0px;">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="shortcut icon" href="view/img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="view/img/logo.ico" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="view/css/projector.css" />
  <title>ProjectOr</title>
  <script language="javascript">
    function autoRedirect() {
      window.setTimeout("document.getElementById('indexForm').submit()",10);
    }
  </script>
</head>

<body class="ProjectOrRia"  style='background-color: #C3C3EB' onload="autoRedirect();">
  <div id="wait">
  &nbsp;
  </div> 
    <table width="100%" height="100%" class="background"><tr height="100%"><td width="100%">
  <table align="center">
    <tr>
      <td rowspan="2" width="140px" valign="top">
        <img src="view/img/logoFull.gif" />
      </td>
      <td  width="550px">
        <img src="view/img/titleFull.gif" />
      </td>
    <tr height="200px">
      <td align="left">
        <p>Loading...</p>
      </td>
    </tr>
  </table>
  </td></tr></table>
  <form id="indexForm" name="indexForm" action="view" method="post">
    <input type="hidden" id="xcurrentLocale" name="xcurrentLocale" value="en" />
  </form>
</body>

</html>
