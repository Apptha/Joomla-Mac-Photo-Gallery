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

/* Album Administrator Controller  */
class MacgalleryControlleralbum extends JControllerLegacy
{   
    function display()
    {
        $viewName = JRequest::getVar( 'view', 'album' );
        $view =& $this->getView($viewName);
        if ($model =& $this->getModel('album'))
        {
            $view->setModel($model, true);
        }
        $view->display();
    }

    function edit()
    {
        $this->display();
    }

    function save()
    {
        $album = JRequest::get('POST');
        $model =& $this->getModel('album');
        $model->savealbum($album);
        $this->setRedirect('index.php?view=album&option='.JRequest::getVar('option'), 'Saved!');
    }

    function add()
    {       
        $this->display();
    }

    function remove()
    {
        //Reads cid as an array
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array' );
        if($arrayIDs === null)
        { 
           //Make sure the cid parameter was in the request
           JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model =& $this->getModel('album');
        $model->deletealbum($arrayIDs);
        $this->setRedirect('index.php?view=album&option='.JRequest::getVar('option'), 'Deleted...');

    }

    function cancel()
    {
        $this->setRedirect('index.php?view=album&option='.JRequest::getVar('option'), 'Cancelled...');
    }

    function publish()
    {
        $album = JRequest::get('POST');
        $model =& $this->getModel('album');
        $model->pubalbum($album);
        $this->setRedirect('index.php?view=album&option='.JRequest::getVar('option'));
    }

    function unpublish()
    {
        $album = JRequest::get('POST');
        $model =& $this->getModel('album');
        $model->pubalbum($album);
        $this->setRedirect('index.php?view=album&option='.JRequest::getVar('option'));
    }

    function apply()
    {
        $album = JRequest::get('POST');
        $model =& $this->getModel('album');
        $model->savealbum($album);
        $link = 'index.php?option='.JRequest::getVar('option').'&view=album&task=edit&cid[]='.$album['id'];
        $this->setRedirect($link, 'Album Saved!');
    }
}

?>

