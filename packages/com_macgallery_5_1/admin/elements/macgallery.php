<?php
/*
 ***********************************************************

 * Component Name: Mac-Dock Gallery
 * Description: Mac dock photo gallery component for Joomla 3.0
 * Version: 1.5
 * Edited By: Sameera
 * Author URI: http://www.apptha.com/
 * Date : Nov 20 2012

 **********************************************************

 @Copyright Copyright (C) 2010-2012 Contus Support
 @license GGNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

 **********************************************************/
defined('JPATH_BASE') or die;


/**
 * Supports a modal article picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class  JElementMacgallery extends JElement
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.5
	 */
	protected $type = 'Macgallery';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.5
	 */
	function fetchElement($name, $value, &$node, $control_name)
	{
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');
		
		// Build the script.
		$script = array();
		$script[] = '	function jSelectArticle(id, title, catid, object) {';
			
		$script[] = "document.getElementById('id_id').value = id";
		$script[] = " document.getElementById('id_name').value = title";
		$script[] = "document.getElementById('sbox-window').close();";
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


		// Setup variables for display.
		$html	= array();
		$link	= 'index.php?option=com_macgallery&view=album&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle';

		$db	= JFactory::getDBO();
		$db->setQuery(
			'SELECT albumname ' .
			' FROM #__macgallery_album' .
			' WHERE id = "'.(int) $value.'" '
		);

		$title = $db->loadResult();
                
		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}

		if (empty($title)) {
			$title = JText::_('Select a album');
		}
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		// The current user display field.
		$html[] = '<div style="float: left;">';
		$html[] = '  <input type="text" id="id_name" value="'.$title.'" disabled="disabled" size="35" />';
		$html[] = '</div>';

		// The user select button.
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a class="modal" title="'.JText::_('Select a album').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">Select a album</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		// The active article id field.
		if (0 == (int)$value) {
			$value = '';
		} else {
			$value = (int)$value;
		}

		// class='required' for client side validation
		$class = '';
		if ($node->_attributes["required"]) {
			$class = ' class="required modal-value"';
		}

		$html[] = '<input type="hidden" id="id_id"'.$class.' name="params['.$name.']" value="'.$value.'" />';

		return implode("\n", $html);
	}
}
