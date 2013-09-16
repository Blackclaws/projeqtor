<?php
defined('_JEXEC') or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/bizglobal/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/bizglobal/css/<?php echo $this->params->get('color'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/bizglobal/css/<?php echo $this->params->get('width'); ?>.css"
type="text/css" />

<?php if($this->params->get('protect')) : ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/bizglobal/protect.js"></script>
<?php endif; ?>

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/bizglobal/ie_suckerfish.js"></script>
</head>

<body id="body_bg">

<div id="headerconteiner">

<div id="logoheader">


<div id="logo">
<?php if($this->params->get('showLOGO')) { ?>
<a href="<?php echo JURI::base(); ?>"><img src="<?php echo $this->baseurl ?>/templates/bizglobal/images/px.gif" alt="<?php echo JText::_('TPL_BIZGLOBAL_MAIN_PAGE'); ?>" height="54" id="imglogo" align="left"/></a>
 <?php } ?>
<?php if($this->countModules('headerinfo')) : ?>
<div id="headermod">
<div>
<jdoc:include type="modules" name="headerinfo"/>
</div>
</div>
<?php endif; ?>

</div>

<?php if($this->params->get('showSEARCH')) { ?>
<div id="srch">
<form action="index.php" method="post" class="search"><input name="searchword" id="searchbox" maxlength="20" class="inputbox" type="text" size="20" value="<?php echo JText::_('TPL_BIZGLOBAL_SEARCHTEXT'); ?>..."  onblur="if(this.value=='') this.value='<?php echo JText::_('TPL_BIZGLOBAL_SEARCHTEXT'); ?>...';" onfocus="if(this.value=='<?php echo JText::_('TPL_BIZGLOBAL_SEARCHTEXT'); ?>...') this.value='';" /><input type="hidden" name="option" value="com_search" /><input type="hidden" name="task"   value="<?php echo JText::_('TPL_BIZGLOBAL_SEARCHTEXT'); ?>" /><input type="hidden" name="Itemid" value="0" /></form>
</div>
<?php } ?>

</div>

<div id="nav">
<?php if($this->countModules('user3') or $this->countModules('position-1') ) : ?>
                    
                      <jdoc:include type="modules" name="user3" />
                      <jdoc:include type="modules" name="position-1" />
                    
                      <?php endif; ?>
</div>
<div id="navborder"></div>
</div>


  

		
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
                        
                        <jdoc:include type="modules" name="top1" style="global"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "top1" )>0 && $this->countModules( "top2" )>0 || $this->countModules( "top1" )>0 && $this->countModules( "top3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('top2')) : ?>
                    <td valign="top" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="top2" style="global"/>
                    
                    </td> 
<?php endif; ?>

<?php if ($this->countModules( "top2" )>0 && $this->countModules( "top3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('top3')) : ?>
                    <td valign="top" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="top3" style="global"/>
                    
                    </td> 
<?php endif; ?>
 </tr>
 </table> 
</div>

                    
<?php endif; ?>


<div class="clear"></div>

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
<div class="date"><?php echo JHTML::Date( 'now', 'd - m - Y' ); ?></div>
</div>
</td>
</tr>
</table>




<table class="maincontent"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
                 <?php if($this->countModules('left') or $this->countModules('position-7') ) : ?>
             <td valign="top" class="lcol">
                 <div class="leftrow">
                  	<jdoc:include type="modules" name="left" style="global"/>
                  <jdoc:include type="modules" name="position-7" style="global" />
                 </div>
             </td>
<td class="bgl" ><img  src="<?php echo $this->baseurl ?>/templates/bizglobal/images/px.gif" alt="" width="7" border="0"/></td>
    <?php else : ?>
<td class="bgnoleft" ><img  src="<?php echo $this->baseurl ?>/templates/bizglobal/images/px.gif" alt="" width="7" border="0"/></td>
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
<jdoc:include type="modules" name="top" style="global" />
<jdoc:include type="modules" name="newsflashload" style="global" />
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
                        
                        <jdoc:include type="modules" name="user1" style="global"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "user1" )>0 && $this->countModules( "user2" )>0) : ?>

                       <td><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('user2')) : ?>
                    <td valign="top" width="<?php echo $modtopwidth; ?>%" >
                    <jdoc:include type="modules" name="user2" style="global"/>
                    </td> 
<?php endif; ?>
 </tr>
                    
                   <tr><td colspan="3"></td></tr>
<?php endif; ?>


<tr align="left" valign="top">
<td colspan="3" style="border-top: 3px solid #ffffff; padding: 3px;">
<div class="main">

<jdoc:include type="component" />

</div>
</td>
          
</tr>

<?php if($this->countModules('bottom')) : ?>
                      <tr>
                      <td colspan="3" valign="top" style="padding-top: 3px;"> 

                      <div>
                      <jdoc:include type="modules" name="bottom" style="global"/>
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
<td class="bgl" ><img  src="<?php echo $this->baseurl ?>/templates/bizglobal/images/px.gif" alt="" width="7" border="0"/></td>
<td valign="top" class="rcol"> 
                  <div class="rightrow">
<jdoc:include type="modules" name="right" style="global"/>
<jdoc:include type="modules" name="position-3" style="global"/>
<jdoc:include type="modules" name="position-4" style="global"/>
                  </div>
                  </td>
<?php else : ?>
<td class="bgnoright" ><img  src="<?php echo $this->baseurl ?>/templates/bizglobal/images/px.gif" alt="" width="7" border="0"/></td>
<?php endif; ?> 
       </tr>
</table> 
<div class="clear" style="border-top:1px solid #cccccc;"></div>


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



<div id="botmod">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
 <tr>
<?php if($this->countModules('bottom1')) : ?> 
                        <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                        
                        <jdoc:include type="modules" name="bottom1" style="global"/>
                        
                        </td>
<?php endif; ?>

<?php if ($this->countModules( "bottom1" )>0 && $this->countModules( "bottom2" )>0 || $this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('bottom2')) : ?>
                    <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="bottom2" style="global"/>
                    
                    </td> 
<?php endif; ?>

<?php if ($this->countModules( "bottom2" )>0 && $this->countModules( "bottom3" )>0) : ?>

                       <td class="tm"><div class="mod"></div></td> 
<?php endif; ?>

<?php if($this->countModules('bottom3')) : ?>
                    <td valign="top" class="contentmod" width="<?php echo $modwidth; ?>%" >
                    
                    <jdoc:include type="modules" name="bottom3" style="global"/>
                    
                    </td> 
<?php endif; ?>
 </tr>
 </table> 
 </div>


</div>
                   
<div class="clear"></div>
        
<table class="foot"  align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
<?php else : ?>
</div>
<table class="foot" align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
<?php endif; ?>
                <tr>



                                     <td  width="100%"  align="center" class="footer" >
<?php if($this->countModules('footertext')) : ?>
<div id="footertext"><jdoc:include type="modules" name="footertext" /></div>
<?php endif; ?>

<?php 
echo"<p>
".JText::_('TPL_BIZGLOBAL_ALL_RIGHTS_RESERVED').' &#169; '. JHTML::Date( 'now', 'Y' ) ."<br />

</p>";
?> 
<a href="http://mambasana.ru/" target="_blank" title="design by mambasana.ru"><img  src="<?php echo $this->baseurl ?>/templates/bizglobal/images/mambasana.gif" alt="design by mambasana.ru" width="20" border="0"/></a>                                            
                                     </td>

               </tr>
</table> 
    
  
</body>
</html>