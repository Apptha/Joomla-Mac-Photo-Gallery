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

/* No direct access */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/* Images View */

class MacgalleryViewdownload extends JViewLegacy {

    function display() {   	
        ob_clean();
        parent::display();
        die();
    }
}

?>
