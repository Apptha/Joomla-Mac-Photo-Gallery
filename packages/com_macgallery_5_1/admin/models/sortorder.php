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

class MacgalleryModelsortorder extends JModelLegacy {

    function sortordermodel()
    {
        global $mainframe;
        $db =& JFactory::getDBO();
        $listitem=JRequest::getvar('listItem','','get','var');

        foreach ($listitem as $position => $item) :
            $query = "UPDATE #__macgallery_image SET `ordering` = $position WHERE `id` = $item";

            $db->setQuery($query );
            $db->query();
	    endforeach;
    }
}
?>
