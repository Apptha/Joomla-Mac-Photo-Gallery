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
/* No direct acesss */
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.application.component.controller');

if(version_compare(JVERSION,'1.6.0','ge')) {
	$language = JFactory::getLanguage();
	$language->load('com_macgallery', JPATH_COMPONENT_ADMINISTRATOR.DS."language".DS."version6", 'en-GB', true);
}

/* Submenu view */
$view = JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

if ($view == '' || $view == 'cpanel') {
    if ($view == '') $view = 'cpanel';
	JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_CONTROLPANEL'), JRoute::_('index.php?option=com_macgallery'),true);
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_ALBUMS'), JRoute::_('index.php?option=com_macgallery&view=album'));
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_IMAGES'), JRoute::_('index.php?option=com_macgallery&view=images'));
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_GALLERY'), JRoute::_('index.php?option=com_macgallery&view=settings'));
}
else if($view == 'images')
{
     JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_CONTROLPANEL'), JRoute::_('index.php?option=com_macgallery'));
     JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_ALBUMS'), JRoute::_('index.php?option=com_macgallery&view=album'));
	 JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_IMAGES'), JRoute::_('index.php?option=com_macgallery&view=images'),true);
     JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_GALLERY'), JRoute::_('index.php?option=com_macgallery&view=settings'));
}
else if($view == 'settings')
{   JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_CONTROLPANEL'), JRoute::_('index.php?option=com_macgallery'));
JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_ALBUMS'), JRoute::_('index.php?option=com_macgallery&view=album'));
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_IMAGES'), JRoute::_('index.php?option=com_macgallery&view=images'));
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_GALLERY'), JRoute::_('index.php?option=com_macgallery&view=settings'),true);
}
 else if($view == 'album')
{   JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_CONTROLPANEL'), JRoute::_('index.php?option=com_macgallery'));
	JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_ALBUMS'), JRoute::_('index.php?option=com_macgallery&view=album'),true);
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_IMAGES'),  JRoute::_('index.php?option=com_macgallery&view=images'));
    JSubMenuHelper::addEntry(JText::_('COM_CONTUS_MACGALLERY_GALLERY'), JRoute::_('index.php?option=com_macgallery&view=settings'));
}

class MacgalleryController extends JControllerLegacy
{
    /**
     * Method to display the view
     *
     * @access    public
     */
    function display()
    {
        parent::display();
    }

}

?>
