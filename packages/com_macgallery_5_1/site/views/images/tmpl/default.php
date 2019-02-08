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



/* get site location */
$baseurl = JURI::base();

?>
<?php if(JRequest::getInt("counter") == "0"): ?>
<input type="hidden" id="appthaFaceboxClose" value="<?php echo JURI::base().'components/com_macgallery/images/close.png' ?>" />
<input type="hidden" id="appthaFaceboxLoading" value="<?php echo JURI::base().'components/com_macgallery/images/loadinfo.gif' ?>" />

<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/jquery164.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/iutil.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/fisheye.js"></script>
<script  src="<?php echo $baseurl ?>components/com_macgallery/js/jquery.jcarousel.js" type="text/javascript"></script>
<script  src="<?php echo $baseurl ?>components/com_macgallery/js/facebox.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/mac-dock.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/facebox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/images.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/ie7/skin.css" type="text/css" media="screen" />
<script>
var apptha =jQuery.noConflict();
apptha(document).ready(function() {
    apptha('a[rel*=facebox]').facebox()
  });
</script>
<?php endif; ?>

<?php






$i = 0;

/* get details of images */
$rows = $this->images['rows'];



$pages = $this->images['pages'];
$pageno = $this->images['pageno'];
$totalImages = count($rows);


/* get details of gallery settings */
$galSetting = $this->images['rsgallery'];

$thumbHeight = $galSetting[0]->thumbimgheight;
$thumbWidth = $galSetting[0]->thumbimgwidth;

$itemwidth = $galSetting[0]->thumbimgwidth;
$maxwidth = $galSetting[0]->thumbimgwidth;

$mouseOverWidth = $galSetting[0]->mouseover_width;

$prox = $galSetting[0]->proximity;
$albDisplay = $galSetting[0]->alblist;
$img_per_row = $galSetting[0]->rowimg;

if(JRequest::getInt("plgCols") > 0){
	$img_per_row = JRequest::getInt("plgCols");	
}

$no_of_row = $galSetting[0]->rows;

if(JRequest::getInt("plgrows") > 0){
	$no_of_row = JRequest::getInt("plgrows");	
}

$direction = $galSetting[0]->effect_direction;

$imgdispstyle = $galSetting[0]->imgdispstyle;
$api_key = $galSetting[0]->api_key;


$total = $totalImages;
$totalimages = $totalImages;

$heightTotal = $no_of_row * $thumbHeight + (2 * $no_of_row) + 70 . 'px';
$thumbimg = $thumbHeight - 20 . 'px';
$thumbimgHeight = $thumbHeight - 20 . 'px';

if (($total / $img_per_row) < $no_of_row) {
    $no_of_row = ceil($total / $img_per_row);
}
$totalHeight = $thumbHeight + $thumbWidth;
$preheight = (($totalHeight + 5) * $no_of_row);

$heightMacmain = $no_of_row * $thumbHeight;
$pr = MacgalleryClass::apiKey();

//getting album details
$albRows = $this->albums;



$alignment = 'left';
$valign = 'bottom';
$halign = 'center';
?>
<style>
<?php if(JRequest::getInt("counter") > 0): ?>
#imgwrapper<?php echo JRequest::getInt("counter") ?>{border: 1px solid #CCCCCC;height: auto;margin: 0 0 8px;padding: 10px;}
<?php endif; ?>
table.nopad{table-layout: fixed;}
.dock{
height:<?php echo $itemwidth;  ?>px;
}
a.dock-item {
	display: block;
	width: 40px;
	color: #000;
	position: absolute;
	<?php if($direction=="1"): ?>
	bottom: 0px;
	<?php else: ?>
	top: 0px;
	<?php endif; ?>
	
	text-align: center;
	text-decoration: none;
	font: bold 12px Arial, Helvetica, sans-serif;
}
#main{
 height: inherit;
}
</style>
<?php if ($imgdispstyle == 1){ ?>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/jquery.corner.js"></script>
<script type="text/javascript">
apptha("#dock-item img").corner();
</script>
<?php  } ?>



<?php
echo '<style type="text/css">';

/* Normal image display style */
if ($imgdispstyle == 0)
    echo '.appthaimgcorner{
            border-radius: 0px;
            -moz-border-radius :0px;
            -webkit-border-radius: 0px;
            }';

/* Rounded corner image display style */
else if ($imgdispstyle == 1)
    echo '.appthaimgcorner{
            border-radius: 10px;
            -moz-border-radius :10px;
            -webkit-border-radius: 10px;
            }';

/* Winged display style */
else if ($imgdispstyle == 2)
    echo '.appthaimgcorner{

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

/* Rounded  image display  */
else if ($imgdispstyle == 3)

    
    echo '.appthaimgcorner{
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


/* if direction is top */
if ($direction == 0) {
    $position = "top:";
    $positionvalue = 0;
}
/* if direction is bottom */ else {
    $position = "bottom:";
    $positionvalue = ($itemwidth * $no_of_row);
}


$zIndex = $no_of_row;

for ($l = 1; $l <= $no_of_row; $l++) {


    if(JRequest::getInt("counter") == "0"){
    		    echo '#dock' . $l . ' {
		                width: 100%;';
		    echo '}
                            .dock-container' . $l . ' {
                            position: absolute;
                            height: 50px;
                            padding-left: 20px;
                            '.$position.' 0px;
                            }';
    }
    else{
             echo ' #dock'.JRequest::getInt("counter")."_". $l . ' {
		                width: 100%;';
             echo '}
                             .dock-container'.$l."_".JRequest::getInt("counter"). ' {
                            position: absolute;
                            height: 50px;
                            padding-left: 20px;
                            '.$position.' 0px;
                            }';
    }
		       
		$zIndex --;
    if ($direction == 0) {
        $positionvalue = $positionvalue + $itemwidth;
    } else {
        $positionvalue = $positionvalue - $itemwidth;
    }
}
echo '</style>';

//getting values from images table

$i = 0;
$albumname = '';


foreach ($rows as $row) {
    $imageSource[$i]['image'] = $row->image;
    $albumname = $row->albumname;
    $albumDesc = $row->description;
    $imageSource[$i]['id'] = $row->id;
    $imageSource[$i]['title'] = $row->title;
    $imageSource[$i]['albumid'] = $row->albumid;
    $imageSource[$i]['thumbimage'] = $row->image;
    $imageSource[$i]['description'] = $row->description;
    $imageSource[$i]['aid'] = $row->albumid;
    $imageSource[$i]['published'] = $row->published;
    $i++;
}



if (($albDisplay == 0) || (count($albRows)) == 0) {
    $style = "style='width:100%;float:left;height:$heightTotal'";
} else {
    $style = "style='float:left;height:$heightTotal;width:100%'";
}
?>

<div id="imgwrapper<?php echo (JRequest::getInt("counter")> 0) ? JRequest::getInt("counter") : ""; ?>">
    <div id="macmain<?php echo (JRequest::getInt("counter")> 0) ? JRequest::getInt("counter") : ""; ?>" class="clearfix">
        <div id="imgmain<?php echo (JRequest::getInt("counter")> 0) ? JRequest::getInt("counter") : ""; ?>"  >
            <div style="padding: 10px;"> <h1 style="margin:0px;"> <?php echo  (isset($this->albums[0]->albumname))? $this->albums[0]->albumname :""; ?> </h1></div>

            <div style="margin-top:15px"> 
                <?php
                $m = $img_per_row - 1;
                 
				if(!$totalimages) echo "<div style='margin:10px;'>No images avaliable</div>";
				
				$imageCount = 0;
				$macdockcount = 1;
				$direction = 1;
                /* following loop for rendering the images corectly according to direction */
                                 $galleryImage = 0;
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
                
                    <div class="dock" id="dock<?php echo $macdockcount; ?><?php echo (JRequest::getInt("counter")> 0) ? '_'.JRequest::getInt("counter") : ""; ?>" >
                        <div class="dock-container<?php echo $macdockcount; ?><?php echo (JRequest::getInt("counter")> 0) ? '_'.JRequest::getInt("counter") : ""; ?>">
                        <?php
                        
                        for ($i = $k; $i <= $total; $i++) {
                            $l = $totalImages - 1 - $s;

                            if ($k <= $o) {

                        ?>
                                <a class="dock-item" rel="facebox" href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&Itemid=53&format=raw&tmpl=component&ajax=1&imgid='.$imageSource[$s]['id']); ?>&albumid=<?php echo $imageSource[$s]['albumid']; ?>&limit=<?php echo $imageCount;?>"
                                style="cursor: pointer;background: none;border:none;" >
                                <div style="padding: 2px">
                                        <img class="appthaimgcorner"  title="<?php echo $imageSource[$s]['title']; ?>"  
                                             src="<?php echo JURI::root(); ?>images/macgallery/thumb_image/<?php echo $imageSource[$galleryImage]['image']; ?>"  />
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
                            $galleryImage++;

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
                			apptha('#dock<?php echo $j; ?><?php echo (JRequest::getInt("counter")> 0) ? '_'.JRequest::getInt("counter") : ""; ?>').Fisheye(
                				{
                					maxWidth: <?php echo $mouseOverWidth; ?>,
                					items: 'a',
                					itemsText: 'span',
                					container: '.dock-container<?php echo $j; ?><?php echo (JRequest::getInt("counter")> 0) ? '_'.JRequest::getInt("counter") : ""; ?>',
                					itemWidth: <?php echo $itemwidth; ?>,
                					proximity: <?php echo $prox; ?>,
                					alignment : '<?php echo $alignment; ?>',
								    valign: '<?php echo $valign; ?>',
                			        halign : '<?php echo $halign; ?>'
                				}
                			)
                		});
                </script>
                
                        <script type="text/javascript">
                            var offsetWidth = document.getElementById('imgwrapper<?php echo (JRequest::getInt("counter")> 0) ? JRequest::getInt("counter") : ""; ?>').offsetWidth;
<?php if ($o < $img_per_row || $topO < $img_per_row) { 
                            if ($topO != '') {
                                $o = $topO;
                            }
?>
                var left = offsetWidth - (<?php echo ($itemwidth * $o) ?>);
                var leftPosition = Math.ceil((left - 72) / 2);

<?php } else { ?>
                var left = offsetWidth - (<?php echo ($itemwidth * $img_per_row) ?>);
                var leftPosition = Math.ceil((left - 72) / 2);
<?php } ?>
                        </script>
<?php } ?>
     </div>
     
     
     
     <?php if(JRequest::getInt('plg') !="1"): ?>
                <div id="pagination" style="width:100%;"><?php
                
                    $albumid = JRequest::getvar('albumid', '', 'request', 'int');
                    

                    $q = $pageno - 1;
                    if ($pageno > 1)
                        echo '<div class="prev" onclick="changepage(' . $q . ',' . $albumid . ')"><img src="' . $baseurl . 'components/com_macgallery/images/left.png" title="Prev" alt="Prev" width="26" height="29" /></div>';
                    $p = $pageno + 1;
                    if ($pageno < $pages)
                        echo '<div class="next" onclick="changepage(' . $p . ',' . $albumid . ')"><img src="' . $baseurl . 'components/com_macgallery/images/right.png" title="Next" alt="Next" width="26" height="29" /></div>';
?>
                </div>
	<?php endif; ?> 
                
                
                
                
                
            </div>
            <?php if(JRequest::getInt('plg') !="1"): ?>
            <div id="macshow">
            <?php if((isset($this->albums[0]->description)) &&  $this->albums[0]->description !="" ): ?>
                <h3><?php echo JText::_('COM_MACGALLERY_DESCRIPTION') ?>:</h3>
				<?php echo $this->albums[0]->description;  ?>
				<?php endif; ?>
            </div>
            <?php endif; ?>

        


<?php if (($albDisplay == 1) && count($albRows) != '0' && JRequest::getInt('plg') !="1") {
?>
                        <div id="album" style="width:100%;float:left;">
                            <div class="album_carosole">
                                <h2><?php echo JText::_('COM_MACGALLERY_ALBUMS') ?></h2>
                                <div id="wrap" align="center" class="mac_slider"><div id="carousel_main" >
                                        
                                        
                                          <ul id="mycarousel" class="jcarousel-skin-tango" style="text-align: center;">
										   
                                        
<?php
                        $i = 0;

                       
                        foreach ($albRows as $row) {
?>
                            <li >
                                    <a  
                                       href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $row->id); ?>"
                                   title="<?php echo $row->albumname; ?>">
                                    
                                        <img 
                                             title="<?php echo $row->albumname; ?>"
                                             src="<?php
						                                if ($row->image != '' && $row->published ) {
						                                    echo JURI::base()."images/macgallery/medium_image/".$row->image;
						                                } else {
						                                    $model = &$this->getModel('images');
										                	$firstImageName = $model->getFirstImageAlbum($row->id);
										                	if($firstImageName[0])
										                      	echo JURI::base().'images/macgallery/'.$firstImageName[0];
										                    else 
										                    	echo JURI::base().'components/com_macgallery/images/uploads/coverimage.png';
						                                } ?>"
                                             alt=""  height="100" width="100" style="margin:0px;padding: 0px;"/>

                                </a>
                            </li>
<?php
                                $i = $i + 1;
                            }
?>
                        </ul></div>
                </div>
            </div>
        </div>
<?php } ?>

        <?php echo $pr; ?>
    </div>
</div>



<?php if(JRequest::getInt("counter") == "0"): ?>
                <input type="hidden" id="appthaBaseUrl" value="<?php echo JURI::root(); ?>" />
                
                
                <script type="text/javascript">

function mycarousel_itemLoadCallback(carousel, state)
{
    // Check if the requested items already exist
    if (carousel.has(carousel.first, carousel.last)) {
               return;
    }

    apptha.get(
    			'<?php echo JURI::base()."?index.pgp"  ?>',
        {
            first: carousel.first,
            last: carousel.last
           
        },
        function(xml) {
            mycarousel_itemAddCallback(carousel, carousel.first, carousel.last, xml);
        },
        'xml'
    );
};

function mycarousel_itemAddCallback(carousel, first, last, xml)
{
    // Set the size of the carousel
    carousel.size(parseInt(apptha('total', xml).text()));
    apptha('image', xml).each(function(i) {
        carousel.add(first + i, mycarousel_getItemHTML(apptha(this).text()));
    });
};

/**
 * Item html creation helper.
 */
function mycarousel_getItemHTML(url)
{
    return '<img src="' + url + '" width="75" height="75" alt="" />';
};	
apptha('#mycarousel').jcarousel({
        // Uncomment the following option if you want items
        // which are outside the visible range to be removed
        // from the DOM.
        // Useful for carousels with MANY items.

        // itemVisibleOutCallback: {onAfterAnimation: function(carousel, item, i, state, evt) { carousel.remove(i); }},
});
function changepage(pageno,albumid)
{       
	apptha('#fbmain').remove();
    doAjax('index.php?option=com_macgallery&view=images&','albumid='+albumid+'&mode=ajax&pageid='+pageno+'&total_width='+offsetWidth+'&pagination_height=<?php echo $heightMacmain; ?>','getitem','post');
}
function getitem(item)
{
    if(item)
    {
        document.getElementById('imgmain').innerHTML=item;
        var imgmain = document.getElementById('imgmain'); 
        scripts = imgmain.getElementsByTagName("script");
        for(var i=0;i<scripts.length-1;i++){
            eval(scripts[i].innerHTML);
        }
    }
}
</script>


<div class="appthafacebox-opacity" id="popup_overlay"></div>
<?php endif; ?>