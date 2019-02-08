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
jimport('joomla.html.pane');
/* View for album administrator controls*/
class MacgalleryViewalbum extends JViewLegacy
{
    function display()
    {

        JHTML::stylesheet( 'macgallery.css', 'administrator/components/com_macgallery/css/' );
        if(JRequest::getVar('task') == 'edit' ){
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_ALBUMS').': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_EDIT').' </small> ]', 'albums');
            JToolBarHelper::save();
            JToolBarHelper::apply();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $id=JRequest::getVar('cid');
            $album = $model->getalbums($id[0]);
            $this->assignRef('album', $album);
            parent::display();
        }
        
        if(JRequest::getVar('task') == 'add'){
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_ALBUMS').': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_ADD').' </small> ]', 'albums');
            JToolBarHelper::save();
            JToolBarHelper::cancel();
            $model = $this->getModel();
            $album = $model->getNewalbum();
            parent::display();
        }

        if(JRequest::getVar('task') == '' || JRequest::getVar('task') == 'display'){
            JToolBarHelper::title(JText::_('COM_CONTUS_MACGALLERY_ALBUMS').': [ <small> '.JText::_('COM_CONTUS_MACGALLERY_LIST').' </small> ]', 'albums');
            JToolBarHelper::publishList();
            JToolBarHelper::unpublishList();
            JToolBarHelper::deleteList(JText::_('COM_MACGALLERY_ARE_YOU_SURE')."?");
            JToolBarHelper::editList();
            JToolBarHelper::addNew();
            
            $model = &$this->getModel("album");
            
            $album = $model->getalbum();
            
            
            $this->assignRef('album', $album);
            parent::display();
        }
    }
}
?>