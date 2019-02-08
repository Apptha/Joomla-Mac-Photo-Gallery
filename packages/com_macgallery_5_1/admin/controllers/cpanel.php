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

/* no direct access*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/* Control Panel Administrator Controller */
class MacgalleryControllercpanel extends JControllerLegacy
{
    function display()
    {

        $viewName = JRequest::getVar( 'view', 'cpanel' );
        $view =& $this->getView($viewName);
        if ($model =& $this->getModel('cpanel'))
        {
            $view->setModel($model, true);
        }
        $view->display();
    }

    function sortorder()
    {
        $view =& $this->getView('sortorder');
        if ($model =& $this->getModel('sortorder'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('sortorderlayout');
        $view->sortorder();
    }
}
?>
