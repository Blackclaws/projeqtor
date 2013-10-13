<?php include_once("../tool/projeqtor.php");?>
<span maxsize="180px" style="position: absolute; left:75px; top:1px; height: 20px; width: 160px; color:#202020;" dojoType="dijit.form.DropDownButton" 
  id="selectedProject" jsId="selectedProject" name="selectedProject" showlabel="true" class="">
  <span style="width:160px; text-align: left;">
    <div style="width:160px; overflow: hidden; text-align: left;" >
    <?php
      $proj='*'; 
      if (array_key_exists('project',$_SESSION)) {
        $proj=$_SESSION['project'];
      } else {
        $_SESSION['project']="*";
      }
      if ($proj=='*') {
        echo '<i>' . i18n('allProjects') . '</i>';
      } else {
        $projObject=new Project($proj);
        echo htmlEncode($projObject->name);
      };
      $prj=new Project();
      $prj->id='*';
      //$cpt=$prj->countMenuProjectsList();
      $limitToActiveProjects=true;
      if (isset($_SESSION['projectSelectorShowIdle']) and $_SESSION['projectSelectorShowIdle']==1) {
      	$limitToActiveProjects=false;
      }
      $subProjectsToDraw=$prj->drawSubProjects('selectedProject', false, true, $limitToActiveProjects);     
      $cpt=substr_count($subProjectsToDraw,'<tr>');
    ?>
    </div>
  </span>
  <span dojoType="dijit.TooltipDialog" class="white" <?php echo ($cpt>25)?'style="width:200px;"':'';?>>   
    <div <?php echo ($cpt>25)?'style="height: 500px; overflow-y: scroll;"':'';?>>    
    <?php 
      echo $subProjectsToDraw;
    ?>
    </div>       
  </span>
</span>
