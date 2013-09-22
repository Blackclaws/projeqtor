<?php
/* ============================================================================
 * Presents left menu of application. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/menuBar.php');
 
  if ( ! $showTopMenu) {return;}
  
  function drawMenu($menu) {
    $menuName=$menu->name;
    $idMenu=$menu->id;
    if ($menu->type=='menu') {
    	if ($menu->idMenu==0) {
    		echo '<td class="menuBarSeparator" style="width:5px;"></td>';
    	}
    } else if ($menu->type=='item') {
    	  $class=substr($menuName,4); 
        echo '<td class="menuBarItem" title="' .i18n($menu->name) . '">';
        echo '<img src="../view/css/images/icon' . $class . '16.png" onClick="loadMenuBarItem(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\');" />';
        echo '</td><td>&nbsp;</td>';    	
    } else if ($menu->type=='object') { 
      $class=substr($menuName,4);
      if (securityCheckDisplayMenu($idMenu, $class)) {
      	echo '<td class="menuBarItem" title="' .i18n('menu'.$class) . '">';
      	echo '<img src="../view/css/images/icon' . $class . '16.png" onClick="loadMenuBarObject(\'' . $class .  '\',\'' . htmlEncode(i18n($menu->name),'quotes') . '\');" />';
      	echo '</td><td>&nbsp;</td>';
      }
    }
  }  
  
  function drawAllMenus() {
  	//echo '<td class="menuBarSeparator"></td>';
    $obj=new Menu();
    $suspend=false;
    $menuList=$obj->getSqlElementsFromCriteria(null, false);
    $lastType='';
    foreach ($menuList as $menu) { 
    	if ($menu->id==36) {$suspend=true;}
    	if (! $suspend and securityCheckDisplayMenu($menu->id,$menu) ) {
    		drawMenu($menu);
    		$lastType=$menu->type;
    	}
    }
    if ($lastType!='menu') {
      echo '<td class="menuBarSeparator" ></td>';
    }
    $menu=new Menu('20');
    drawMenu($menu);
    echo '<td class="menuBarSeparator" ></td>';
	/*	    if ($level>0 and securityCheckDisplayMenu($menu->id,$menu) ) {
		      while ($level>0 and $menu->idMenu!= $menuLevel[$level]) {
		        drawMenuCloseChildren();
		      }
		    }
	    if ($menu->type=='class') {
	      drawMenuItemClass($menu->id,$menu->name);
	    } else if ($menu->type=='menu') {
	      drawMenuItem($menu->id,$menu->name,'menu', true);
	    } else if ($menu->type=='item') {
	      drawMenuItem($menu->id,$menu->name,'item', false);
	    } else if ($menu->type=='object') {
	      drawMenuItem($menu->id,$menu->name,'object', false);
	    } 
	  }
	  while ($level>0) {
	    drawMenuCloseChildren();
	  }*/
  }
?>
  <table width="100%"><tr>
    
    <td width="285px">
    <div class="titleProject" class="titleProject" style="position: absolute; left:0px; top: 0px;width:75px; text-align:right;">&nbsp;<?php echo (i18n("projectSelector"));?>&nbsp;:&nbsp;</div>
    <span maxsize="180px" style="position: absolute; left:75px; top:1px; height: 20px; width: 160px; color:#202020;" dojoType="dijit.form.DropDownButton" 
     id="selectedProject" jsId="selectedProject" name="selectedProject" showlabel="true" class="">
      <span style="width:180px; text-align: left;">
      <div style="width:180px; overflow: hidden; text-align: left;" ><?php
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
        $subProjectsToDraw=$prj->drawSubProjects('selectedProject', false, true, true);     
        $cpt=substr_count($subProjectsToDraw,'<tr>');
        ?>
      </div>
      </span>
      <span dojoType="dijit.TooltipDialog" class="white" <?php echo ($cpt>25)?'style="width:200px;"':'';?>>   
        <div <?php echo ($cpt>25)?'style="height: 500px; overflow-y: scroll;"':'';?>>    
         <?php 
           $prj=new Project();
           $prj->id='*';
           echo $subProjectsToDraw;
         ?>
        </div>       
      </span>
    </span>
    </td>
    <td width="3px"></td>
    <td class="menuBarSeparator" ></td>
    <td width="8px">
      <button id="menuBarMoveLeft" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('menuBarMoveLeft');?>"
       iconClass="leftBarIcon" 
       style="position:relative; left: -6px; width: 14px;margin:0">
       <script type="dojo/connect" event="onClick" args="evt">
          moveMenuBar('left');
        </script>
      </button>    
    </td>
    <td class="menuBarSeparator" ></td>
    <td >
    <div id="menuBarVisibleDiv" style="width: <?php 
      if (array_key_exists('screenWidth',$_SESSION)) {
         $width = $_SESSION['screenWidth'] - 400;
         echo $width . 'px';
      } else {
      	echo '100%';
      }
    ?>; position: absolute; top: 0px; left: 320px; z-index:0">
      <div style="width: 100%; height:30px; position: absolute; left: 0px; top:0px; overflow:hidden; z-index:0">
	    <div name="menubarContainer" id="menubarContainer" style="width: 2000px; position: absolute; left:0px; overflow:hidden;z-index:0">
	      <table><tr>
	    <?php drawAllMenus();?>
	    </tr></table>
	    </div>
      </div>
    </div>
    </td> 
    <td width="80px" align="center" class="statusBar" style="position:relative;z-index:30;">
      <div style="height:22px; position: absolute; top : -2px; margin:0; padding 0;z-index:35;" class="menuBarSeparator" ></div>
      &nbsp;
      <button id="menuBarMoveRight" dojoType="dijit.form.Button" showlabel="false" 
       title="<?php echo i18n('menuBarMoveRight');?>"
       iconClass="rightBarIcon" 
       style="position:absolute; right: 63px; top:2px; width: 14px;margin:0; z-index:35">
       <script type="dojo/connect" event="onClick" args="evt">
          moveMenuBar('right');
        </script>
      </button>   
      <div style="height:22px; position: absolute; top : -2px; right: 48px;margin:0; padding 0;z-index:35;" class="menuBarSeparator" ></div>
      <button id="menuBarUndoButton" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('buttonUndoItem');?>"
       disabled="disabled"
       style="position:relative;left: 12px; z-index:30"
       iconClass="dijitEditorIcon dijitEditorIconUndo" >
        <script type="dojo/connect" event="onClick" args="evt">
          undoItemButton();
        </script>
      </button>    
      <button id="menuBarRedoButton" dojoType="dijit.form.Button" showlabel="false"
       title="<?php echo i18n('buttonRedoItem');?>"
       disabled="disabled"
       style="position:relative;left: 6px; z-index:30"
       iconClass="dijitEditorIcon dijitEditorIconRedo" >
        <script type="dojo/connect" event="onClick" args="evt">
          redoItemButton();
        </script>
      </button>    
    </td>
  </tr></table>