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
/* No direct acess */

defined('_JEXEC') or die('restricted access');

/* Downloading option for the images */

/* Getting the file path */
$baseurl = JURI::base();
$file = JURI::base() . 'images/macgallery/'.JRequest::getVar("albumid") ;
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=" . basename($file));

header("Content-Description: File Transfer");
@readfile($file);
?>