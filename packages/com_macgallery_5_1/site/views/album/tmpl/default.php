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

                    
/* No direct acess */

defined('_JEXEC') or die('restricted access');
jimport('joomla.application.component.view');

/* get location of site */
$baseurl = JURI::base();
$pr = MacgalleryClass::apiKey();
?>

<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $baseurl ?>components/com_macgallery/js/jquery-1.6.4.min.js"></script>
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $baseurl ?>components/com_macgallery/css/album.css" type="text/css" media="screen" />

<div id="albwrapper">
    <div id="ajax_content_box" style="margin-bottom: 10px;">
        <?php
        global $Itemid;

        // $itemid = "";
        (JRequest::getVar('itemid')) ? $itemid = JRequest::getVar('itemid') : $itemid = $Itemid;

        /* get details of album */
        $rows = $this->album['rows'];
        $option = $this->album['option'];
        $total = $this->album['total'];
        

        $pageno = $this->album['pageno'];
        $pages = $this->album['pages'];
        $params = $this->album['params'];

        $i = 0;
		
        
        
        foreach ($rows as $row) {
        	
        	$albumSource[$i]['published'] = $row->published;
            $albumSource[$i]['name'] = $row->albumname;
            $albumSource[$i]['id'] = $row->id;
            $albumSource[$i]['des'] = $row->description;
            $thumbimage[$i]['image'] = $row->image;
            $albumSource[$i]['imgcount'] = $row->imgcount;
            $albumSource[$i]['created'] = $row->created;
            $i++;
        }
        ?>

        <?php
        if ($params->get('page_title') != '') {
            echo '<div class="componentheading' . $params->get('pageclass_sfx') . '" >' . $params->get('page_title') . '</div>';
        }
        
        ?>       
            <div id="macgallery"  >
                <?php
                for ($i = 0; $i < count($rows); $i++) {
                	
                ?>
                <span style="display: inline-block;vertical-align: top;margin-left: 5px">
                    <div class="album" id="idAlbum<?php echo $i; ?>"  >
                        <a  style="text-decoration:none;border:none;background: none;"
                           href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $albumSource[$i]['id']); ?>"
                           title="<?php echo $albumSource[$i]['name']; ?>">
	
                            <img style="vertical-align: bottom;"  class="curved"
                            
                                 title="<?php echo $albumSource[$i]['name']; ?>"
                                  src="<?php
										if ($thumbimage[$i]['image'] != ''  && $albumSource[$i]['published'] == "1"  ) {
						                      echo JURI::base()."images/macgallery/medium_image/".$thumbimage[$i]['image'];
						                } else {
						                	$model = &$this->getModel('album');
						                	$firstImageName = $model->getFirstImageAlbum($albumSource[$i]['id']);
						                	if($firstImageName[0])
						                      	echo JURI::base().'images/macgallery/'.$firstImageName[0];
						                    else 
						                    	echo JURI::base().'components/com_macgallery/images/uploads/coverimage.png';
						                } ?>"
                   
                             alt="" width="160" height="180" />
                            </a>
                       </div>
                        <p  style="margin-left:10px;margin-bottom:0px;margin-top:0px; width: 155px;font-weight: bold;text-align: justify;color:#666666 !important">
                        	<a style="font-weight: bold;text-decoration:none;border:none;background: none; color: #666666 !important;"
                           			href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $albumSource[$i]['id']); ?>" >
                            <?php echo urldecode($albumSource[$i]['name']); ?>
                            </a>
                        </p>
                    
                            <p class="date" style="margin-left:10px;margin-top:0px;margin-bottom:0px;margin-top:0px;width: 155px" >
	                            <a style="text-decoration:none;border:none;background: none; color: #666666 !important;"
                           			href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $albumSource[$i]['id']); ?>"
                           			>
                            	<?php echo date('M j, Y', strtotime($albumSource[$i]['created'])); ?>
                            	</a>                            
                            </p>
                            <div class="clear"></div>
                            <p class="date" style="margin-left:10px;margin-top:0px;width: 155px;">
                            <a style="text-decoration:none;border:none;background: none; color: #666666 !important;"
                           			href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $albumSource[$i]['id']); ?>"
                           			>Photos:
                            		<b><?php
                            			$model = &$this->getModel('album');
                            			$imgcount =  $model->imgCount($albumSource[$i]['id']);
                            			echo (isset($imgcount[0]))? $imgcount[0] :"0";
                            	  	?>
                            	  	</b>
                            	  </a>
                            </p>
                    </span>
                <?php 
                
                } ?>
                    </div>
                    
                    
                    <div class="clear"></div>
                    <div class="pagination" style="display: none">

                <?php
                        /* pagination code */
                        $q = $pageno - 1;
                        if ($pageno > 1)
                            echo '<div class="button prev" onclick="changepage(' . $q . ',' . $itemid . ')">prev</div>';

                        $p = $pageno + 1;
                        if ($pageno < $pages)
                            echo '<div class="button next" onclick="changepage(' . $p . ',' . $itemid . ')">Next</div>';
                ?>

                    </div>
            </div>
    <?php echo $pr; ?>
</div>

<script type="text/javascript">
    function changepage(pageno,itemid)
    {
        doAjax('index.php?option=com_macgallery&view=album&','Itemid='+itemid+'&mode=ajax&pageid='+pageno,'getvideoresult','post');
    }

    function getvideoresult(item)
    {
        if(item)
        {
            document.getElementById('imagecollection').innerHTML=item;
        }
    }
	function toggleMore(id){
		$(".album").css("width","23%");
		$("#idAlbum"+id).css("width","100%");	
		
		$(".classMoreDesc [id!='maxdesc"+id+"'] ").hide();
		$("#maxdesc"+id).toggle("slow");
        $("#mindesc"+id).toggle("slow");
	}
    
</script>


