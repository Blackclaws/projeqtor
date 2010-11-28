<?php 
/* ============================================================================
 * Manual 
 */
   //include_once '../tool/projector.php'; 
   header ('Content-Type: text/html; charset=UTF-8');
   session_start();
   $includeManual=true;
   include_once 'reference.php'; 
   $page=0;
   if (array_key_exists('page', $_REQUEST)) {
     $page=$_REQUEST['page'];
   } else if (array_key_exists('section', $_REQUEST)) {
     $sec=$_REQUEST['section'];
     foreach($section as $id=>$name) {
       if ($name==$sec) {
         $page=$id;
         break;
       }
     }
   }
   $secName=$slide[$page];
   $prev='';
   $prevSec='';
   $next='';
   $nextSec='';
   foreach ($slide as $id=>$name) {
     if ($id<$page) {
       $prev=$id;
       if ($slide[$id]==$secName) {
         $prevSec=$id;
       }
     } else if ($id>$page) {
       if ($slide[$id]==$secName) {
         $nextSec=$id;
       }
       $next=$id;
       break;
     }
   }
   $defaultTheme="blueLight";
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html class="<?php echo getTheme();?>">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Project'Or RIA - Manual</title>
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <?php if (file_exists("../view/css/projector.css")) {?>
    <link rel="stylesheet" type="text/css" href="../view/css/projector.css" />
  <?php } else {?>
    <link rel="stylesheet" type="text/css" href="projector.css" />
  <?php } ?>
  <script type="text/javascript">
    function loadPage(page) {
      window.location='manual.php?page='+page;
    }
    self.focus();
  </script>
</head>

<body class="<?php echo getTheme();?>">
  <table valign="top" align="center" width="100%" height="100%">
    <tr>
      <td width="210px" valign="top" align="center">
        <?php displayIndex($page);?>
      </td>
      <td valign="top" align="center">
        <table width="10%">
          <tr height="40px">
            <td width="50%" align="left" valign="middle">
             <img/ src="img/home.png" onclick="loadPage(0)" /> 
             <?php if ($prev!=='') {?>
                <img src="img/left.png" onClick="loadPage(<?php echo $prev;?>)" />
              <?php } else {?>
                <img src="img/left-inactive.png" />
              <?php }?> 
              <?php if ($next!='') {?>
                <img src="img/right.png" onClick="loadPage(<?php echo $next;?>)" />
              <?php } else {?>
                <img src="img/right-inactive.png" />
              <?php }?>           
            </td>
            <td width="50%" align="right" valign="middle">
              <?php if ($prevSec!='') {?>
                <img src="img/first.png" onClick="loadPage(<?php echo $prevSec;?>)" />
              <?php } else {?>
                <img src="img/first-inactive.png" />
              <?php }?> 
              <?php if ($nextSec!='') {?>
                <img src="img/last.png" onClick="loadPage(<?php echo $nextSec;?>)" />
              <?php } else {?>
                <img src="img/last-inactive.png" />
              <?php }?> 
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <img src="slides/img<?php echo $page;?>.png" />
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>

<?php 
function displayIndex($page) {
  global $slide, $section;
  echo "<br/>";
  echo '<table class="background" width="95%" aligh="center">';
  echo '<tr height="30px"><th colspan="2" class="title" style="text-align:center;">INDEX</th></tr>'; 
  foreach ($section as $id=>$name) {
    echo '<tr class="menuTree" height="20px">';
    echo '<td width="15px" align="center" >';
    echo ($name==$slide[$page])?'<img src="img/level.png" />':'';
    echo '</td>';
    echo '<td class="menuTree tabLabel" style="text-align:left;cursor: pointer" onClick="loadPage(' . $id . ');">';
    echo $name;
    echo '</td></tr>';
  }
  echo '</table>';
}

function getTheme() {
  global $defaultTheme;
  $theme='blue'; // default if never  set
  if (isset($defaultTheme)) {
    $theme=$defaultTheme;   
  }
  if (array_key_exists('theme',$_SESSION) ) {
    $theme= $_SESSION['theme'] ; 
  }
  if ($theme=="random") {
    $themes=array_keys(Parameter::getList('theme'));
    $rnd=rand(0, count($themes)-2);
    $theme=$themes[$rnd];
    $_SESSION['theme']=$theme; // keep value in session to have same theme during all session...
  }
  return $theme;
}
