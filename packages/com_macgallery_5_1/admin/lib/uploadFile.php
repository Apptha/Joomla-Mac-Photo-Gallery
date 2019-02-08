
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
 @license GGNU/GPLv3 http://www.gnu.org/licenses/lgpl-3.0.html

 **********************************************************/
require_once '../../../../configuration.php';

//require_once '../../../../includes' ;
//require_once '../../../../includes/framework.php';
////require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
//require_once '../../../../libraries/joomla/factory.php';
//require_once '../../../../libraries/joomla/application.php';


$config = new JConfig();
$secret=md5($config->secret);
if($_POST['token']==$secret)
{
macgallery_upload();
}
exit;

function macgallery_upload(){

	        //this is the name of the field in the html form, filedata is the default name for swfupload
	        //so we will leave it as that
	        $fieldName = 'uploadfile';

	        //any errors the server registered on uploading
	        $fileError = $_FILES[$fieldName]['error'];
	        $fileError = 0;
	        if ($fileError > 0)
	        {
	                switch ($fileError)
	                {
	                case 1:
                            trigger_error("The file is too large",E_USER_ERROR);

	                break;

	                case 2:

                            trigger_error("The file is too large",E_USER_ERROR);

	                break;

	                case 3:
	                    trigger_error("Error File",E_USER_ERROR);
	                break;

	                case 4:
	                    trigger_error("Error File",E_USER_ERROR);
	                break;
	                }
	        }

	        //check for filesize
	        $fileSize = $_FILES[$fieldName]['size'];
	        if($fileSize > 20000000)
	        {

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
	        $uploadPath = urldecode($_REQUEST["jpath"]).$fileName;

	        if(! move_uploaded_file($fileTemp, $uploadPath))
	        {
	                echo 'Cannot move the file' ;
	        }
    	      echo $fileName;
	        //crating thumb image
	        $thumbWidth = (int) $_REQUEST["th"] + (int) $_REQUEST["tw"] + 50;
    		imageToThumb($fileName,$thumbWidth,$thumbWidth,"thumb_image");
    		imageToThumb1($fileName,$_REQUEST["mh"],$_REQUEST["mw"],"medium_image");
    		imageToThumb2($fileName,$_REQUEST["fh"],$_REQUEST["fw"],"full_image");


	        //$link = base64_decode(JRequest::getVar("return-url"));
	        //$this->setRedirect($link,$msg);
	    }
		// function to create Thumbnail image from original image.
	    function imageToThumb($fname,$imgheight,$imgwidth,$foldername) {
                //echo $imgheight; echo $imgwidth;
	        // open the directory
	        $pathToImages = urldecode($_REQUEST["jpath"]);
	        $pathToThumbs = urldecode($_REQUEST["jpath"]). $foldername."/";


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
	                imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width,$new_height,150, 150);


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
             function imageToThumb1($fname,$imgheight,$imgwidth,$foldername) {
                //echo $imgheight; echo $imgwidth;
	        // open the directory
	        $pathToImages = urldecode($_REQUEST["jpath"]);
	        $pathToThumbs = urldecode($_REQUEST["jpath"]). $foldername."/";


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
	                imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width,$new_height,$width, $height);


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
             function imageToThumb2($fname,$imgheight,$imgwidth,$foldername) {
                //echo $imgheight; echo $imgwidth;
	        // open the directory
	        $pathToImages = urldecode($_REQUEST["jpath"]);
	        $pathToThumbs = urldecode($_REQUEST["jpath"]). $foldername."/";


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
	                imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width,$new_height,$width,$height);


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
?>