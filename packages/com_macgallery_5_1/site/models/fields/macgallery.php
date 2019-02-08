<?php
// No direct access to this file
defined('_JEXEC') or die;
 

jimport( 'joomla.application.component.helper');
jimport( 'joomla.application.component.model');
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class  MacgalleryModelElement extends JModelLegacy
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Macgallery';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,albumname');
		$query->from('#__macgallery_album');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->id, $message->albumname);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}