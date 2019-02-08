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

class MacgalleryModelimages extends JModelLegacy {
    /* function for executing queries */

    function getData($pageid='', $itemid='') {
        global $option;
        $db = & JFactory::getDBO();

        $querySettings = "SELECT * FROM #__macgallery_settings";
        $db->setQuery($querySettings);
        $gallerySetting = $db->loadObjectList();

        $img_per_row = $gallerySetting[0]->rowimg;
        $no_of_row = $gallerySetting[0]->rows;
        $img_display = $gallerySetting[0]->imgdisplay;
        $effect_direction = $gallerySetting[0]->effect_direction;

        $albumid = JRequest::getvar('albumid', '', 'request', 'int');


        if ($albumid == 0)
            $where = 'where published=1';
        else
            $where = "where albumid='" . $albumid . "' and published=1";

        $imageQuery = "SELECT count(*) FROM #__macgallery_image " . $where;
        
        
        

        $db->setQuery($imageQuery);
        
        
        $imgTotal = $db->loadResult();


        $total = $imgTotal;
        
        
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

    /* execute above function to get image details */

    function getimages() {
        $images = $this->getData();
        return $images;
    }

    /* function to get details of album */
	function albumNameById($albumId){
    	$db = & JFactory::getDBO();
    	
    	$imgcountQuery = "SELECT albumname FROM `#__macgallery_album` WHERE `id` = '$albumId' ";
    	$db->setQuery($imgcountQuery);
    	
        $rows = $db->loadRow();       
        return $rows;
    }
    function getalbum() {
        global $option, $mainframe;
        $db = & JFactory::getDBO();
        $selectedAlbum = array();
        $album = array();
        $albumid = JRequest::getvar('albumid', '', 'request', 'int');

        $query = "SELECT Distinct(a.id),a.albumname,a.description,a.imgcount,a.created,b.image,b.albumid,b.published FROM #__macgallery_album as a left outer join #__macgallery_image as b on b.albumid = a.id and b.albcover = 1 where a.published=1 and a.id = $albumid  group by a.id ASC  ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $selectedAlbum = $rows;

        $query = "SELECT Distinct(a.id),a.albumname,a.description,a.imgcount,a.created,b.image,b.albumid,b.published FROM #__macgallery_album as a left outer join #__macgallery_image as b on b.albumid = a.id and b.albcover = 1 where a.published=1 and a.id <> $albumid group by a.id ASC  ";
        
        $db->setQuery($query);
        
        
        $rows = $db->loadObjectList();
        $album = $rows;
        $result = array_merge($selectedAlbum, $album);
       
        return $result;
    }

    //function for ajax loading of images

    function getajaxImages($pageid, $albumid) {
    	
        /* Execute required queries first */
        $images = $this->getData($pageid, $itemid);
        
        
        $rows = $images['rows'];
        $gallerySetting = $images['rsgallery'];
        $pages = $images['pages'];
        $pageno = $images['pageno'];
        
        
        

        /* load the data from queries */
        $totalImages = count($rows);
        $baseurl = JURI::base();
        
        
        $itemwidth = $gallerySetting[0]->thumbimgwidth;
        $maxwidth = $gallerySetting[0]->mouseover_width;
        $prox = $gallerySetting[0]->proximity;
        $albDisp = $gallerySetting[0]->alblist;
        $img_per_row = $gallerySetting[0]->rowimg;
        $no_of_row = $gallerySetting[0]->rows;
        $largewidth = $gallerySetting[0]->imgwidth;
        $largeheight = $gallerySetting[0]->imgheight;
        $thumbHeight = $gallerySetting[0]->thumbimgheight;
        $direction = $gallerySetting[0]->effect_direction;
        $thumbWidth = $gallerySetting[0]->thumbimgwidth;
        $imgdispstyle = $gallerySetting[0]->imgdispstyle;
        $api_key = $gallerySetting[0]->api_key;
        
        
        
        
        $total = count($rows);
        $totalimages = count($rows);
        $pr = MacgalleryClass::apiKey();

        if (($total / $img_per_row) < $no_of_row) {
            $no_of_row = ceil($total / $img_per_row);
        }
        $totalHeight = $thumbHeight + $thumbWidth;
        $preheight = (($totalHeight + 5) * $no_of_row);
        

        $alignment = 'left';
        $valign = 'top';
        $halign = 'center';

       

        echo '<style type="text/css">';

        /* style for normal image display */
        if ($imgdispstyle == 0)
            echo '.imgcorner{
            border-radius: 0px;
            -moz-border-radius :0px;
            -webkit-border-radius: 0px;
            }';

        /* style for rounded corners */
        else if ($imgdispstyle == 1)
            echo '.imgcorner{
            border-radius: 10px;
            -moz-border-radius :10px;
            -webkit-border-radius: 10px;
            }';

        /* style for winged image display */
        else if ($imgdispstyle == 2)
            echo '.imgcorner{
            border-top-left-radius: 2em 0.5em;
            border-top-right-radius: 1em 3em;
            border-bottom-right-radius: 4em 0.5em;
            border-bottom-left-radius: 1em 3em;

            -webkit-border-top-left-radius: 2em 0.5em;
            -webkit-border-top-right-radius: 1em 3em;
            -webkit-border-bottom-right-radius: 4em 0.5em;
            -webkit-border-bottom-left-radius: 1em 3em;

            -moz-border-radius-topleft: 2em 0.5em;
            -moz-border-radius-topright: 1em 3em;
            -moz-border-radius-bottomright 	: 4em 0.5em;
            -moz-border-radius-bottomleft: 1em 3em;
            }';
        /* style for round image display */
        else if ($imgdispstyle == 3)
            echo '.imgcorner{
            border-top-left-radius:4em;
            border-top-right-radius:4em;
            border-bottom-right-radius:4em;
            border-bottom-left-radius:4em;

            -moz-border-radius-topleft: 4em;
            -moz-border-radius-topright: 4em;
            -moz-border-radius-bottomright: 4em;
            -moz-border-radius-bottomleft: 4em;

            -webkit-border-top-left-radius:4em;
            -webkit-border-top-right-radius:4em;
            -webkit-border-bottom-right-radius:4em;
            -webkit-border-bottom-left-radius:4em;
            }';


        /* if direction set as Top */
        if ($direction == 0) {
            $position = "top:";
            $positionvalue = 0;
        } else
        /* if direction set as Bottom */ {
            $position = "bottom:";
            $positionvalue = ($itemwidth * $no_of_row);
        }


        for ($l = 1; $l <= $no_of_row; $l++) {
         echo '#dock' . $l . ' {
		                width: 100%;
		       }
            .dock-container' . $l . ' {
                position: absolute;
				height: 50px;
				padding-left: 20px;
            }';
         echo '.dock{ height:'.$itemwidth.'px;!important}';

            if ($direction == 0) {
                $positionvalue = $positionvalue + $itemwidth;
            } else {
                $positionvalue = $positionvalue - $itemwidth;
            }
        }
        
        
        
        
        echo '</style>';
        //getting values from images table
        $i = 0;
        
        
        
        foreach ($rows as $row) {
            $imageSource[$i]['image'] = $row->image;
            $albumname = $row->albumname;
            $imageSource[$i]['id'] = $row->id;
            $imageSource[$i]['title'] = $row->title;
            $imageSource[$i]['albumid'] = $row->albumid;
            $imageSource[$i]['thumbimage'] = $row->thumbimage;
            $imageSource[$i]['description'] = $row->description;
            $imageSource[$i]['aid'] = $row->albumid;
            $imageSource[$i]['published'] = $row->published;
            $imageSource[$i]['created'] = $row->created;
            $i++;
        }
        
              $paginationHeight = JRequest::getvar('pagination_height', '', 'request', 'int');
?>
<script>
apptha(document).ready(function() {
    apptha('a[rel*=facebox]').facebox();
  });
</script>
        <!-- Content to load during ajax pagination -->
        <div style="padding:10px;"> <h1 style="margin:0px;"> <?php echo $albumname; ?> </h1></div>
       
    <div id="macmain" class="clearfix">
        <div id="imgmain"  >
            <div> 
                <?php
                $m = $img_per_row - 1;
                 
				if(!$totalimages) echo "<div style='margin:10px;'>No images avaliable</div>";
				
				$imageCount = 0;
				$macdockcount = 1;
                /* following loop for rendering the images corectly according to direction */
                for ($j = $no_of_row; $j >= 1; $j--) {
                    $k = 1;
                    $s = $m;

                    if ($s >= $totalimages)
                        $s = $totalimages - 1;
                    if ($direction == 0) {
                        if ($total % $img_per_row != 0) {
                            $o = $total % $img_per_row;
                            if ($o == 0) {
                                $o = $img_per_row;
                            } else {
                                $s = $o - 1;
                            }
                            $m = $s;
                        }
                        else
                            $o = $img_per_row;
                    }
                    else {
                        if ($total % $img_per_row != 0) {
                            $o = $img_per_row;
                        } else {
                            $o = $total % $img_per_row;
                            if ($o == 0) {
                                $o = $img_per_row;
                            } else {
                                $s = $o - 1;
                            }
                            $m = $s;
                        }
                    }
                    if ($direction != 0) {
                        $u = $s - $img_per_row;
                        $topO = $total;
                        if ($u <= 0) {
                            $s = 0;
                        } else {
                            $s = ($m - $img_per_row) + 1;
                        }
                    }
                    
                ?>
                
                    <div class="dock" id="dock<?php echo $macdockcount; ?>" >
                        <div class="dock-container<?php echo $macdockcount; ?>">
                        <?php
                        
                        for ($i = $k; $i <= $total; $i++) {
                            $l = $totalImages - 1 - $s;

                            if ($k <= $o) {

                        ?>
                                <a class="dock-item" rel="facebox" href="<?php echo JURI::base(); ?>?option=com_macgallery&view=images&Itemid=53&format=raw&tmpl=component&imgid=<?php echo $imageSource[$s]['id']; ?>&ajax=1&albumid=<?php echo $imageSource[$s]['albumid']; ?>&limit=<?php echo $imageCount;?>"
                                style="cursor: pointer;background: none;border:none;" >
                                <div style="padding: 2px">
                                        <img class="imgcorner" title="<?php echo $imageSource[$s]['title']; ?>"
                                             src="<?php echo JURI::root(); ?>images/macgallery/thumb_image/<?php echo $imageSource[$s]['image']; ?>"  />
                                             <span>asdfasdf</span>
                                             </div>
                                   </a>
                                   
                                   
                            <?php
                                if ($direction == 0) {
                                    $s--;
                                } else {
                                    $s++;
                                }
                            } else {
                                $total = $total - $k + 1;
                                break;
                            } ?>

                        <?php
                            $k++;
                            $l++;
                            $imageCount++;

                        }
                        $macdockcount++;
                        ?>
                    </div>
                </div>
                
                <?php $m = $m + $img_per_row; ?>
                <script type="text/javascript">
                apptha(document).ready(
                		function()
                		{
                			apptha('#dock<?php echo $j; ?>').Fisheye(
                				{
                					maxWidth: <?php echo $gallerySetting[0]->mouseover_width ?>,
                					items: 'a',
                					itemsText: 'span',
                					container: '.dock-container<?php echo $j; ?>',
                					itemWidth: <?php echo $itemwidth; ?>,
                					proximity: <?php echo $prox; ?>,
                					halign : 'center'
                				}
                			)
                		});
                </script>
                
                        <script type="text/javascript">
                            //var offsetWidth = document.getElementById('imgwrapper').offsetWidth;
<?php if ($o < $img_per_row || $topO < $img_per_row) { 
                            if ($topO != '') {
                                $o = $topO;
                            }
?>
                //var left = offsetWidth - (<?php echo ($itemwidth * $o) ?>);
                //var leftPosition = Math.ceil((left - 72) / 2);

<?php } else { ?>
               // var left = offsetWidth - (<?php echo ($itemwidth * $img_per_row) ?>);
                //var leftPosition = Math.ceil((left - 72) / 2);
<?php } ?>

           // mac('#imgwrapper').prepend('<style>.dock-container<?php echo $j; ?>{position:absolute;left:'+leftPosition+'px !important}</style>')
                        </script>
<?php } ?>
     </div>
     
                
            </div>

    </div>
    
	<div id="pagination" style="width:100%;">
        <?php
        $q = $pageno - 1;
        if ($pageno > 1)
            echo '<div class="prev" onclick="changepage(' . $q . ',' . $albumid . ')"><img src="'.  $baseurl .'/components/com_macgallery/images/left.png" title="Prev" alt="Prev" width="26" height="29" /></div>';
        $p = $pageno + 1;
        if ($pageno < $pages)
            echo '<div class="next" onclick="changepage(' . $p . ',' . $albumid . ')"><img src="'.  $baseurl .'/components/com_macgallery/images/right.png" title="Next" alt="Next" width="26" height="29" /></div>';
        ?>
    </div>
    
<?php
        exit;
    }
    
    
    
    
    function getAlbumImageById($albumId,$limit){
    	$db = & JFactory::getDBO();
    	$query = "SELECT * FROM #__macgallery_image WHERE albumid = '$albumId' AND 	published = 1 LIMIT $limit,1 ";
        $db->setQuery($query);
        $db->query();
        $rows = $db->loadAssocList();      
    	return $rows;
    }
 	function getAlbumSingleImageById($albumId,$imgid){
    	$db = & JFactory::getDBO();
    	$query = "SELECT * FROM #__macgallery_image WHERE albumid = '$albumId' AND 	id='$imgid'  ";
        $db->setQuery($query);
        $db->query();
        $rows = $db->loadAssocList();      
    	return $rows;
    }
	function getAlbumTotalById($albumId){
    	$db = & JFactory::getDBO();
    	$query = "SELECT count(*) FROM #__macgallery_image WHERE albumid = '$albumId' AND 	published = 1 ";
        $db->setQuery($query);
        $db->query();
        $rows = $db->loadRow();      
    	return $rows;
    }
    function getAlbumList(){
    	$db = & JFactory::getDBO();
    	$query = "SELECT * FROM #__macgallery_album WHERE  	published = 1 ";
        $db->setQuery($query);
        $db->query();
        $rows = $db->loadAssocList();      
    	return $rows;
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