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

class MacgalleryViewimages extends JViewLegacy {

    function display() {

        $mode = JRequest::getvar('mode', '', 'request', 'string');
        $pageId = JRequest::getvar('pageid', '', 'request', 'int');
        $albumId = JRequest::getVar('albumid', '', 'request', 'int');
        $model = & $this->getModel();
        if ($mode != '') {
            $images = $model->getajaxImages($pageId, $albumId);
        } else {
            $images = $model->getimages();
        }
		
        $this->assignRef('images', $images);
        $album = $model->getalbum();
    	if(JRequest::getVar('view') =="images" && JRequest::getInt('albumid') && JRequest::getInt('tmpl') =="component" && JRequest::getInt('ajax')==1  ){
    		
    		if(JRequest::getInt('imgid'))
        		$album = $model->getAlbumSingleImageById(JRequest::getInt('albumid'),JRequest::getInt('imgid'));
        	else
        		$album = $model->getAlbumImageById(JRequest::getInt('albumid'),JRequest::getInt('limit'));
        		
        	$albumTotal = $model->getAlbumTotalById(JRequest::getInt('albumid'));
        	$this->assignRef('albumTotal', $albumTotal);
        }
       if(JRequest::getVar('view') =="images" &&  JRequest::getCmd('tmpl') =="component" && JRequest::getInt('albumLoad') =="1"  ){
        	 $albumList = $model->getAlbumList();
        	 $this->assignRef('albumList', $albumList);
    	}
    	
    	//for adding title and description image_src tags
    	$document =& JFactory::getDocument();
    	   	   	
       	if(isset($album[0]->albumname) ) $document->setTitle($album[0]->albumname);
       	if(isset($album[0]->description) ) $document->setMetaData("description", $album[0]->description);
       	
        $this->assignRef('albums', $album);
        parent::display();
    }
	function aspectRatioSize($imagePath, $actualWidth, $actualheight) {

        $aspectVal = array();
        $actualRatio = $actualWidth / $actualheight;
        $imageSize = @getimagesize($imagePath);
        if (isset($imageSize[0])) {

            $uploadRatio = $imageSize[0] / $imageSize[1];
            if ($actualRatio < $uploadRatio) {

                $aspectVal[] = $actualWidth;
                $aspectVal[] = $imageSize[1] * $actualWidth / $imageSize[0];
            } else {
                $aspectVal[] = $imageSize[0] * $actualheight / $imageSize[1];
                $aspectVal[] = $actualheight;
            }
        }
        return $aspectVal;
    }
}

?>
