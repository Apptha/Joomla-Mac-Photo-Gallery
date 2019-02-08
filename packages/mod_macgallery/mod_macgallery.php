<?php
/*
 * **********************************************************

 * Component Name: Mac-Dock Gallery
 * Description: Mac dock photo gallery component for Joomla 3.0
 * Version: 1.5
 * Edited By: Sameera
 * Author URI: http://www.apptha.com/
 * Date : November 20 2012

 * *********************************************************

  @Copyright Copyright (C) 2012-2013 Apptha Support
  @license http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL

 * ******************************************************** */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');



$images 	= modMacgalleryHelper::getimages($params);

require(JModuleHelper::getLayoutPath('mod_macgallery'));
