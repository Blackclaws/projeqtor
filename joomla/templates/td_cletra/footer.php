<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

global $_VERSION;
require_once('libraries/joomla/utilities/date.php');
$date  = new JDate();
$config = new JConfig();
// NOTE - You may change this file to suit your site needs
if (0) {
?>
Copyright &copy; <?php echo $date->toFormat( '2005 - %Y' ) . ' ' . $config->sitename;?>. <br />
Designed by <a href="http://www.joomlatd.com/" title="Visit joomlatd.com!" target="blank">joomlatd.com</a>
<br />
<!-- <?php echo $_VERSION->URL; ?>  -->
<?php } ?>