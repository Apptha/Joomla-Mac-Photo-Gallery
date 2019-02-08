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

/* No direct acesss */

defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class simpleimage {

    var $image;
    var $image_type;

    function loads($filename) {

        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    function output($image_type=IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    function getWidth() {
        return imagesx($this->image);
    }

    function getHeight() {
        return imagesy($this->image);
    }

    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    /* resizing an image (crop an image) */
    function resize($width, $height) {
        $imgwidth=$this->getWidth();
	$imgheight=$this->getHeight();
        $source_aspect_ratio = $imgwidth / $imgheight;
        $desired_aspect_ratio = $width / $height;

        /*Triggered when source image is wider */
        if ( $source_aspect_ratio > $desired_aspect_ratio )
        {
        $temp_height = $height;
        $temp_width = ( int ) ( $height * $source_aspect_ratio );
        }
        else
        { /* Triggered otherwise (i.e. source image is similar or taller) */
        $temp_width = $width;
        $temp_height = ( int ) ( $width / $source_aspect_ratio );
        }

        /* Resize the image into a temporary image */
        $temp_gdim = imagecreatetruecolor( $temp_width, $temp_height );
        imagecopyresampled($temp_gdim, $this->image, 0, 0, 0, 0, $temp_width, $temp_height, $imgwidth, $imgheight);

        /* Copy cropped region from temporary image into the desired image */
        $x0 = ( $temp_width - $width ) / 2;
        $y0 = ( $temp_height - $height ) / 2;

        $desired_gdim = imagecreatetruecolor( $width, $height );
        imagecopy( $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $width, $height );
        $this->image = $desired_gdim;

    }
}

class MacgalleryModelimages extends JModelLegacy {

    /* triggered when album cover image is set */
     function setImage() {
        $row = & JTable::getInstance('images', 'Table');
        $cid = JRequest::getVar('cid', array(0), 'get', 'array');
        $aid = JRequest::getVar('albumid', array(0), 'get', 'int');
        $set = JRequest::getVar('set', array(0), 'get', 'int');
        $db = & JFactory::getDBO();

        if ($set == 1) {
            $query1 = "update  #__macgallery_image set albcover=0 WHERE albumid='$aid'";
            $query = "update #__macgallery_image set albcover=1 WHERE id = '$cid[0]' and albumid='$aid'";

            $db->setQuery($query1);
            $db->query();

            $db->setQuery($query);
            $db->query();
        } else if ($set == 0) {
            $albumid = JRequest::getVar('albumid');
            $albumquery = "SELECT MIN(id) as id FROM #__macgallery_image WHERE albumid =".$albumid;
            $db->setQuery($albumquery);
            $result = $db->loadResult();
            $query = "update  #__macgallery_image set albcover=0 WHERE id = '$cid[0]' and albumid='$aid'";

            $query1 = "update  #__macgallery_image set albcover=1 WHERE id = '$result' and albumid='$albumid'";

            $db->setQuery($query);
            $db->query();
            $db->setQuery($query1);
            $db->query();
        }

    }


	public function getsettings()
    {
        global $option, $mainframe;
        $db =& JFactory::getDBO();

        $query = "SELECT count(*) FROM #__macgallery_settings";
        $db->setQuery( $query);
        $total = $db->loadResult();

        $query = "SELECT * FROM #__macgallery_settings  ";
        $db->setQuery( $query );
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $settings = array('option'=>$option,'row'=>$rows);
        return $settings;
    }

    /* default display of images */
    function getimage() {

        global $option, $mainframe, $albumtot, $albumval;
        $status_filter_board=  JRequest::getInt('filter_board');

        /* table ordering */
        $mainframe = JFactory::getApplication();
        $filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . 'filter_order_Dir', 'filter_order_Dir', 'asc', 'word');
        $filter_id = $mainframe->getUserStateFromRequest($option . 'filter_id', 'filter_id', '', 'int');

        // search filter
        $search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');

        // page navigation
        $limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest('global.list.limitstart', 'limitstart', 0, 'int');
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;
        if($status_filter_board=='1')
        {

             $where = "WHERE a.status=1 and a.published!='-2'"; //query for displaying the board
        }else if($status_filter_board=='2')
        {

             $where = "WHERE a.status=0 and a.published!='-2'"; //query for displaying the board
        }else if($status_filter_board=='4')
        {
             $where = "WHERE a.published!='-2'"; //query for displaying the board
        }
        $db = & JFactory::getDBO();
        $albumid = "";
        $albumquery = "SELECT * FROM #__macgallery_album order by id asc ";
        $db->setQuery($albumquery);
        $albumval = $db->loadObjectList();



        $albumid = JRequest::getVar('albumid');
        if ($albumid)
        {
            $albumid = $albumid;
        }
        else
        {
            $albumid = $albumval[0]->id;
        }
        $query = "SELECT count(*) FROM #__macgallery_image where albumid='" . $albumid . "'";
        $db->setQuery($query);
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);



        if ((JRequest::getVar('albumid', '', 'get', 'int')) != "") {
            $albumid = JRequest::getVar('albumid', '', 'get', 'int');
            $where = " where albumid='" . $albumid . "'";
            JRequest::setVar('hid_albumid',$albumid);
        }
        else if ($albumid != "") {
            $where = " where albumid='" . $albumid . "'";
        } else {
            $where = "";
        }
        if ($filter_order) {
            //sorting order
            $query = "SELECT a.*,b.albumname FROM #__macgallery_image a inner join #__macgallery_album
 b on b.id = a.albumid   " . $where . "  order by $filter_order $filter_order_Dir LIMIT $pageNav->limitstart,$pageNav->limit";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
        }
        if ($search) {
            //sorting order
            $query ="SELECT a.*,b.albumname FROM #__macgallery_image a inner join #__macgallery_album b on b.id = a.albumid  where albumid='" . $albumid . "' and title LIKE '%$search%'";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
        }
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $images = array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'lists' => $lists, 'option' => $option, 'row' => $rows, 'albumval' => $albumval, 'album' => $albumid);

        return $images;
    }

    /* triggered during editing of an image */
    function getimages($id) {
        global $option, $albumval, $albumtot;

        $row = & JTable::getInstance('images', 'Table');
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = $cid[0];
        $row->load($id);

        $db = & JFactory::getDBO();
        $albumquery = "SELECT * FROM #__macgallery_album";
        $db->setQuery($albumquery);
        $albumval = $db->loadObjectList();

        $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
        $images = array('option' => $option, 'row' => $row, 'lists' => $lists, 'albumval' => $albumval);
        return $images;
    }

    function getNewimages() {
        $imagesTableRow = & JTable::getInstance('images', 'Table');
        $imagesTableRow->id = 0;
        $imagesTableRow->image = '';
        $imagesTableRow->image = '';
        $imagesTableRow->title = '';
        $imagesTableRow->description = '';
        $imagesTableRow->ordering = '';
        $imagesTableRow->singleimg = '';
        $imagesTableRow->published = '';
        $imagesTableRow->albumid = '';
        $imagesTableRow->albcover = '';

        $db = & JFactory::getDBO();
        $albumquery = "SELECT * FROM #__macgallery_album";
        $db->setQuery($albumquery);
        $albumval = $db->loadObjectList();
        $images = array('imagesTableRow' => $imagesTableRow, 'albumval' => $albumval);
        return $images;
    }
	function saveImagesNew($images){


		$db = & JFactory::getDBO();
        $albumquery = "SELECT id  FROM #__macgallery_image WHERE albumid =".$images["albumid"];
        $db->setQuery($albumquery);
        $db->query();
        $result1 = $db->loadResult();
        if(!count($result1))
            $images["albcover"] ="1";


        $imagesTableRow = & $this->getTable('images');

        if (!$imagesTableRow->bind($images)) {
            JError::raiseError(500, 'Error binding data');
        }
        if (!$imagesTableRow->check()) {
            JError::raiseError(500, 'Invalid data');
        }
	 	if (!$imagesTableRow->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
	}
    function saveimages($images) {

        $db = & JFactory::getDBO();

        $imagesTableRow = & $this->getTable('images');

        if (!$imagesTableRow->bind($images)) {
            JError::raiseError(500, 'Error binding data');
        }
        if (!$imagesTableRow->check()) {
            JError::raiseError(500, 'Invalid data');
        }
        if ($images['id'] == "")
        {$albumid = JRequest::getVar('albumid');



            for ($i = 0; $i < count($images['title']); $i++) {
                $title = $images['title'];
                $albumid = $images['albumid'];
                $description = $images['description'];
                $published = $images['published'];

                $imgfilename = explode("/",JRequest::getVar("image"));
                if(!isset($imgfilename[2]))
                        $imgfilename[2] = "";

            if(count($result1) ){
              $query = "insert into #__macgallery_image(image,title,description,ordering,published,albumid) values ('$imgfilename[2]',$title','$description','0','$published',$albumid)";
                $db->setQuery($query);
                $db->query();
                $ids[$i] = $db->insertid();
            }else{
                $query = "insert into #__macgallery_image(image,title,description,ordering,published,albumid,albcover) values ('$imgfilename[2]',$title','$description','0','$published',$albumid,'1')";
                $db->setQuery($query);
                $db->query();
                $ids[$i] = $db->insertid();
            }
                $albQuery="update #__macgallery_album set imgcount=imgcount+1 where id = '$albumid'";
                $db->setQuery($albQuery);
                $db->query();
            }
        } else {




            $title = $images['title'];
            $albumid = $images['albumid'];
            $description = $images['description'];
            $published = $images['published'];

            $imgfilename = explode("/",JRequest::getVar("image"));
            if(!isset($imgfilename[2]))
                    $imgfilename[2] = "";




            $query = "update #__macgallery_image set image = '$imgfilename[2]', title ='$title',description='$description',albumid='$albumid',published='$published' WHERE id = '$images[id]'";


            $db->setQuery($query);
            $db->query();
        }
    }

    function deleteimages($arrayIDs) {
        $query = "DELETE FROM #__macgallery_image WHERE id IN (" . implode(',', $arrayIDs) . ")";
        $db = $this->getDBO();
        $db->setQuery($query);
        $db->query();

        $albumid = JRequest::getVar('albumid');
        $decrement = count($arrayIDs);
        $countQuery="SELECT imgcount FROM #__macgallery_album WHERE id=".$albumid;
        $db->setQuery($countQuery);
        $imgCount=$db->loadResult();

        /* decrease image count during deletion of image(s)*/
        if($imgCount!= 0)
        {
            $albQuery="update #__macgallery_album set imgcount=imgcount-".$decrement." where id = ".$albumid;
            $db->setQuery($albQuery);
            $db->query();
        }
    }

    function pubimages($arrayIDs) {
        if ($arrayIDs['task'] == "publish") {
            $publish = 1;
        } else {
            $publish = 0;
        }
        $n = count($arrayIDs['cid']);
        $albumid = $images['albumid'][$i];
        for ($i = 0; $i < $n; $i++) {
            $query = "UPDATE #__macgallery_image set published=" . $publish . " WHERE id=" . $arrayIDs['cid'][$i];
            $db = $this->getDBO();
            $db->setQuery($query);
            $db->query();
        }
    }
    function coverimage(){
        $db = & JFactory::getDBO();
       $albumid = JRequest::getVar('albumid');

            $albumquery = "SELECT MIN(id) as id FROM #__macgallery_image WHERE albumid =".$albumid;
            $db->setQuery($albumquery);
            $result = $db->loadResult();
            $query1 = "update  #__macgallery_image set albcover=1 WHERE id = '$result' and albumid='$albumid'";
            $db->setQuery($query1);
            $db->query();

    }
}

?>
