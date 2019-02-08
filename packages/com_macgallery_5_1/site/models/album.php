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

class MacgalleryModelalbum extends JModelLegacy {
    /* function for executing queries */

    function getData($pageid='', $itemid='') {

        global $option, $mainframe, $Itemid;
        $mainframe = JFactory::getApplication();
        $db = & JFactory::getDBO();
        $query = "SELECT count(id) as id FROM #__macgallery_album WHERE published =1 ";
        $db->setQuery($query);
        $rows = $db->loadObject();
                
        $albumCountArray = $this->albumCount();
        
        $total = $albumCountArray[0];
        $params = & $mainframe->getParams();
        $sub = $total;
        if ($pageid != '')
            $pageno = $pageid;
        else
            $pageno = 1;

        $length = 3;

        $pages = ceil($total / $length);
        if ($pageno == 1) {
            $start = 0;
        } else {
            $start = ( $pageno - 1) * $length;
        }
        //$query = "SELECT Distinct(a.id),a.albumname,a.description,a.imgcount,a.created,b.image FROM #__macgallery_album as a left outer join #__macgallery_image as b on b.albumid = a.id  where a.published=1 group by a.id ASC LIMIT $start,$length ";
        
        global $option, $mainframe;
        $db = & JFactory::getDBO();
        $selectedAlbum = array();
        $album = array();
        $albumid = JRequest::getvar('albumid', '', 'request', 'int');

        $query = "SELECT Distinct(a.id),a.albumname,a.description,a.imgcount,a.created,b.image,b.albumid,b.published FROM #__macgallery_album as a left outer join #__macgallery_image as b on b.albumid = a.id and b.albcover = 1 where a.published=1 and a.id = $albumid  group by a.id DESC   ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $selectedAlbum = $rows;

        $query = "SELECT Distinct(a.id),a.albumname,a.description,a.imgcount,a.created,b.image,b.albumid,b.published FROM #__macgallery_album as a left outer join #__macgallery_image as b on b.albumid = a.id and b.albcover = 1 where a.published=1 and a.id <> $albumid group by a.id DESC   ";
        
        $db->setQuery($query);
        
        
        $rows = $db->loadObjectList();
        $album = $rows;
        $result = array_merge($selectedAlbum, $album);
        
        
        //$db->setQuery($query);
        //$rows = $db->loadObjectList();
        
        
        
        
        
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        $images = array('rows' => $result, 'option' => $option, 'total' => $total, 'length' => $length, 'pages' => $pages, 'pageno' => $pageno, 'params' => $params);
        return $images;
    }
    function imgCount($albumId){
    	$db = & JFactory::getDBO();
    	
    	$imgcountQuery = "SELECT count(*) as imgcount FROM `#__macgallery_image` WHERE `albumid` = $albumId AND `published` = '1' ";
    	$db->setQuery($imgcountQuery);
    	
        $rows = $db->loadRow();       
        return $rows;
    }
    //album count
	function albumCount(){
    	$db = & JFactory::getDBO();
    	
    	$imgcountQuery = "SELECT count(*) as albumcount FROM `#__macgallery_album` WHERE `published` = '1' ";
    	$db->setQuery($imgcountQuery);
    	
        $rows = $db->loadRow();       
        return $rows;
    }

    /* function to get details of album */

    function getalbum() {
        $images = $this->getData();
        return $images;
    }

    /* function for ajax pagination */

    function getajaxAlbum($pageid, $itemid) {

        $images = $this->getData($pageid, $itemid);
        $rows = $images['rows'];
        $pageno = $images['pageno'];
        $pages = $images['pages'];

        $i = 0;
        foreach ($rows as $row) {
            $albumSource[$i]['name'] = $row->albumname;
            $albumSource[$i]['id'] = $row->id;
            $albumSource[$i]['des'] = $row->description;
            $thumbimage[$i]['thumbimage'] = $row->thumbimage;
            $albumSource[$i]['imgcount'] = $row->imgcount;
            $albumSource[$i]['created'] = $row->created;
            $i++;
        }

        ob_clean();
        $itemId = $itemid;
        $baseurl = JURI::base();
?>

        <!-- content to load during ajax pagination -->
        <div id="macgallery" >
            
    <?php
        for ($i = 0; $i < count($rows); $i++) {
            echo '<div class="album"><a style="text-decoration:none" href="' . $baseurl . 'index.php?option=com_macgallery&view=images&albumid=' . $albumSource[$i]['id'] . '&Itemid=' . $itemId . '" title="' . $albumSource[$i]['name'] . '">';
            echo '<img class="curved" title="' . $albumSource[$i]['name'] . '" src="' . $baseurl . 'components/com_macgallery/images/uploads/';
            if ($thumbimage[$i]['thumbimage'] != '') {
                echo $thumbimage[$i]['thumbimage'];
            } else {
                echo 'star.jpeg';
            }
            echo '" alt="" width="150" height="180" />';
            echo '<h3>';

            if (strlen(urldecode($albumSource[$i]['name'])) > 20) {
                echo substr(urldecode($albumSource[$i]['name']), 0, 17) . "...";
            } else {
                echo urldecode($albumSource[$i]['name']);
            }
            echo '</h3></a><p>';

            if (strlen(urldecode($albumSource[$i]['des'])) > 30) {
                echo substr(urldecode($albumSource[$i]['des']), 0, 29) . "...";
            } else {
                echo urldecode($albumSource[$i]['des']);
            }
            echo '</p><span class="date">' . date('d-m-Y', strtotime($albumSource[$i]['created'])) . '</span><span class="photos">' . $albumSource[$i]['imgcount'] . '</span></div>';
        } ?>
    </div>
    <div class="clear"></div>

    <div class="pagination">
    <?php
        $q = $pageno - 1;

        if ($pageno > 1)
            echo '<div class="button prev" onclick="changepage(' . $q . ',' . $itemId . ')"><img src="' . $baseurl . '/components/com_macgallery/images/left.png" title="Prev" alt="Prev" width="26" height="29" /></div>';

        $p = $pageno + 1;

        if ($pageno < $pages)
            echo '<div class="button next" onclick="changepage(' . $p . ',' . $itemId . ')"><img src="' . $baseurl . '/components/com_macgallery/images/right.png" title="Next" alt="Next" width="26" height="29" /></div>';
    ?>
    </div>
<?php
        exit;
    }
    function getFirstImageAlbum($albumId){
    	$db = & JFactory::getDBO();
    	
    	$getFirstImageQuery = "SELECT image  FROM `#__macgallery_image` WHERE `albumid` = '$albumId' AND `published` = '1' ";
    	$db->setQuery($getFirstImageQuery);
    	
        $rows = $db->loadRow();       
        return $rows;
    }
}
?>
