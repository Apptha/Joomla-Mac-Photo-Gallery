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

/* No direct acesss  my testing */
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

require_once( JPATH_COMPONENT.DS.'controller.php' );

/* get value of view from url */
$controller = JRequest::getWord('view');

/*if no view set controller to cpanel */
if($controller == '') $controller='cpanel';
if($controller) { 
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}


$jlang =& JFactory::getLanguage();
$jlang->load('com_macgallery_v6', JPATH_ADMINISTRATOR, null, true);


$task = JRequest::getCmd('task');

$controllerName = 'MacgalleryController'.$view;




/* Create the controller */
$controller = new $controllerName();




/* Perform the Request task */
$controller->execute( JRequest::getCmd('task') );

   

/* Redirect if set by the controller */
$controller->redirect();
?>