<?php
/**
 * @version		$Id: modules.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;


/*
 * Module chrome that wraps the module in a table
 */
function modChrome_global($module, &$params, &$attribs)
{ ?>
	<table cellpadding="0" cellspacing="0" class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
	<?php if ($module->showtitle != 0) : ?>
		<tr>
			<th>
				<span><?php echo $module->title; ?></span>
			</th>
		</tr>
	<?php endif; ?>
		<tr>
			<td>
				<?php echo $module->content; ?>
			</td>
		</tr>
		</table>
	<?php
}

?>
