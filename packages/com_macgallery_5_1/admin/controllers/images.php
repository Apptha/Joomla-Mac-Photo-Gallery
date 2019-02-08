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

/* no direct access */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/* Images Administrator Controller */
class MacgalleryControllerimages extends JControllerLegacy
{
	
    function display()
    { 
        $viewName = JRequest::getVar( 'view', 'images' );
        $view =& $this->getView($viewName);
        if ($model =& $this->getModel('images'))
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
    	$images = JRequest::get('POST');
    	
        for($i=0;$i<count($images["image"]);$i++){
        	$model = & $this->getModel('images');
        	
        	$imageDetails["image"] = $images["image"][$i];
        	$imageDetails["title"] = $images["title"][$i];
        	$imageDetails["albumid"] = $images["albumid"];
        	$imageDetails["published"] = "1";
        	$imageDetails["description"] = $images["imagedesc"][$i];
        	$model->saveImagesNew($imageDetails);
        }
        $this->setRedirect('index.php?view=images&option='.JRequest::getVar('option')."&albumid=".$imageDetails["albumid"], 'Saved!');
    }
    function savenew(){
            $this->save();
            $this->setRedirect('index.php?view=images&option='.JRequest::getVar('option')."&task=add"."&albumid=".JRequest::getVar('albumid'), 'Saved!');
    }
    function add()
    {
        $this->display();
    }
    function remove()
    {
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
        /* Make sure the cid parameter was in the request */
        if($arrayIDs === null)
        { 
            JError::raiseError(500, 'cid parameter missing from the request');
        }
        $model =& $this->getModel('images');
        $model->deleteimages($arrayIDs);
        if(JRequest::getInt("albumid")){
        	$this->setRedirect('index.php?view=images&option='.JRequest::getVar('option')."&albumid=".JRequest::getInt("albumid"), 'Deleted...');	
        }
        else{
        	$this->setRedirect('index.php?view=images&option='.JRequest::getVar('option'), 'Deleted...');
        }
        
    }

    function cancel()
    {
        $this->setRedirect('index.php?view=images&option='.JRequest::getVar('option'), 'Cancelled...');
    }

    function publish()
    {
        $images = JRequest::get('POST');
        $model =& $this->getModel('images');
        $model->pubimages($images);
        $this->setRedirect('index.php?view=images&option='.JRequest::getVar('option')."&albumid=".JRequest::getInt('albumid'));
    }

    function unpublish()
    {
        $images = JRequest::get('POST');
        $model =& $this->getModel('images');
        $model->pubimages($images);
        $this->setRedirect('index.php?view=images&option='.JRequest::getVar('option')."&albumid=".JRequest::getInt('albumid'));
    }

    function apply()
    {
        $images = JRequest::get('POST');
        $model =& $this->getModel('images');
        $model->saveimages($images);
        $link = 'index.php?option='.JRequest::getVar('option').'&view=images&task=edit&cid[]='.$images['id'];
        $this->setRedirect($link, 'Image Saved!');
    }
	function saveclose()
    {
        $images = JRequest::get('POST');
        $model =& $this->getModel('images');
        $model->saveimages($images);
        $link = 'index.php?option='.JRequest::getVar('option').'&view=images&albumid='.$images['albumid'];
        $this->setRedirect($link, 'Image Saved!');
    }
    function sortorder()
    {
        $view =& $this->getView('sortorder');

        /* Get/Create the model */
        if ($model =& $this->getModel('sortorder')) {
            $view->setModel($model, true);
        }
        $view->setview('sortorderview');
        $view->sortorder();
    } 
	function macgallery_upload(){
	        //this is the name of the field in the html form, filedata is the default name for swfupload
	        //so we will leave it as that
	        $fieldName = 'uploadfile';
	
	        //any errors the server registered on uploading
	        $fileError = $_FILES[$fieldName]['error'];
	        if ($fileError > 0)
	        {
	                switch ($fileError)
	                {
	                case 1:
	                    JError::raiseWarning("", JText::_( 'COM_MACGALLERY_CONTROLLERS_FILELARGEPHP' ));
	                break;
	
	                case 2:
	                    JError::raiseWarning("", JText::_( 'COM_MACGALLERY_CONTROLLERS_FILELARGEHTML' ));
	                break;
	
	                case 3:
	                    JError::raiseWarning("", JText::_( 'COM_MACGALLERY_CONTROLLERS_FILEERROR' ));
	                break;
	
	                case 4:
	                    JError::raiseWarning("", JText::_( 'COM_MACGALLERY_CONTROLLERS_FILEERROR' ));
	                break;
	                }
	        }
	
	        //check for filesize
	        $fileSize = $_FILES[$fieldName]['size'];
	        if($fileSize > 20000000)
	        {
	             JError::raiseWarning("", JText::_( 'COM_MACGALLERY_BIGGER_THAN_20_MB' ));
	        }
	
	        //check the file extension is ok
	        $fileName = $_FILES[$fieldName]['name'];
	        $uploadedFileNameParts = explode('.',$fileName);
	        $uploadedFileExtension = array_pop($uploadedFileNameParts);
	
	        $validFileExts = explode(',', 'jpeg,jpg,png,gif,bmp');
	
	        //assume the extension is false until we know its ok
	        $extOk = false;
	
	        //go through every ok extension, if the ok extension matches the file extension (case insensitive)
	        //then the file extension is ok
	        foreach($validFileExts as $key => $value)
	        {
	                if( preg_match("/$value/i", $uploadedFileExtension ) )
	                {
	                        $extOk = true;
	                }
	        }
	
	
	        //the name of the file in PHP's temp directory that we are going to move to our folder
	        
	
	        //for security purposes, we will also do a getimagesize on the temp file (before we have moved it
	        //to the folder) to check the MIME type of the file, and whether it has a width and height
	        
	
	        //lose any special characters in the filename
	        
	        for ($code_length = 5, $newcode = ''; strlen($newcode) < $code_length; $newcode .= chr(!rand(0, 2) ? rand(48, 57) : (!rand(0, 1) ? rand(65, 90) : rand(97, 122)))
	        );
	
	        $fileTemp = $_FILES[$fieldName]['tmp_name'];
	        $fileParts = explode(".",trim($_FILES[$fieldName]['name']));
	        $fileExtension = $fileParts[count($fileParts)-1];
	        $fileName = preg_replace("[^A-Za-z0-9.]", "-", $fileName);
	        $fileName = $fileParts[0]."__".$newcode.rand(1,100000).".".$fileExtension;
	        
	        //always use constants when making file paths, to avoid the possibilty of remote file inclusion
	        $uploadPath = JPATH_SITE.DS.'images'.DS."macgallery".DS.$fileName;
	
	        if(!JFile::upload($fileTemp, $uploadPath))
	        {
	                JError::raiseWarning("", JText::_( 'COM_MACGALLERY_CONTROLLERS_MOVEERROR' ));
	        }
	        
	        $model = $this->getModel('images');
    		$result = $model->getsettings();
    		$row = $result["row"][0];
    		
	        //crating thumb image 
	        
    		//$this->imageToThumb($fileName,$row['mouseover_width'],$row['mouseover_width'],"thumb_image");
    		$this->imageToThumb($fileName,$row['mediumimgheight'],$row['mediumimgwidth'],"mediumimgwidth");
    		$this->imageToThumb($fileName,$row['fullimgheight'],$row['fullimgwidth'],"fullimgwidth");
	        
	        
	        //$link = base64_decode(JRequest::getVar("return-url"));
	        //$this->setRedirect($link,$msg);
	    }
		// function to create Thumbnail image from original image.
	    function imageToThumb($fname,$imgheight,$imgwidth,$foldername) {
	        // open the directory
	        $pathToImages = JPATH_ROOT.DS."images".DS."macgallery".DS;
	        $pathToThumbs = JPATH_ROOT.DS."images".DS."macgallery".DS . $foldername . DS;
	        
	        
	        
	        
	        $dir = opendir($pathToImages);
	        ini_set("memory_limit", "1000M");
	        // loop through it, looking for any/all JPG files:
	        if (readdir($dir)) {
	            // parse path for the extension
	            $info = pathinfo($pathToImages . $fname);
	            
	            
	            
	            if (strtolower($info['extension']) == 'jpg') {
	                // load image and get image size
	                $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
	            } else if (strtolower($info['extension']) == 'png') {
	                // load image and get image size
	                $img = imagecreatefrompng("{$pathToImages}{$fname}");
	            } else if (strtolower($info['extension']) == 'gif') {
	                // load image and get image size
	                $img = imagecreatefromgif("{$pathToImages}{$fname}");
	            }
	                $width = imagesx($img);
	                $height = imagesy($img);
	
	                // calculate thumbnail size
	                //$new_width = $thumbWidth;
	                //$new_height = floor($height * ( $thumbWidth / $width ));
	                
					$new_width = $imgwidth;
	                $new_height = $imgheight;
	
	                // create a new temporary image
	                $tmp_img = imagecreatetruecolor($new_width, $new_height);
	
	                // copy and resize old image into new image
	                imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	                if (strtolower($info['extension']) == 'jpg') {
		                // save thumbnail into a file
		                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
		            } else if (strtolower($info['extension']) == 'png') {
		                // save thumbnail into a file
		                imagepng($tmp_img, "{$pathToThumbs}{$fname}");
		            } else if (strtolower($info['extension']) == 'gif') {
		                // save thumbnail into a file
		                imagegif($tmp_img, "{$pathToThumbs}{$fname}");
		            }
		           
		            
	            }
	        // close the directory
	        closedir($dir);
	    }    
	    
// function to create Thumbnail image from original image.
	    function regenrate() {
	        // open the directory
	        $pathToImages = JPATH_ROOT.DS."images".DS."macgallery".DS;
	        
	        
	        
	        ini_set("memory_limit", "1000M");
	        $array = array("full_image","medium_image","thumb_image");
	        
	        $model = $this->getModel('settings');
    		$result = $model->getsettings();
    		$row = $result["row"][0];
	        
	        for($f=0;$f<count($array);$f++){
	        
	        	$pathToThumbs = JPATH_ROOT.DS."images".DS."macgallery".DS . $array[$f] . DS;
	        	$dir = opendir($pathToImages);
	        
	        // loop through it, looking for any/all JPG files:
	        while (false !== ($fname = readdir($dir))) {
	            // parse path for the extension
	            $info = pathinfo($pathToImages . $fname);            
	            	if($fname !="." && $fname !=".." ):
		            if (strtolower($info['extension']) == 'jpg') {
		                // load image and get image size
		                $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
		            } else if (strtolower($info['extension']) == 'png') {
		                // load image and get image size
		                $img = imagecreatefrompng("{$pathToImages}{$fname}");
		            } else if (strtolower($info['extension']) == 'gif') {
		                // load image and get image size
		                $img = imagecreatefromgif("{$pathToImages}{$fname}");
		            }
	        		else if (strtolower($info['extension']) == 'bmp') {
		                // load image and get image size
		                $img = imagecreatefromwbmp("{$pathToImages}{$fname}");
		            }
		                $width = imagesx($img);
		                $height = imagesy($img);
		
		                // calculate thumbnail size
		                //$new_width = $thumbWidth;
		                //$new_height = floor($height * ( $thumbWidth / $width ));
		                
		                if($array[$f] == "full_image"){
							$new_width = $row->fullimgwidth;
		                	$new_height = $row->fullimgheight;
		                }
		                else if($array[$f] == "medium_image"){
		                	$new_width = $row->mediumimgwidth;
		                	$new_height = $row->mediumimgheight;
		                }
		                else if($array[$f] == "thumb_image"){
		                	$thumbWidth = $row->mouseover_width + $row->thumbimgwidth + 50;
		                	$new_width = $thumbWidth ;
		                	$new_height = $thumbWidth;
		                }
		
		                // create a new temporary image
		                $tmp_img = imagecreatetruecolor($new_width, $new_height);
		
		                // copy and resize old image into new image
		                imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		                if (strtolower($info['extension']) == 'jpg') {
			                // save thumbnail into a file
			                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
			            } else if (strtolower($info['extension']) == 'png') {
			                // save thumbnail into a file
			                imagepng($tmp_img, "{$pathToThumbs}{$fname}");
			            } else if (strtolower($info['extension']) == 'gif') {
			                // save thumbnail into a file
			                imagegif($tmp_img, "{$pathToThumbs}{$fname}");
			            }
	        			else if (strtolower($info['extension']) == 'gif') {
			                // save thumbnail into a file
			                image2wbmp($tmp_img, "{$pathToThumbs}{$fname}");
			            }
		            endif;
	            }            
		        // close the directory
		        closedir($dir);
	        	
	        }
			$this->setRedirect('index.php?view=images&option='.JRequest::getVar('option'), JText::_('COM_MACGALLERY_CONTROLLERS_IMAGE_REGENERATE') );
	    }
	    
	    
}

?>
