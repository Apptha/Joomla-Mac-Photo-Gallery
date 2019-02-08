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
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class MacgalleryModelsettings extends JModelLegacy {

    function getsettings()
    {
        global $option, $mainframe;
        $db =& JFactory::getDBO();

        $query = "SELECT count(*) FROM #__macgallery_settings";
        $db->setQuery( $query);
        $total = $db->loadResult();

        $query = "SELECT * FROM #__macgallery_settings  ";
        $db->setQuery( $query );
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $settings = array('option'=>$option,'row'=>$rows);
        return $settings;
    }

    function getsetting( $id )
    {
        global $option;
        $row =& JTable::getInstance('settings', 'Table');
        $row->load($id);
        $lists['published'] = JHTML::_('select.booleanlist', 'published','class="inputbox"', $row->published);
        $settings = array('option'=>$option,'row'=>$row,'lists'=>$lists);
        return $settings;
    }

    function savesettings($settings)
    {
       $settingsTableRow =& $this->getTable('settings');
       if (!$settingsTableRow->bind($settings)) {
            JError::raiseError(500, 'Error binding data');
        }
        if (!$settingsTableRow->check()) {
            JError::raiseError(500, 'Invalid data');
        }
        if (!$settingsTableRow->store()) {
            $errorMessage = $settingsTableRow->getError();
            JError::raiseError(500, 'Error binding data: '.$errorMessage);
        }
    }
}
?>