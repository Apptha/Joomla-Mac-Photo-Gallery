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
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class MacgalleryModelCpanel extends JModelAdmin
{
    public function getForm($data = array(), $loadData = true)
    {

    }
    function alblist(){
        global $option;
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__macgallery_album ";
        $db->setQuery( $query );
        $rows = $db->loadObjectList();
        $album = array('option'=>$option,'row'=>$rows);
        return $album;
    }
}
?>
