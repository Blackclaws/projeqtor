<?php
$section=array();
$sectionName=array();
$link=array();
$tags=array();
$slideRoot='img';
$slideExt='.png';

$i=0;
$slide[$i++]='Welcome'; 
$slide[$i++]='Functional'; 
$slide[$i++]='Functional';
$slide[$i++]='Functional';
$slide[$i++]='Technical';
$slide[$i++]='Technical';
$slide[$i++]='Technical';
$slide[$i++]='Installation';
$slide[$i++]='Configuration';
$slide[$i++]='Parameters';
$slide[$i++]='Parameters';
$slide[$i++]='Parameters';
$slide[$i++]='Parameters';
$slide[$i++]='Installing new version';
$slide[$i++]='Connection';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Graphical User Interface';
$slide[$i++]='Themes';
$slide[$i++]='Themes';
$slide[$i++]='Multilingual';
$slide[$i++]='Creation specificity';
$slide[$i++]='Update specificity';
$slide[$i++]='Delete specificity';
$slide[$i++]='X Ticket';
$slide[$i++]='X Activity';
$slide[$i++]='X Milestone';
$slide[$i++]='X Real work allocation';
$slide[$i++]='Planning';
$slide[$i++]='Planning';
$slide[$i++]='Planning';
$slide[$i++]='X Report';
$slide[$i++]='X Risk';
$slide[$i++]='X Action';
$slide[$i++]='X Issue';
$slide[$i++]='X Meeting';
$slide[$i++]='X Decision';
$slide[$i++]='X Question';
$slide[$i++]='X Emails';
$slide[$i++]='X Message';
$slide[$i++]='Import';
$slide[$i++]='X Client';
$slide[$i++]='X Contact';
$slide[$i++]='X Project';
$slide[$i++]='X User';
$slide[$i++]='X Team';
$slide[$i++]='X Resource';
$slide[$i++]='X Affectation';
$slide[$i++]='X Status';
$slide[$i++]='X Severity, Likelihood, Criticallity, Urgency, Priority';
$slide[$i++]='X Workflow';
$slide[$i++]='X Automatic emailing';
$slide[$i++]='X Type';
$slide[$i++]='X Connection Profile';
$slide[$i++]='X Access Profile';
$slide[$i++]='X Access to screens';
$slide[$i++]='X Access to reports';
$slide[$i++]='X Access mode';
$slide[$i++]='X Specific access mode';
$slide[$i++]='X User parameters';
$slide[$i++]='Shortcuts';
$slide[$i++]='History';
$slide[$i++]='Last words';

$tags=array();
$tags['Welcome']='welcome home summary';
$tags['Functional']='functional functionality functionalities summary';

if (! isset($includeManual)) {
  foreach ($slide as $id=>$name) {
    echo 'slide[' . $id . ']=' . $name . '<br/>';
  }
}

$prec='';
foreach ($slide as $id=>$name) {
  if (substr($name,0,2)=='X ') {
    unset($slide[$id]);
  } else {
    if ($name!=$prec) {
      $section[$id]=$name;
      $sectionName[$name]=$id;
      $prec=$name;
    }
  }
}

$link=array();
$link[$sectionName['Welcome']]=array();