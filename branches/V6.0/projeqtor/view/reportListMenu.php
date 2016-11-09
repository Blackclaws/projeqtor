<?php 
require_once "../tool/projeqtor.php";
$categ=null;
if (isset($_REQUEST['idCategory'])) {
  $categ=$_REQUEST['idCategory'];
}

echo "<div class='messageData headerReport' style= 'position:absolute;top:0px;left:0px;'>";
echo i18n('colCategory');
echo "</div>";

if (!$categ) {
  $listCateg=SqlList::getList('ReportCategory');
  echo "<ul class='bmenu'>";
  foreach ($listCateg as $id=>$name) {
    echo "<li class='section' onClick='loadDiv(\"../view/reportListMenu.php?idCategory=$id\",\"reportMenuList\");'>$name</li>";
  }
  echo "</ul>";
} else {
  $catObj=new ReportCategory($categ);
  echo "<div class='messageData headerReport' style= 'position:absolute;top:0px;left:0px;'>";
  echo i18n($catObj->name);
  echo "</div>";
  echo "<div class='arrowBack' style= 'position:absolute;top:0px;left:0px;'>";
  echo "<span class='dijitInline dijitButtonNode backButton'  onClick='loadDiv(\"../view/reportListMenu.php\",\"reportMenuList\")'";
  echo formatBigButton('Back');
  echo "</div>";
  echo '</span>';
  
  $report=new Report();
  $crit=array('idReportCategory'=>$categ);
  $listReport=$report->getSqlElementsFromCriteria($crit);
  echo "<ul class='bmenu'>";
  foreach ($listReport as $rpt) {
    echo "<li class='section' onClick='reportSelectReport($rpt->id);'>".i18n($rpt->name)."</li>";   
  }
  echo "</ul>";
}  
  
?>