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

jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');


include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_macgallery'.DS.'classes'.DS.'renderAdmin.php');



class MacgalleryViewcpanel extends JViewLegacy
{
    function display($tpl = null)
    {
        JHTML::stylesheet( 'macgallery.css', 'administrator/components/com_macgallery/css/' );
        $uri =& JFactory::getURI();
        $document =& JFactory::getDocument();

        JHTML::_('behavior.tooltip');
        $model = $this->getModel();
        $album = $model->alblist();
        $this->assignRef('album', $album);
        parent::display($tpl);
        $this->_setToolbar();
    }

    /*  set toolbar with image */
    function _setToolbar()
    {
        JToolBarHelper::title( JText::_( 'COM_CONTUS_MACGALLERY_MAC_TITLE' ) );
    }

}
?>