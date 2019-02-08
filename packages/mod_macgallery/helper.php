<?php
/*
 * **********************************************************

 * Component Name: Mac-Dock Gallery
 * Description: Mac dock photo gallery component for Joomla 3.0
 * Version: 1.5
 * Edited By: Sameera
 * Author URI: http://www.apptha.com/
 * Date : November 20 2012

 * *********************************************************

  @Copyright Copyright (C) 2012-2013 Apptha Support
  @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 * ******************************************************** */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.html.parameter' );


class modMacgalleryHelper
{
	function getimages($params){

        global $option;
        $db = & JFactory::getDBO();

        $querySettings = "SELECT * FROM #__macgallery_settings";
        $db->setQuery($querySettings);
        $gallerySetting = $db->loadObjectList();

        $img_per_row = $gallerySetting[0]->rowimg;
        $no_of_row = $gallerySetting[0]->rows;
        $img_display = $gallerySetting[0]->imgdisplay;
        $effect_direction = $gallerySetting[0]->effect_direction;

        $albumid = $params->get( 'albumid','1');



        if ($albumid == 0)
            $where = 'where published=1';
        else
            $where = "where albumid='" . $albumid . "' and published=1";

        $imageQuery = "SELECT count(*) FROM #__macgallery_image " . $where;


        $db->setQuery($imageQuery);


        $imgTotal = $db->loadResult();


        $total = $imgTotal;
        $pageid = "";

        if ($pageid != '') {
            $pageno = $pageid;
        } else {
            $pageno = 1;
        }
        $length = $no_of_row * $img_per_row;

        $pages = ceil($total / $length);

        if ($pageno == '1')
            $start = 0;
        else
            $start = ($pageno - 1) * $length;

        if (($pageno * $length) > $total) {
            $length = abs($total - (($pageno - 1) * $length) );
            $start = 0;
        } else {
            $start = $total - ($pageno * $length);
        }
        if ($effect_direction == 1)
            $order = "asc";
        else
            $order = "desc";


        // $img_display to display images in random or order...
        $where = '';

        /* display in order */
        if ($img_display == 1) {
            if ($albumid == 0)
                $where = 'order by ordering ' . $order . ' LIMIT ' . $start . ',' . $length;
            else
                $where = 'and a.albumid=' . $albumid . ' order by ordering ' . $order . ' LIMIT ' . $start . ',' . $length;

        }
        /* display randomly */
        elseif ($img_display == 0) {
            if ($albumid == 0)
                $where = 'order by RAND() LIMIT ' . $start . ',' . $length;

            else
                $where = 'and a.albumid="' . $albumid . '"order by RAND() LIMIT ' . $start . ',' . $length;
        }

        $query = "SELECT a.*,b.albumname,b.description as album_description FROM #__macgallery_image as a left join #__macgallery_album as b on a.albumid=b.id WHERE a.published =1 and b.published=1 " . $where;

        $db->setQuery($query);
        $rows = $db->loadObjectList();



        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $images = array('rows' => $rows, 'option' => $option, 'rsgallery' => $gallerySetting, 'length' => $length, 'total' => $total, 'pages' => $pages, 'pageno' => $pageno);
        return $images;
	}
}
?>