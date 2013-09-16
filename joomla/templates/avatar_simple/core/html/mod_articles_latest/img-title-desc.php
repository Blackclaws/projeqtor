<?php
/**
 * @version		$Id: coolfeed.php 100 2012-04-14 17:42:51Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 * @package		Avatar Dream Framework Template
 * @facebook 	http://www.facebook.com/pages/JoomAvatar/120705031368683
 * @twitter	    https://twitter.com/#!/JoomAvatar
 * @support 	http://joomavatar.com/forum/
 */

// No direct access
defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
	
	<li>
		<div class="row">
			<?php 
				if ($item->images != '') { 
				$images = json_decode($item->images);
			?>
			<div class="span1">
				
			</div>
			<?php } ?>
			<div>
				<h3>
					<a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
				</h3>
				<div><?php echo $item->introtext; ?></div>		
			</div>
		</div>
		
	</li>
<?php endforeach; ?>
</ul>
