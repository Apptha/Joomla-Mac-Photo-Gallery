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
$galSetting = $this->images['rsgallery'];
$api_key = '';
$api_key = $galSetting[0]->api_key;


//this is testing
?>
<script src="http://connect.facebook.net/en_US/all.js#appId=<?php echo $api_key;  ?>&amp;xfbml=1"></script>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<?php

$pr = MacgalleryClass::apiKey();

$row= $this->albums[0];

$total = $this->albumTotal[0];

$limit = JRequest::getInt("limit"); 


$next = $limit  + 1;

$prev = $limit - 1;

if($next >= $total){
	$next = $limit;
}

if($prev<0){
	$prev = -1;
}
?>
<style type="text/css">
.rt-block{padding:0 !important}
.rt-container{width :100%}
#main{padding:0px;}
#macmain{display: block;}
.floatleft {float:left;}
.floatright{float:right;}
.clear{clear:both;}
.download{width:60px;}
.share-font a{color: #3B5998;font-family: tahoma;font-weight: normal;text-decoration: underline;}
.fb-title{padding: 10px 10px 0 0px;font-size: 12px;color: #3B5998;font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-weight: bold;}
.border-bottom {border-bottom:1px solid #ccc;}
.fb-date{color: #666;
font-family: tahoma;
font-weight: normal;}
#facebox .footer {border:none;}
.fbcomment{text-align:center;padding:10px 0 0 30px;}
.fb-left{width:25%; float:left;margin-left:10px}
.fb-right{float:left;width:25%;}
.fb-center{width:50%;float:left;}
.mac-whole-content{width:1000px; }
.mac-gallery-image{}
.fb-desc{color: #666666;font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 12px;font-weight: normal;padding: 0 10px 10px 0;width: 600px;word-wrap: break-word;}
.left-arrow,right-arrow{width:10%;vertical-align:middle;}
.right-arrow a{}
.top-content{background-color: black;float: left;width: 100%;}
.clearfix{display: inline-block;}
.clearfix after {content: ".";display: block;clear: both;visibility: hidden;line-height: 0;height: 0;}
.mac-close-image a{float:right;padding:10px 10px 0 0;}
.mac-close-image{background-color:black !important;}
.fb-desc-head{color: #3B5998;font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 12px;font-weight: bold;padding: 10px 10px 0;}
</style>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function loadNextImages(url){
	apptha.get(url,"",function(result){ 	
		apptha("#appthaContent").html(result);
		});

}

</script>

<?php 

$imageSizeVal = $this->aspectRatioSize(JPATH_ROOT.DS."images".DS."macgallery".DS.trim($row["image"]),$galSetting[0]->fullimgwidth, $galSetting[0]->fullimgheight);


$model = & $this->getModel();
$albumInfo = $model->albumNameById(JRequest::getInt("albumid")); 


$fbUrl = 'http://www.facebook.com/dialog/feed?
  app_id='.$api_key.'&
  link='.urlencode(JRoute::_(JURI::current().'index.php?option=com_macgallery&view=images&albumid='.JRequest::getInt("albumid"))).'&
  picture='.str_replace(" ","",JURI::root().'images/macgallery/thumb_image/'.$row["image"]).'&
  name='.$row["title"].'&  
  description='.$row["description"].'&
  redirect_uri='.urlencode(JRoute::_(JURI::current().'index.php?option=com_macgallery&view=images&albumid='.JRequest::getInt("albumid")));


?>
<link rel="image_src" type="image/jpeg"  href="<?php echo JURI::root().'images/macgallery/thumb_image/'.trim($row["image"]); ?>" />
<div class="mac-whole-content">
<div class="top-content" style="background-color: black">
            <div class="left-arrow floatleft" style="margin-top:<?php echo ($imageSizeVal[1]/2) ?>px" >
		<a title="Previous" 
		    <?php if($prev>-1  ): ?>
		    onclick="loadNextImages('<?php echo JRoute::_("index.php?option=com_macgallery&view=images&ajax=1&tmpl=component&format=raw&albumid=").JRequest::getInt("albumid")."&limit=".$prev ?>')"
		     <?php endif;?>  href="javascript:void(0);"
		    >
		    <img <?php if($prev<=-1  ) echo ' style="opacity:0.3 "'; ?> src="<?php echo JURI::root()."components/com_macgallery/images/"; ?>sprite_prev.png" /> </a>
		     </div>            
	    <div>
	              <div class="mac-gallery-image floatleft" >
	        <img  style="cursor: pointer;" height="<?php echo $imageSizeVal[1] ; ?>" width="<?php echo $imageSizeVal[0] ; ?>"
	        
	       <?php if($limit < $total-1):  ?>
			    onclick="loadNextImages('<?php echo JRoute::_("index.php?option=com_macgallery&view=images&ajax=1&tmpl=component&format=raw&albumid=").JRequest::getInt("albumid")."&limit=".$next ?>')"
			<?php else: ?>
				onclick="loadNextImages('<?php echo JRoute::_("index.php?option=com_macgallery&view=images&ajax=1&tmpl=component&format=raw&albumid=").JRequest::getInt("albumid")."&limit=0" ?>')"
			<?php endif;?>
	        
	        src="<?php echo JURI::root()."images/macgallery/full_image/".$row["image"]; ?>" />
	        </div>
	        
	    </div>
            <div id="appthaGalleryImage" class="right-arrow" style="float:right;margin-top:<?php echo ($imageSizeVal[1]/2) ?>px">
		   		 <a title="Next"
			    <?php if($limit < $total-1): ?>
			    onclick="loadNextImages('<?php echo JRoute::_("index.php?option=com_macgallery&view=images&ajax=1&tmpl=component&format=raw&albumid=").JRequest::getInt("albumid")."&limit=".$next ?>')"
			    <?php endif;?>
			    href="javascript:void(0);" >
			    <img  <?php if($limit >= $total-1) echo ' style="opacity:0.3 "';  ?> src="<?php echo JURI::root()."components/com_macgallery/images/"; ?>sprite_next.png" />
				</a>
		</div>

               
      </div>
   
    <div class="floatleft" style="background-color:white !important;width: 100% " >

	
    <div class="fb-left">
    <div class="fb-title floatleft">
        <span>
        	<?php if(isset($albumInfo[0])) echo $albumInfo[0]; ?>
        </span>
        <span class="fb-date">
            <?php if($row["created_date"] != '')
                echo date("dS F Y",strtotime($row["created_date"]));
            ?>
        </span>
        </div>
        <div style="clear: both" ></div>
    </div>
    
    <!--
    <div class="fb-center">
     <div class="floatleft fbcomment">
        <fb:comments href="<?php // echo JRoute::_(JURI::current()."index.php?option=com_macgallery&view=images&image=&".$row["id"]."albumid=".JRequest::getInt("albumid")); ?>" xid="<?php echo $row["id"];  ?>" num_posts="4" width="400"></fb:comments>
       </div>
    </div>
    -->
    
    <div style="float:right;">
    		<div style="font-size: 11px;" class="download share-font"><a href="<?php echo JURI::base().'index.php?option=com_macgallery&view=download&albumid='.$row["image"]; ?>"><?php echo JText::_('COM_MACGALLERY_DOWNLOAD') ?></a></div>
        	<div class="download share-font" style="font-size: 11px"><a href="<?php echo $fbUrl; ?>" target="_blank"><?php echo JText::_('COM_MACGALLERY_SHARE'); ?></a></div>
     </div>
     
     <div class="clear"></div>
     <div class="fb-desc-head">
     	Description :
     	<div class="fb-desc">
     		<span><?php
                  if($row["description"] != ''){
                      echo $row["description"];
                  }
                  else{
                      echo JText::_('COM_MACGALLERY_NO_DESCRI_AVAIL');
                  }
                  ?>
			</span>
     	</div>
     </div>

</div>