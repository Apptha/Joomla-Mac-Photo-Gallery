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

jimport( 'joomla.application.component.view');

class MacgalleryViewimages extends JViewLegacy
{

    function display()
    {
        JHTML::stylesheet( 'macgallery.css', 'administrator/components/com_macgallery/css/' );

        if(JRequest::getVar('task') == 'edit' )
        {
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_IMAGES').': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_EDIT').' </small> ]', 'images');
            JToolBarHelper::save("saveclose");
            JToolBarHelper::apply();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $id=JRequest::getVar('cid');
            $images = $model->getimages($id[0]);
            $this->assignRef('images', $images);
            parent::display();
        }

        if(JRequest::getVar('task') == 'add' )
        {
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_IMAGES').': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_ADD').' </small> ]', 'images');
            JToolBarHelper::save();
            JToolBarHelper::save("savenew","Save &amp; new");
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $images = $model->getNewimages();
            $this->assignRef('images', $images);
            
            
            $settings = $model->getsettings();
            
            $this->assignRef('settings', $settings);
            parent::display();
        }

        if(JRequest::getVar('task') == '' )
        {
            JToolBarHelper::title( JText::_( 'COM_CONTUS_MACGALLERY_IMAGES' ).': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_LIST').' </small> ]', 'images' );
            JToolBarHelper::custom("regenrate", "move.png","",JText::_('COM_MACGALLERY_CONTROLLERS_REGENRATE_IMAGE'),false);
            JToolBarHelper::publishList();
            JToolBarHelper::unpublishList();
            JToolBarHelper::deleteList(JText::_('COM_MACGALLERY_ARE_YOU_SURE')."?");
            JToolBarHelper::editList();
            JToolBarHelper::addNew();
            $model = $this->getModel();
            if(JRequest::getVar('set')!= '')
            {
                $set=$model->setImage();
                $this->assignRef('set', $set);
            }
            
            $images = $model->getimage();

            
			
            $this->assignRef('images', $images);
            parent::display();
        }

    }
}

?>
