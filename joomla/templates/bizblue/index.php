<?php
defined('_JEXEC') or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<!--
author: raduga http://mambasana.ru, http://joomlafabric.com
copyright: GNU/GPL
-->
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/bizblue/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/bizblue/css/<?php echo $this->params->get('width'); ?>.css" type="text/css" />
<?php if($this->params->get('protect')) : ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/bizblue/protect.js"></script>
<?php endif; ?>
</head>

<body id="body_bg">

     <table class="fw"  border="0" align="center" cellpadding="0" cellspacing="0">
         <tr>
               <td width="169"  align="left"  valign="middle">
				
		                 
<div >
<form action="index.php" method="post" class="search"><input name="searchword" id="searchbox" maxlength="20" alt="Search" class="inputbox" type="text" size="20" value="search..."  onblur="if(this.value=='') this.value='search...';" onfocus="if(this.value=='search...') this.value='';" /><input type="hidden" name="option" value="com_search" /><input type="hidden" name="task"   value="search" /><input type="hidden" name="Itemid" value="0" /></form>
</div>
			
                  

                </td>

<td>&nbsp;</td>
                 <td  width="601" align="center" class="topnav" valign="bottom">

                      <?php if($this->countModules('user3') or $this->countModules('position-1') ) : ?>
                    <div>
                      <jdoc:include type="modules" name="user3" />
                      <jdoc:include type="modules" name="position-1" />
                    </div>
                      <?php endif; ?>

                 </td>
         
        </tr>
  </table>  
  <table class="header" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
<td  align="center" class="logoheader">
<?php if($this->params->get('showLOGO')) { ?>
<div id="logo">
<a href="<?php echo JURI::base(); ?>"><img class="iePNG" src="<?php echo $this->baseurl ?>/templates/bizblue/images/logo.gif" alt="<?php echo JText::_('TPL_BIZBLUE_MAIN_PAGE'); ?>" id="imglogo"/></a>
</div>
<?php } ?>
</td>
               
        </tr>
  </table>

  
<table class="header" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
<td class="top1">
<div id="top1">
<div class="pw">
<?php if($this->countModules('breadcrumb') or $this->countModules('position-2') ) : ?>
<jdoc:include type="module" name="breadcrumb" />
<jdoc:include type="modules" name="position-2" />
<?php endif; ?>
</div>
<div class="date"><?php echo JHTML::Date( 'now', 'd | m | Y' ); ?></div>
</div>
</td>
</tr>
</table>
		
<div id="mainconteiner">

<?php 

if ($this->countModules( "top1" )>0) {
							$modwidth = 100;
							}
                                           
if ($this->countModules( "top2" )>0) {
							$modwidth = 100;
							}
if ($this->countModules( "top3" )>0) {
							$modwidth = 100;
							}
if ($this->countModules( "top1" )>0 && $this->countModules( "top2" )>0)  {
							$modwidth = 50;
							}
if ($this->countModules( "top1" )>0 && $this->countModules( "top3" )>0)  {
							$modwidth = 50;
							}
if ($this->countModules( "top2" )>0 && $this->countModules( "top3" )>0)  {
							$modwidth = 50;
							}

if ($this->countModules( "top1" )>0 && $this->countModules( "top2" )>0 && $this->countModules( "top3" )>0)  {
							$modwidth = 33;
							}

							?>


         
<?php if ($this->countModules( "top1" )>0 || $this->countModules( "top2" )>0 || $this->countModules( "top3" )>0) : ?>

<div class="clear"></div>
<div id="topmod">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
 <tr>
<?php if($this->countModules('top1')) : ?> 
                        <td valign="top" width="<?php echo $modwidth; ?>%" >
                        
                        <jdoc:include type="modules" name="top1" style="table"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "top1" )>0 && $this->countModules( "top2" )>0 || $this->countModules( "top1" )>0 && $this->countModules( "top3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('top2')) : ?>
                    <td valign="top" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="top2" style="table"/>
                    
                    </td> 
<?php endif; ?>

<?php if ($this->countModules( "top2" )>0 && $this->countModules( "top3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('top3')) : ?>
                    <td valign="top" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="top3" style="table"/>
                    
                    </td> 
<?php endif; ?>
 </tr>
 </table> 
</div>
<div class="clear" style="border-bottom:1px solid #cccccc;"></div>
                    
<?php endif; ?>


<table class="maincontent"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
                 <?php if($this->countModules('left') or $this->countModules('position-7') ) : ?>
             <td valign="top" class="lcol">
                 <div class="leftrow">
                  	<jdoc:include type="modules" name="left" style="table"/>
                  <jdoc:include type="modules" name="position-7" style="table" />
                 </div>
             </td>
<td class="bgline" ><img  src="<?php echo $this->baseurl ?>/templates/bizblue/images/px.gif" alt="" width="7" border="0"/></td>
    <?php else : ?>
<td class="bgnoleft" ><img  src="<?php echo $this->baseurl ?>/templates/bizblue/images/px.gif" alt="" width="4" border="0"/></td>
<?php endif; ?>                    
            


             <td valign="top"  width="100%" > 
  <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-top: 5px solid #ffffff;">

<?php if ($this->getBuffer('message')) : ?>
<jdoc:include type="message" />
<?php endif; ?>

<?php if($this->countModules('top') or  $this->countModules('newsflashload') ) : ?>
             
          <tr valign="top" >
                   <td colspan="3">
                        <div>
<jdoc:include type="modules" name="top" style="table" />
<jdoc:include type="modules" name="newsflashload" style="table" />
                        </div>
                   </td> 
          </tr>
               <tr><td colspan="3"></td></tr>
<?php endif; ?>



<?php if ($this->countModules( "user1" )>0) {
							$modtopwidth = 100;
							}
                                           
                                          if ($this->countModules( "user2" )>0) {
							$modtopwidth = 100;
							}

                                          if ($this->countModules( "user1" )>0 && $this->countModules( "user2" )>0)  {
							$modtopwidth = 50;
							}

							?>

         
<?php if ($this->countModules( "user1" )>0 || $this->countModules( "user2" )>0) : ?>
 <tr>
<?php if($this->countModules('user1')) : ?> 
                        <td valign="top" width="<?php echo $modtopwidth; ?>%" >
                        
                        <jdoc:include type="modules" name="user1" style="table"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "user1" )>0 && $this->countModules( "user2" )>0) : ?>

                       <td><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('user2')) : ?>
                    <td valign="top" width="<?php echo $modtopwidth; ?>%" >
                    <jdoc:include type="modules" name="user2" style="table"/>
                    </td> 
<?php endif; ?>
 </tr>
                    
                   <tr><td colspan="3"></td></tr>
<?php endif; ?>


<tr align="left" valign="top">
<td colspan="3" style="border-top: 3px solid #ffffff; padding: 3px;">
<div class="main">
<?php if($this->params->get('showComponent')) : ?>
<jdoc:include type="component" />
<?php endif; ?>
</div>
</td>
          
</tr>

<?php if($this->countModules('bottom')) : ?>
                      <tr>
                      <td colspan="3" valign="top" style="padding-top: 3px;"> 

                      <div>
                      <jdoc:include type="modules" name="bottom" style="table"/>
                      </div>

                      </td>
                      </tr>
<?php endif; ?> 

<?php if($this->countModules('bannersload')) : ?>
                      <tr>
                      <td colspan="3" valign="top" style="padding:10px 0;text-align: center;"> 
                      <div align="center">
                      <jdoc:include type="modules" name="bannersload" style="raw"/>
                      </div>
                      </td>
                      </tr>
<?php endif; ?>


  </table>
  
  </td>

                     
<?php if ($this->countModules('right') or $this->countModules('position-3') or $this->countModules('position-4')) : ?>
<td class="bgline" ><img  src="<?php echo $this->baseurl ?>/templates/bizblue/images/px.gif" alt="" width="7" border="0"/></td>
<td valign="top" class="rcol"> 
                  <div class="rightrow">
<jdoc:include type="modules" name="right" style="table"/>
<jdoc:include type="modules" name="position-3" style="table"/>
<jdoc:include type="modules" name="position-4" style="table"/>
                  </div>
                  </td>
<?php else : ?>
<td class="bgnoright" ><img  src="<?php echo $this->baseurl ?>/templates/bizblue/images/px.gif" alt="" width="4" border="0"/></td>
<?php endif; ?> 
       </tr>
</table> 



<?php 

if ($this->countModules( "bottom1" )>0) {
							$modwidth = 100;
							}
                                           
if ($this->countModules( "bottom2" )>0) {
							$modwidth = 100;
							}
if ($this->countModules( "bottom3" )>0) {
							$modwidth = 100;
							}
if ($this->countModules( "bottom1" )>0 && $this->countModules( "bottom2" )>0)  {
							$modwidth = 50;
							}
if ($this->countModules( "bottom1" )>0 && $this->countModules( "bottom3" )>0)  {
							$modwidth = 50;
							}
if ($this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0)  {
							$modwidth = 50;
							}

if ($this->countModules( "bottom1" )>0 && $this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0)  {
							$modwidth = 33;
							}

							?>

         
<?php if ($this->countModules( "bottom1" )>0 || $this->countModules( "bottom2" )>0 || $this->countModules( "bottom3" )>0) : ?>

<div class="clear" style="border-top:1px solid #cccccc;"></div>

<div id="botmod">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
 <tr>
<?php if($this->countModules('bottom1')) : ?> 
                        <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                        
                        <jdoc:include type="modules" name="bottom1" style="table"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "bottom1" )>0 && $this->countModules( "bottom2" )>0 || $this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('bottom2')) : ?>
                    <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="bottom2" style="table"/>
                    
                    </td> 
<?php endif; ?>

<?php if ($this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('bottom3')) : ?>
                    <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="bottom3" style="table"/>
                    
                    </td> 
<?php endif; ?>
 </tr>
 </table> 
 </div>


</div>
                   
<div class="clear"></div>
        
<table class="foot"  align="center" border="0" cellspacing="0" cellpadding="0" width="95%">
<?php else : ?>
</div>
<table class="foot" align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
<?php endif; ?>
                <tr>



                                     <td  width="100%"  align="center" class="footer" >
<?php if($this->countModules('footertext')) : ?>
<div id="footertext"><jdoc:include type="modules" name="footertext" /></div>
<?php endif; ?>

<?php 
echo"<p>
".JText::_('TPL_BIZBLUE_ALL_RIGHTS_RESERVED').' &#169; '. JHTML::Date( 'now', 'Y' ) ." <br />
designed by <a href='http://mambasana.ru'>mambasana.ru</a>
</p>";
?>                                             
                                     </td>

               </tr>
</table> 
    
  
</body>
</html>