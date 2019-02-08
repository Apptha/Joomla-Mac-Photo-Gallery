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

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/* get site location */
$baseurl = JURI::base();

?>
<input type="hidden" id="appthaFaceboxClose1" value="<?php echo JURI::base().'components/com_macgallery/images/close.png' ?>" />
<input type="hidden" id="appthaFaceboxLoading1" value="<?php echo JURI::base().'components/com_macgallery/images/loadinfo.gif' ?>" />
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/jquery164.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/iutil.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/fisheye.js"></script>
<script  src="<?php echo JURI::root(); ?>modules/mod_macgallery/js/modulefacebox.js" type="text/javascript"></script>
<style type="text/css" >
.moduledock {margin-bottom:2px;height: 50px; text-align: center;}
.moduledock-container {position: absolute;height: 50px;padding-left: 20px;}
.moduledock-item img {border: none; margin: 5px 10px 0px; width: 100%; }
.moduledock-item span {display: none; padding-left: 20px;}
</style>

<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/facebox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/images.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/ie7/skin.css" type="text/css" media="screen" />
<script type="text/javascript">
var apptha = jQuery.noConflict();
apptha(document).ready(function() {
    apptha('a[rel*=facebox]').facebox()
  });
</script>
<?php
$i = 0;

$imagePerRow = $params->get( 'imagePerRow' );
$mouseOverWidth = $params->get( 'mouseOverWidth' );

/* get details of images */
$rows = $images['rows'];	
$pages = $images['pages'];
$pageno = $images['pageno'];
$totalImages = count($rows);


/* get details of gallery settings */
$galSetting = $images['rsgallery'];

$thumbHeight = $galSetting[0]->thumbimgheight;
$thumbWidth = $params->get( 'thumbwidth');

$itemwidth = $params->get( 'thumbwidth');
$maxwidth = $params->get( 'mouseOverWidth');

$mouseOverWidth = $params->get( 'mouseOverWidth');

$prox = $galSetting[0]->proximity;
$albDisplay = $galSetting[0]->alblist;
$img_per_row = $params->get( 'imagePerRow' );
$no_of_row = $galSetting[0]->rows;

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





$alignment = 'left';
$valign = 'bottom';
$halign = 'center';
?>
<style type="text/css">
.moduledock{
position: relative; 
height:<?php echo $itemwidth;  ?>px;

}
a.moduledock-item {
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
</style>

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

		    echo '#moduledock' . $l . ' {
		                width: 100%;';
		    
		       echo '}
            .moduledock-container' . $l . ' {
                position: absolute;
				height: 50px;
				padding-left: 20px;
			    '.$position.' 0px;
            }
            ';
		       
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
?>

<div id="imgwrapper" style="border:none">
    <div id="macmain1" class="clearfix">
        <div id="imgmain1"  >
            <div style="margin-top:15px"> 
                <?php
                $m = $img_per_row - 1;
                 
				if(!$totalimages) echo "<div style='margin:10px;'>No images avaliable</div>";
				
				$imageCount = 0;
				$macdockcount = 1;
				$direction = 1;
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
                
                    <div class="moduledock" id="moduledock<?php echo $macdockcount; ?>" >
                        <div class="moduledock-container<?php echo $macdockcount; ?>">
                        <?php
                        
                        for ($i = $k; $i <= $total; $i++) {
                            $l = $totalImages - 1 - $s;

                            if ($k <= $o) {

                        ?>
                                <a class="moduledock-item" rel="facebox" href="<?php echo JURI::base(); ?>?option=com_macgallery&view=images&Itemid=53&tmpl=component&ajax=1&imgid=<?php echo $imageSource[$s]['id']; ?>&albumid=<?php echo $imageSource[$s]['albumid']; ?>&limit=<?php echo $imageCount;?>"  
                                style="cursor: pointer;background: none;border:none;" >
                                <div style="margin: 3px;">
                                        <img class="appthaimgcorner"  title="<?php echo $imageSource[$s]['title']; ?>"  
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
                			apptha('#moduledock<?php echo $j; ?>').Fisheye(
                				{
                					maxWidth: <?php echo $mouseOverWidth; ?>,
                					items: 'a',
                					itemsText: 'span',
                					container: '.moduledock-container<?php echo $j; ?>',
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
                            var offsetWidth = document.getElementById('imgwrapper').offsetWidth;
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
            </div>
    </div>
</div>
                <input type="hidden" id="appthaBaseUrl" value="<?php echo JURI::root(); ?>" />
                
<div class="appthafacebox-opacity" id="popup_overlay"></div>
<span id="appthaModuleFacebox"></span>