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

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class MacgalleryViewsettings extends JViewLegacy
{

    function display()
    {
        JHTML::stylesheet( 'macgallery.css', 'administrator/components/com_macgallery/css/' );

        if(JRequest::getVar('task') == 'edit' )
        {

            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_GALLERY').': [ <small>'.JText::_('COM_CONTUS_MACGALLERY_LIST').'</small> ]', 'settings');
            JToolBarHelper::save();
            JToolBarHelper::apply();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $id = JRequest::getVar('cid');
            if($id[0] == ''){
                $id[0] = 1;
            }
            $settings = $model->getsetting($id[0]);
            $this->assignRef('settings', $settings);
            parent::display();

        }

        if(JRequest::getVar('task') == '' )
        {
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_GALLERY').': [ <small>'.JText::_('COM_CONTUS_MACGALLERY_LIST').'</small> ]', 'settings');
            JToolBarHelper::editList();
            $model = $this->getModel();
            $settings = $model->getsettings();
            $this->assignRef('settings', $settings);
            parent::display();
        }
    }
}
?>
