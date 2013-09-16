<?php

defined('_JEXEC') or die('Restricted access');

function modChrome_j51_module($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($module->showtitle) : ?>
			
				<?php
					$title = explode(' ', $module->title);
					$title_part1 = array_shift($title);
					$title_part2 = join(' ', $title);
				?>
			
				<h3><span><span class="first-word"><?php echo $title_part1.' '; ?></span><?php echo $title_part2; ?></span></h3>
			<?php endif; ?>
			<div class="module_content">
			<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}	

?>