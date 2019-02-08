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
/* error reporting */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');


if(version_compare(JVERSION,'1.6.0','ge')) {
	$language = JFactory::getLanguage();
	$language->load('com_macgallery',  JPATH_COMPONENT_SITE .DS."language".DS."version6", 'en-GB', true);
}

/**
 * details Component Controller
 */
class MacgalleryController extends JControllerLegacy {

    /**
     * Method to display the view
     *
     * @access    public
     */
    function display() {

        $viewName = JRequest::getVar('view', 'album');
        $viewLayout = JRequest::getVar('layout', 'default');
    	if(JRequest::getVar('view') =="images" && JRequest::getInt('albumid') && JRequest::getCmd('tmpl') =="component" && JRequest::getCmd('plg') !="1" ){
    		 $viewName = JRequest::getVar('view', 'images');
        	 $viewLayout = JRequest::getVar('layout', 'imagegallery');
    	}
         if(JRequest::getVar('view') =="images" &&  JRequest::getCmd('tmpl') =="component" && JRequest::getInt('albumLoad') =="1"  ){
    		 $viewName = JRequest::getVar('view', 'images');
        	 $viewLayout = JRequest::getVar('layout', 'albumsAjax');
        }
        $view = & $this->getView($viewName);

        if ($model = & $this->getModel($viewName)) {
            $view->setModel($model, true);
        }

        $view->setLayout($viewLayout);
        $view->display();
    }

}

?>