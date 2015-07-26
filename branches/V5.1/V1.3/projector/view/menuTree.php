<?php
/* ============================================================================
 * Presents left menu of application. 
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/menuTree.php');
  $menuNextIsFirst=true; // is next element fisrt of a group
  $level=0;
  $menuLevel=array('0'=>'0');
  /** ==========================================================================
   * Draw an tree item to present a menu
   * @param $menu the name of menu
   * @param $type the type : 'menu', 'item' or 'object'
   * @param $hasChildren boolean wether the menu has sub-menu or not
   * @param $icon name of icon class, if different from name
   * @param $force boolean to force display, not depending on security check
   * @return void
   */
  function drawMenuItem($idMenu,$menuName,$type,$hasChildren=false,$force=false, $class=null) {
    global  $paramIconSize, $menuNextIsFirst, $level, $menuLevel;
    $menu=substr($menuName,4);
    if (securityCheckDisplayMenu($idMenu,$menu) or $force) {
      if (! $menuNextIsFirst) {
        echo ", \n";
      }
      //echo $level;
      $name=ucfirst($menu);
      if ($class) {
        $icon=$class;
      } else {
        $icon=$name;
      }
      echo substr('          ',0,$level*2);
      echo '{ id:"' . $name . '", name:"' . i18n('menu'.$menu) . '"';
      echo ', "type":"' . $type . '" , iconClass:"icon' . $icon .  $paramIconSize . '"'; 
      if ($class and $type=='class') {
        echo ', "objectClass":"' . $class . '"';
      }
      if ($hasChildren) {
        echo ", children: [\n";
        $menuNextIsFirst=true;
        $level+=1;
        $menuLevel[$level]=$idMenu;
      } else {
       echo '}';
        $menuNextIsFirst=false;
      }
    }
 }  
 
 /** ==========================================================================
  * Draw all menu and sub-menu for an object class
  * @param $class the class
  * @return void
  */
  function drawMenuItemClass($idMenu, $menuName) {
    $class=substr($menuName,4);
    global  $paramIconSize, $menuTree;
    if (securityCheckDisplayMenu($idMenu, $class)) {
     drawMenuItem($idMenu,$class, 'menu', true);
     drawMenuItem($idMenu, 'All' . $class, 'class', false, true, $class); 
     //drawMenuCloseChildren($idMenu);
    }
  }  
 
 /** ==========================================================================
  * Draw the closing of sub-menu list
  * @param $menu the menu name (just for scurity check to validate visibility)
  * @return void
  */
  function drawMenuCloseChildren() {
    global  $menuNextIsFirst, $level, $menuLevel;
    echo " ] } ";
    unset($menuLevel[$level]); 
    $level-=1;
    $menuNextIsFirst=false;
  }
?>

<?php if ( ! $testMode) {?>
<script>
<?php }?>
var menuData = {
"identifier": "id",
"label": "name",
"items": [
<?php  
  $obj=new Menu();
  $menuList=$obj->getSqlElementsFromCriteria(null, false);
  $idMenu=null;
  $prioMenuType=null;
  foreach ($menuList as $menu) {
    //echo "id=" . $menu->id . "     idMenu=" . $menu->idMenu . "     level=" . $level . "\n";
    if ($level>0 and securityCheckDisplayMenu($menu->id,$menu) ) {
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
  }
  ?>
]
};

<?php if ( ! $testMode) {?>
var menuStore = new dojo.data.ItemFileReadStore({data: menuData});
</script>

<div dojoType="dijit.tree.ForestStoreModel" jsId="menuModel" 
     store="menuStore" query="{type:'*'}" rootId="Projector" rootLabel="Projector Menu">
</div>

<div class="container" dojoType="dijit.layout.BorderContainer" >
  <div dojoType="dijit.layout.ContentPane" region="top" style="height: 30px; overflow: hidden;">
    <table><tr>
    <td class="titleProject"><?php echo (i18n("projectSelector"));?></td>
    <td>
    <span style="height: 30px; " dojoType="dijit.form.DropDownButton" 
     id="selectedProject" jsId="selectedProject" name="selectedProject" showlabel="true">
      <span width="200px"><?php
        $proj='*'; 
        if (array_key_exists('project',$_SESSION)) {
          $proj=$_SESSION['project'];
        }
        if ($proj=='*') {
          echo '<i>' . i18n('allProjects') . '</i>';
        } else {
          $projObject=new Project($proj);
          echo htmlEncode($projObject->name);
        };
        ?>
      </span>
      <span dojoType="dijit.TooltipDialog" class="white">
        <table><tr><td>
         <?php 
           $prj=new Project();
           $prj->id='*';
           echo $prj->drawSubProjects('selectedProject', false, true, true); 
         ?>
        </td></tr></table>
      </span>
    </span>
    </td></tr></table>
  </div>
  <div dojoType="dijit.layout.ContentPane" region="center" >
    <div dojoType="dijit.Tree" id="menuTree" jsId="menuTree" model="menuModel"
     labelAttr="name" typeAttr="menu" showRoot="false" openOnClick="true">
      <script type="dojo/method" event="onClick" args="item">
    if (checkFormChangeInProgress()) {
         return false;
    }
    if (item.id=='Today') {
	   cleanContent("detailDiv");
	   loadContent("today.php","centerDiv");
       formChangeInProgress=false;    
    } else if (item.id=='Planning') {
	   cleanContent("detailDiv");
	   loadContent("planningMain.php","centerDiv");
       formChangeInProgress=false;   
    } else if (item.id=='Imputation') {
       cleanContent("detailDiv");
       loadContent("imputationMain.php","centerDiv");
       formChangeInProgress=false;     
    } else if (item.id=='ImportData') {
       cleanContent("detailDiv");
       loadContent("importData.php","centerDiv");
       formChangeInProgress=false;     
    } else if (item.id=='Reports') {
       cleanContent("detailDiv");
       loadContent("reportsMain.php","centerDiv");
       formChangeInProgress=false;  
    } else if (item.type=='object') {
      cleanContent("detailDiv");
	  formChangeInProgress=false;
	  loadContent("objectMain.php?objectClass="+item.id,"centerDiv");
    } else if (item.type=='class') {
      cleanContent("detailDiv");
	  formChangeInProgress=false;
	  loadContent("objectMain.php?objectClass="+item.objectClass,"centerDiv");
	} else if (item.type=='menu') {
       // Nothing
	} else if(item.id=='UserParameter') {
	   cleanContent("detailDiv");
	   loadContent("parameter.php?type=userParameter","centerDiv");
     formChangeInProgress=false;
	} else if(item.id=='ProjectParameter') {
	   cleanContent("detailDiv");
	   loadContent("parameter.php?type=projectParameter","centerDiv");
     formChangeInProgress=false;
	} else if(item.id=='GlobalParameter') {
	   cleanContent("detailDiv");
	   loadContent("parameter.php?type=globalParameter","centerDiv");
     formChangeInProgress=false;
	} else if(item.id=='Habilitation') {
	   cleanContent("detailDiv");
	   loadContent("parameter.php?type=habilitation","centerDiv");
     formChangeInProgress=false;
  } else if(item.id=='HabilitationReport') {
     cleanContent("detailDiv");
     loadContent("parameter.php?type=habilitationReport","centerDiv");
     formChangeInProgress=false;
  } else if(item.id=='HabilitationOther') {
     cleanContent("detailDiv");
     loadContent("parameter.php?type=habilitationOther","centerDiv");
       formChangeInProgress=false;
	} else if(item.id=='AccessRight') {
	   cleanContent("detailDiv");
	   loadContent("parameter.php?type=accessRight","centerDiv");
     formChangeInProgress=false;    
    } else {
	   showInfo(i18n("messageSelectedNotAvailable", new Array(item.name)));
	}
      </script>
      <script type="dojo/method" event="getIconClass" args="item, opened">
    if (item == this.model.root) {
      return "checkBox";
    } else {
      return menuStore.getValue(item, "iconClass");
    }
      </script>
    </div>
  </div>
</div>
<?php }?>