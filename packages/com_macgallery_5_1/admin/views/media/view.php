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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

error_reporting(E_ERROR | E_PARSE);

jimport('joomla.application.component.view');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');


class MacgalleryViewmedia extends JViewLegacy {
     function display($tpl = null) {
           $config = JComponentHelper::getParams('com_media');
           $list = $this->selectFiles();
           $this->assignRef('list', $list);
           $this->assignRef('config', $config);
           parent::display($tpl);
     }
     function selectFiles(){
        
        $app = JFactory::getApplication();
        $lang	= JFactory::getLanguage();
        JHtml::_('stylesheet','media/popup-imagelist.css', array(), true);
        if ($lang->isRTL()) :
                JHtml::_('stylesheet','media/popup-imagelist_rtl.css', array(), true);
        endif;

        $document = JFactory::getDocument();
        $document->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");JHtml::_('stylesheet','media/popup-imagelist.css', array(), true);
        if ($lang->isRTL()) :
                JHtml::_('stylesheet','media/popup-imagelist_rtl.css', array(), true);
        endif;

        $document = JFactory::getDocument();
        $document->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");


        if(JRequest::getString("folder")){
            $this->folder = JRequest::getString("folder");
        }
        $basePath =  JPATH_ROOT.DS."images".DS.$this->folder;

        $images		= array ();
        $folders	= array ();
        $docs		= array ();

        // Get the list of files and folders from the given folder
        $fileList	 = JFolder::files($basePath);
        $folderList      = JFolder::folders($basePath);
        //
        // Iterate over the files if they exist
		if ($fileList !== false) {
			foreach ($fileList as $file)
			{
				if (is_file($basePath.'/'.$file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html') {
                                        $mediaBase = '';
					$tmp = new JObject();
					$tmp->name = $file;
					$tmp->title = $file;
					$tmp->path = str_replace(DS, '/', JPath::clean($basePath . '/' . $file));
					$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
					$tmp->size = filesize($tmp->path);

					$ext = strtolower(JFile::getExt($file));
					
                                        $info = @getimagesize($tmp->path);
                                        $tmp->width		= @$info[0];
                                        $tmp->height	= @$info[1];
                                        $tmp->type		= @$info[2];
                                        $tmp->mime		= @$info['mime'];

                                        if (($info[0] > 60) || ($info[1] > 60)) {
                                                $dimensions = MacgalleryViewmedia::imageResize($info[0], $info[1], 60);
                                                $tmp->width_60 = $dimensions[0];
                                                $tmp->height_60 = $dimensions[1];
                                        }
                                        else {
                                                $tmp->width_60 = $tmp->width;
                                                $tmp->height_60 = $tmp->height;
                                        }

                                        if (($info[0] > 16) || ($info[1] > 16)) {
                                                $dimensions = MacgalleryViewmedia::imageResize($info[0], $info[1], 16);
                                                $tmp->width_16 = $dimensions[0];
                                                $tmp->height_16 = $dimensions[1];
                                        }
                                        else {
                                                $tmp->width_16 = $tmp->width;
                                                $tmp->height_16 = $tmp->height;
                                        }

                                        $images[] = $tmp;
				}
			}
		}

		// Iterate over the folders if they exist
		if ($folderList !== false) {
			foreach ($folderList as $folder)
			{
				$tmp = new JObject();
				$tmp->name = basename($folder);
				$tmp->path = str_replace(DS, '/', JPath::clean($basePath . '/' . $folder));
				//$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
				$count = MacgalleryViewmedia::countFiles($tmp->path);
				$tmp->files = $count[0];
				$tmp->folders = $count[1];

				$folders[] = $tmp;
			}
		}

		$list = array('folders' => $folders, 'docs' => $docs, 'images' => $images);
                return $list;
     }
    public static function imageResize($width, $height, $target)
    {
		//takes the larger size of the width and height and applies the
		//formula accordingly...this is so this script will work
		//dynamically with any size image
		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width = round($width * $percentage);
		$height = round($height * $percentage);

		return array($width, $height);
    }
    public static function countFiles($dir)
    {
		$total_file = 0;
		$total_dir = 0;
		
		if (is_dir($dir)) {
			$d = dir($dir);

			while (false !== ($entry = $d->read())) {
				if (substr($entry, 0, 1) != '.' && is_file($dir . DIRECTORY_SEPARATOR . $entry) && strpos($entry, '.html') === false && strpos($entry, '.php') === false) {
					$total_file++;
				}
				if (substr($entry, 0, 1) != '.' && is_dir($dir . DIRECTORY_SEPARATOR . $entry)) {
					$total_dir++;
				}
			}

			$d->close();
		}

		return array ($total_file, $total_dir);
    }

}
?>