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
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


global $mainframe;

$mainframe = JFactory::getApplication();



class MacgalleryModelalbum extends JModelLegacy
{
    function getalbum()
    {
		global $option, $mainframe;
        $mainframe = JFactory::getApplication();
        $filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'albumname', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
        $filter_id = $mainframe->getUserStateFromRequest( $option.'filter_id',		'filter_id',		'',			'int' );

        
       
        
        if($filter_order == "title" || $filter_order == "albumname" ){
            $filter_order = "albumname";
        }
        

        // search filter
        $search = $mainframe->getUserStateFromRequest( $option.'search','search','','string' );
        
        // page navigation
        
        
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        
        
        $limitstart = $mainframe->getUserStateFromRequest('global.list.limitstart', 'limitstart', 0, 'int');
        
        $db =& JFactory::getDBO();

        $query = "SELECT count(*) FROM #__macgallery_album";
        $db->setQuery( $query);
        $total = $db->loadResult();
        
        jimport('joomla.html.pagination');

        $pageNav = new JPagination($total, $limitstart, $limit);

        $lists['order_Dir']	= $filter_order_Dir;
        $lists['order']		= $filter_order;



        
        if($filter_order) {
            //sorting order
            $query = "SELECT * FROM #__macgallery_album ";
            if(isset($lists["order_Dir"]) && isset($lists["order"]) && $lists["order"] !="ordering" ){
                
                $query .= " ORDER BY  ".$lists["order"]." ".$lists["order_Dir"];
            }
            $query .= " LIMIT ".$pageNav->limitstart.",".$pageNav->limit;
            
            $db->setQuery( $query );
            $rows = $db->loadObjectList();
        }
        if (trim($search) !="" ) {
            //sorting order
            $query ="SELECT * FROM #__macgallery_album where albumname LIKE '%$search%'";

            if(isset($lists["order_Dir"]) && isset($lists["order"]) && $lists["order"] !="ordering" ){
                $query .= " ORDER BY  ".$lists["order"]." ".$lists["order_Dir"];
            }           
            $db->setQuery($query);
            $rows = $db->loadObjectList();
        }
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        
        
        $album = array('pageNav' => $pageNav,'limitstart'=>$limitstart,'lists'=>$lists,'option'=>$option,'row'=>$rows);
        return $album;
    }

    function getalbums($id)
    {
        global $option;
        $row =& JTable::getInstance('album', 'Table');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $id = $cid[0];
        $key = $row->load($id);
        $lists['published'] = JHTML::_('select.booleanlist', 'published','class="inputbox"', $row->published);
        $album = array('option'=>$option,'row'=>$row,'lists'=>$lists);
        return $album;
    }

    function getNewalbum()
    {
        $albumTableRow =& JTable::getInstance('album', 'Table');
        $albumTableRow->id = 0;
        $albumTableRow->albumname = '';
        $albumTableRow->description = '';
        $albumTableRow->images = '';
        $albumTableRow->published = '';
        return $albumTableRow;
    }

    function savealbum($album)
    {
        $albumTableRow =& $this->getTable('album');

        if (!$albumTableRow->bind($album)) {
            JError::raiseError(500, 'Error binding data');
        }
        if (!$albumTableRow->check()) {
            JError::raiseError(500, 'Invalid data');
        }
        if (!$albumTableRow->store()) {
            $errorMessage = $albumTableRow->getError();
            JError::raiseError(500, 'Error binding data: '.$errorMessage);
        }
    }

    function deletealbum($arrayIDs)
    {
        $db = $this->getDBO();

        $query = "DELETE FROM #__macgallery_album WHERE id IN (".implode(',', $arrayIDs).")"; //to replace #_ with #_
        $db->setQuery($query);
        $db->query();

        $query = "SELECT count(*) FROM #__macgallery_album";
        $db->setQuery( $query);
        $total = $db->loadResult();
    }

    function pubalbum($arrayIDs)
    {
        echo $arrayIDs['task'];
        if($arrayIDs['task']=="publish")
        {
            $publish = 1;
        }
        else
        {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
        for($i = 0; $i < $n; $i++)
        {
            $query = "UPDATE #__macgallery_album set published=".$publish." WHERE id=".$arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }
}

?>
