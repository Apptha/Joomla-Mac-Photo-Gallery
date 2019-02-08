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

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

// Require the controller
require_once( JPATH_COMPONENT . DS . 'controller.php' );

//Require
include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "helpers" . DS . "security.php");
// Create the controller
@include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php");
$controller = new MacgalleryController();

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();

class MacgalleryClass {

    /**
     * @var    array  Array of view levels
     * @since  11.1
     */
    protected $_const;

    /**
     * Method to check if a user is authorised to perform an action, optionally on an asset.
     *
     * @param   integer  $userId  Id of the user for which to check authorisation.
     * @param   string   $action  The name of the action to authorise.
     * @param   mixed    $asset   Integer asset id or the name of the asset as a string.  Defaults to the global asset node.
     *
     * @return  boolean  True if authorised.
     *
     * @since   11.1
     */
    
    function apiKey() {
    	if (extension_loaded('mcrypt')) {
	        $this->_const = "wk2A7KrQDNlNbYC5dIUPcIcQn43I7oMGPbAOo6tY0ixC801XYqeUP0+ODLabO2X47f4L0vO0xTt1zebQd/jNV2UzZrz7DGsJ3ykUcEtun7I=";
	        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	        $const = base64_decode($this->_const);
	        $val = "<div style='text-align:center'><font style='font-size:10px;'>";
	        if (conf__MAC_GALLERY != 1  )
	            $val .=  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, "macdock", $const, MCRYPT_MODE_ECB, $iv);
			$val .= "</font></div>";
    	}
    	else{
    		$val .= "<div style='text-align:center'><font style='font-size:10px;'>Please enable mcrypt extension in your server</font></div>";
    	}
        return $val;
    }

}

$comClass = new MacgalleryClass();
?>
