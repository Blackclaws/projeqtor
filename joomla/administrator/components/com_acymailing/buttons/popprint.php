<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class JButtonPopprint extends JButton
{
	var $_name = 'Pophelp';
	function fetchButton( $type='Popprint', $namekey = '', $id = 'Popprint' )
	{
		JHTML::_('behavior.modal');
		?>
		<script>
		function getURL(href){
					chartType = new Array('columnchart', 'linechart');
					for(var i=0; i < chartType.length; i++){
						var newType = window.parent.document.getElementById('display_chart_'+chartType[i]).checked;
						if(newType){
										displayType = window.parent.document.getElementById('display_chart_'+chartType[i]).value;
						}
					}
					datemin = window.parent.document.getElementById('display_datemin').value;
					datemax = window.parent.document.getElementById('display_datemax').value;
					intervalType = new Array('day', 'month', 'year');
					for(var i=0; i < intervalType.length; i++){
						var newType = window.parent.document.getElementById('display_interval_'+intervalType[i]).checked;
						if(newType){
										interval = window.parent.document.getElementById('display_interval_'+intervalType[i]).value;
						}
					}
					href = href+ '&display[datemin]='+datemin+ '&display[datemax]='+datemax+ '&display[interval]='+interval+ '&display[charttype]='+displayType;
					if(window.parent.document.getElementById('compares_lists').checked){ href = href+'&compares[lists]=lists'; }
					if(window.parent.document.getElementById('compares_years').checked){ href = href+'&compares[years]=years'; }
					return (href);
		}
		</script>
		<?php
		return '<a href="index.php?option=com_acymailing&ctrl=diagram&task=printnewsletter&tmpl=component" target="_blank" class="modal" rel="{handler: \'iframe\', size: {x: 800, y: 590}}" ' .
				'onclick="this.href=getURL(this.href);SqueezeBox.fromElement(this,{parse: \'rel\'});" class="toolbar"><span class="icon-32-acyprint" title="'.JText::_('ACY_PRINT',true).'"></span>'.JText::_('ACY_PRINT').'</a>';
	}
	function fetchId( $type='Pophelp', $html = '', $id = 'pophelp' )
	{
		return $this->_name.'-'.$id;
	}
}