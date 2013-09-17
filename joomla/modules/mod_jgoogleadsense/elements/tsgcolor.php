<?php
defined('JPATH_BASE') or die;
jimport('joomla.form.formfield');
class JFormFieldTsgcolor extends JFormField
{
	protected $type = 'tsgcolor';
	protected function getInput()
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . 'modules/mod_jgoogleadsense/js/jscolor.js');
		$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$maxLength	= $this->element['maxlength'] ? ' maxlength="'.(int) $this->element['maxlength'].'"' : '';
		$id			= $this->element['id'] ? ' id="'.(string) $this->element['id'].'"' : '';
		$previewid	= $this->element['previewid'] ? ' id="'.(string) $this->element['previewid'].'"' : '';
		$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
		$html = array();
		$class = $this->element['class'] ? (string) $this->element['class'] : 'color';
		$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
        $background = ' style="background-color: '.$value.'"';
		return '<input type="text" name="'.$this->name.'" id="'.$this->id.'" '.$background.' class="'.$class.'" value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'">';
	}
}