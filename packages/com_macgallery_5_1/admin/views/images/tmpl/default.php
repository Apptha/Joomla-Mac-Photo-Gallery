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
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

$baseurl = JURI::base();
$path = JURI::base() . "components/com_macgallery";
$editor = & JFactory::getEditor();
$k = 0;
$folder = JPATH_ROOT.DS."images".DS."macgallery".DS;
$fullimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."full_image";
$mediumimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."medium_image";
$thumbimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."thumb_image";



if(!is_dir($folder)){
    mkdir($folder);
}               
if(!is_dir($fullimgfolder)){
    mkdir($fullimgfolder);
}                   
if(!is_dir($mediumimgfolder)){
	mkdir($mediumimgfolder);
}                    
if(!is_dir($thumbimgfolder)){
	mkdir($thumbimgfolder);
}

?>
<style type="text/css">
    .button2-left{
        margin-top: 10px !important;
        margin-left: 0px !important;
     }
</style>
<script type="text/javascript" src="<?php echo $path . '/js/jquery-1.3.2.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $path . '/js/jquery-ui-1.7.1.custom.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $path . '/js/selectuser.js'; ?>"></script>
<link rel='stylesheet' href='<?php echo $path . "/css/styles123.css"; ?>' type='text/css' media='all' />

<script type="text/javascript">
    // When the document is ready set up our sortable with it's inherant function(s)
    var dragdr = jQuery.noConflict();
    var videoid = new Array();
    dragdr(document).ready(function() {
        dragdr("#test-list").sortable({
            handle : '.handle',
            update : function () {
                var order = dragdr('#test-list').sortable('serialize');

                orderid = order.split("listItem[]=");

                for(i = 1;i < orderid.length;i++)
                {
                    videoid[i] = orderid[i].replace('&',"");
                    oid = "ordertd_"+videoid[i];
                    document.getElementById(oid).innerHTML = i-1;
                }
                dragdr("#info").load("<?php echo $baseurl; ?>/index.php?option=com_macgallery&task=sortorder&"+order);
           }
        });
        dragdr(".mceEditor").after("<br/>");
    });

</script>

<?php


$albumval = $this->images['albumval'];
$pageval = $this->images;
$albumtot = count($albumval);

if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '') {
    $rows = $this->images['row'];
    $lists = $this->images['lists'];
}

if(!isset($option))
            $option = '';



if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
    $task_new = JRequest::getVar('task');
    
    
    if(JRequest::getVar('task') == 'edit'){

        ?>

    <form action="index.php?option=com_macgallery&view=images" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
        <fieldset class="adminform" style="background-color: white">
            <legend><?php  echo JText::_('COM_CONTUS_MACGALLERY_IMAGES') ?></legend>
            <input type="hidden" value="<?php echo $task_new ?>" id="hdntask"/>
            <table class="table table-striped admintable" id="upladtable" style="width: 60%">
                 	
                    <tr>
	                    <td class="key"><span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_TITLE_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_TITLE') ?><font color="red">*</font></span></td>
	                    <td><input style="width:380px" type="text" name="title" id="title" value="<?php if ($task_new == 'edit') {echo $rows->title;} ?>"></td>
                    </tr>
                    <tr>
	                    <td class="key"><span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION_IMAGE_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION_IMAGE') ?></span></td>
	                    <td>
	                    <?php $editor = & JFactory::getEditor(); 
	                         $imageDesc = "";
                            if (isset($rows->description))
                                $imageDesc = $rows->description;
	                    ?>
                                <textarea style="width:380px" name="description"  rows="3" ><?php echo $imageDesc; ?></textarea>
	                        <!--  <input  type="text" name="description[]" id="description" value="<?php // if ($task_new == 'edit') {echo $rows->description;} ?>">-->
	                    </td>
                    </tr>
                    <tr>
	                    <td class="key"><span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_SELECT_IMAGE_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_SELECT_IMAGE') ?><font color="red">*</font></span></td>
	                    <td>
	                    <?php
	                    
                    $folder = JPATH_ROOT.DS."images".DS."macgallery".DS;
                    
                    $fullimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."full_image";
                    $mediumimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."medium_image";
                    $thumbimgfolder = JPATH_ROOT.DS."images".DS."macgallery".DS."thumb_image";
                    
                    if(!is_dir($folder)){
                        mkdir($folder);
                    }
                    
					if(!is_dir($fullimgfolder)){
                        mkdir($fullimgfolder);
                    }
                    
 					if(!is_dir($mediumimgfolder)){
                        mkdir($mediumimgfolder);
                    }
                    
					if(!is_dir($thumbimgfolder)){
                        mkdir($thumbimgfolder);
                    }
                    
                    
                    
                    if(!file_exists(JPATH_ROOT.DS."images".DS."macgallery".DS."index.html" )){
                        $fp = fopen(JPATH_ROOT.DS."images".DS."macgallery".DS."index.html","w");
                        $content = "<html><body></body></html>";
                        fwrite($fp, $content, strlen($content));
                        fclose($fp);
                    }
                    $folder = "macgallery";
                    
                    JHtml::_('behavior.modal');
                     // Build the script.
                    $script = array();
                    $script[] = '	function jInsertFieldValue(value, id) {';
                    $script[] = '		var old_id = document.getElementById(id).value;';
                    $script[] = '		if (old_id != id) {';
                    $script[] = '			var elem = document.getElementById(id)';
                    $script[] = '			elem.value = value;';
                    $script[] = '			elem.fireEvent("change");';
                    $script[] = '		}';
                    $script[] = '	}';
                    // Add the script to the document head.
                    JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
                    $html = array();
                     $attr = '';
                    // Initialize some field attributes.
                    $attr .= ' class="inputbox"';
                    $attr .=' size="40"';
                    $this->value = isset($this->value) ? $this->value : '';

                    // Initialize JavaScript field attributes.
                    $html[] = '<div class="fltlft" style="float:left">';
                    $html[] = '	<input type="text" name="image" id="myfile"' ;
                    if(isset($this->images['row']->image))  {
                      $html[] =      ' value="' ."images/macgallery/". $this->images['row']->image. '"' ;
                    }
                    $html[] = ' readonly="readonly"' . $attr . ' />';
                    $html[] = '</div>';
                    $html[] = '<div class="button2-left" style="float:left;margin-left:5px !important; margin-top:0px !important">';
                    $html[] = '	<div class="blank">';
                    $html[] = '<a class="modal" title="select" href="' . JURI::base() . 'index.php?option=com_macgallery&view=media&tmpl=component&fieldid=myfile&folder=' . $folder . '" rel="{handler:\'iframe\', size: {x: 800, y: 500}}">';
                    $html[] = '			' . JText::_('COM_MACGALLERY_BUTTON_SELECT') . '</a>';
                    $html[] = '	</div>';
                    $html[] = '</div>';
                    $html[] = '<div class="button2-left" style="float:left;margin-left:5px !important; margin-top:0px !important">';
                    $html[] = '	<div class="blank">';
                    $html[] = '		<a  title="'.JText::_('COM_MACGALLERY_BUTTON_CLEAR').'"' .
                                            ' href="javascript:void(0);"'.
                                            ' onclick="document.getElementById(\'myfile\').value=\'\'; document.getElementById(\'myfile\').onchange();">';
                    $html[] = '			'.JText::_('COM_MACGALLERY_BUTTON_CLEAR').'</a>';
                    $html[] = '	</div>';
                    $html[] = '</div>';
                    echo implode("\n", $html);
             ?>
	                    
	                    
	                    <!-- 
	                        <div id="f0-adminForm" >
	                            <input type="file" name="myfile" id="myfile"  onchange="enableUpload('adminForm');"/>
	                              <input type="button" id="uploadBtn"  name="uploadBtn" value="Upload Image" disabled="disabled" onclick="addQueue('adminForm');" />
	                            <label><?php if (isset($this->images['row']->image)) echo $this->images['row']->image; ?></label>
	                            <div id="nor"><iframe id="uploadvideo_target0" name="uploadvideo_target0" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
	                        </div>
	                        <div id="f0-upload-progress" style="display:none;">
	                            <img id="f0-upload-image" style="float:left;" src="components/com_macgallery/images/empty.gif" alt="Uploading" />
	                            <span id="f0-upload-filename" style="float:left;font-size:12px;font-weight:bold;background:#FFAFAE;padding:5px 10px 5px 10px;"></span>
	                            <span id="f0-upload-cancel" style="float:left;"><a style="padding-right:10px;" href="javascript:cancelUpload('adminForm');" name="submitcancel">Cancel</a>
	                            </span>
	                            <label id="f0-upload-status" style="float:left;padding-right:40px;padding-left:20px;">Uploading</label>
	                            <span id="f0-upload-message" style="float:left;font-size:12px;background:#FFAFAE;padding:5px 10px 5px 10px;">
	                                <b> <?php  echo JText::_('COM_CONTUS_MACGALLERY_UPLOAD_FAILED') ?>:</b> <?php  echo JText::_('COM_CONTUS_MACGALLERY_USER_CANCELLED_UPLOAD') ?>
	                            </span>
	                        </div>
	                         -->
	                    </td>
                    </tr>
                    <?php if(JRequest::getVar('task') == 'edit' && $this->images['row']->image !="") :?>
                    <tr>
                    	<td class="key"> <span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_PREVIEW_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_PREVIEW') ?></span></td>
                    	<td>
                    	<?php if(isset($this->images['row']->image)): ?>
                    		<img height="50" width="50" src="<?php echo JURI::root()."images/macgallery/medium_image/".$this->images['row']->image; ?>" />
                    	<?php endif; ?>
                    	</td>
                    </tr>
                    <?php endif; ?>
                    <tr>
	                    <td class="key">
	                    <span class="editlinktip hasTip"  title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_SELECT_ALBUM_NAME_TOOLTIP') ?>">
	                    <?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_NAME') ?><font color="red">*</font>
	                    
	                    </span>
	                    </td>
	                    <td id="selectalbum" >
	                                
	                        <select id="albumid" name="albumid" style="width: 100px">
	                        <option value="0">--<?php  echo JText::_('COM_CONTUS_MACGALLERY_SELECT') ?>--</option>
	                        <?php for ($i = 0; $i < $albumtot; $i++) { ?>
	                            <option value="<?php echo $albumval[$i]->id; ?>"     <?php if ($task_new == 'edit') {if ($rows->albumid == $albumval[$i]->id) {echo "selected='selected'";}}   else{  echo (JRequest::getInt("albumid") == $albumval[$i]->id)? "selected=selected ":"";          }  ?>>
	                            <?php echo $albumval[$i]->albumname; ?>
	                            </option>
	                        <?php } ?>
	                        </select>
	                    </td>
                    </tr>
                    <tr>
                    	<td class="key"> <span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_PUBLISHED_IMAGE_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_PUBLISHED') ?></span></td>
                    	<td>
                    		<input type="radio" style="float:left" name="published"
                            <?php if ($task_new == 'edit') {
                                    if ($this->images['row']->published == 1) {
                                        echo 'checked="checked" ';
                                    }
                                } else {
                                    echo "checked='checked'";
                                } ?> value="1" />
                                
                                <span style="float:left;">&nbsp;<?php  echo JText::_('COM_CONTUS_MACGALLERY_YES') ?>&nbsp;&nbsp;</span>
                                
                                
                                <input type="radio" style="float:left" name="published"
                                <?php if ($task_new == 'edit')
                                      {
                                        if ($this->images['row']->published == 0)
                                        {
                                            echo 'checked="checked" ';
                                        }
                                      } ?>value="0" />
                                      
                                      <span style="float:left;">&nbsp;<?php  echo JText::_('COM_CONTUS_MACGALLERY_NO') ?></span>
                                
                    	</td>
                    </tr>
                    <!--  <tr>
	                    <td  align="right" colspan="2" width="5%">
	                        <input type="button" id="removebtn" value='Remove' name="removebtn" onclick="removerow(0)" />
	                    </td>	
                    </tr>-->	
            </table>
        </fieldset>
        <input type="hidden" name="id" id="id" value="<?php if ($task_new == 'edit') {echo $rows->id;} ?>" />
        <input type="hidden" name="option" value="com_macgallery" />
        <input type="hidden" name="controller" value="images" />

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="1" />
        <input type="hidden" name="uploadfiles" id="uploadfiles" value="" />
    </form>
    
    <?php } 
    else{
		$setting = $this->settings["row"][0];	
		$th = $setting->thumbimgwidth;
		$tw = $setting->mouseover_width;
		$mw = $setting->mediumimgheight;
		$mh = $setting->mediumimgwidth;
		$fh = $setting->fullimgheight;
		$fw = $setting->fullimgwidth;
    	?>
    	<style type="text/css" >
			#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
			#log{ margin:0; padding:0; width:500px;}
			#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px; 
				font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
			#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
			#log li .progress{ background:#999; width:0%; height:5px; }
			#log li p{ margin:0; line-height:18px; }
			#log li.success{ border:1px solid #339933; background:#ccf9b9; }
			#log li span.cancel{ position:absolute; top:5px; right:5px; width:20px; height:20px; 
				background:url('js/swfupload/cancel.png') no-repeat; cursor:pointer; }
			#swfupload-control table tr td{font-size: 1.091em;	}
		</style>
    	<script type="text/javascript" src="<?php echo $path . '/js/swfupload/swfupload.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo $path . '/js/jquery.swfupload.js'; ?>"></script>

		<form action="index.php?option=com_macgallery&view=images" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >		
		<div id="albumSelect">
		Please select the album first to upload images:
		
			<select name="albumid" style="width: 100px" onchange="showUploader(this.value)">
				<option value="0">--<?php  echo JText::_('COM_CONTUS_MACGALLERY_SELECT') ?>--</option>
		        <?php for ($i = 0; $i < $albumtot; $i++) { ?>
		        	<option value="<?php echo $albumval[$i]->id; ?>"  <?php if(JRequest::getInt("albumid")==$albumval[$i]->id) echo "selected='selected' " ?>  >
		        <?php echo $albumval[$i]->albumname; ?>
		        </option>
		        <?php } ?>
			</select>
		</div>

			<div id="swfupload-control" 
			<?php if(JRequest::getInt("albumid")=="") echo "style='display:none'";  ?> 
			>
				<p>Upload upto 20 image files(jpg, png, gif), each having maximum size of 1MB</p>
				<input type="button" id="button" />
				<p id="queuestatus" ></p>
				<ol id="log"></ol>
			</div>
	        <input type="hidden" name="option" value="com_macgallery" />
	        <input type="hidden" name="controller" value="images" />
	        <input type="hidden" name="task" value="" />
	        <input type="hidden" name="boxchecked" value="1" />
		</form>
		<?php
		 $user = JFactory::getUser(); 
		 //base path
		$this->comPath = JURI::base();		
		

		//path for upload php
		$filepath = urlencode(JPATH_SITE.DS.'images'.DS."macgallery".DS);
		$this->uploadfilePath = $this->comPath . 'components/com_macgallery/lib/uploadFile.php?jpath='.$filepath.'&th='.$th.'&tw='.$tw.'&mh='.$mh.'&mw='.$mw.'&fh='.$fh.'&fw='.$fw;
                $conf = JFactory::getConfig();
                $secret = $conf->get('secret');
                
                
                 
		?>
		
		<script type="text/javascript">
		var totalQueues;
		var QueueCountApptha = 0;
		jQuery(function(){
			jQuery('#swfupload-control').swfupload({
					upload_url: '<?php echo $this->uploadfilePath ; ?>',
					file_post_name: 'uploadfile',
					file_size_limit : "1024",
					file_types : "*.jpg;*.png;*.gif",
					file_types_description : "Image files",
                                        post_params: {"token" : "<?php echo md5($secret); ?>"},
					file_upload_limit : 20,
					flash_url : "<?php echo $path ?>/js/swfupload/swfupload.swf",
					button_image_url : '<?php echo $path ?>/js/swfupload/wdp_buttons_upload_114x29.png',
					button_width : 114,
					button_height : 29,
					"<?php echo $user->name; ?>":"<?php echo $user->id; ?>",
					button_placeholder : jQuery('#button')[0],
					debug: false
				})
				.bind('fileQueued', function(event, file){
					var listitem='<li id="'+file.id+'" >'+
						'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
						'<div class="progressbar" ><div class="progress" ></div></div>'+
						'<p class="status" >Pending</p>'+
						'<span class="cancel" >&nbsp;</span>'+
						'</li>';
					jQuery('#log').append(listitem);
					jQuery('li#'+file.id+' .cancel').bind('click', function(){
						var swfu = jQuery.swfupload.getInstance('#swfupload-control');
						swfu.cancelUpload(file.id);
						jQuery('li#'+file.id).slideUp('fast');
					});
					// start the upload since it's queued
					jQuery(this).swfupload('startUpload');
				})
				.bind('fileQueueError', function(event, file, errorCode, message){
					alert('Size of the file '+file.name+' is greater than limit');
				})
				.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){

					totalQueues  = numFilesQueued;
					jQuery('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+QueueCountApptha);
					
				})
				.bind('uploadStart', function(event, file){
					jQuery('#log li#'+file.id).find('p.status').text('Uploading...');
					jQuery('#log li#'+file.id).find('span.progressvalue').text('0%');
					jQuery('#log li#'+file.id).find('span.cancel').hide();
				})
				.bind('uploadProgress', function(event, file, bytesLoaded){
					//Show Progress
					var percentage=Math.round((bytesLoaded/file.size)*100);
					jQuery('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
					jQuery('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
				})
				.bind('uploadSuccess', function(event, file, serverData){
					appendHtmlfile(serverData,file);
					
					var item=jQuery('#log li#'+file.id);
					QueueCountApptha++;
					item.find('div.progress').css('width', '100%');
					item.find('span.progressvalue').text('100%');
					var pathtofile='<a href="<?php echo JURI::root()."images/macgallery"; ?>/'+file.name+'" target="_blank" >view &raquo;</a>';
					item.addClass('success').find('p.status').html('Done!!! ');
					jQuery('#queuestatus').text('Files Selected: '+totalQueues+' / Queued Files: '+QueueCountApptha);
					
				})
				.bind('uploadComplete', function(event, file){				
					// upload has completed, try the next one in the queue
					jQuery(this).swfupload('startUpload');
				})
			
				});	
		var fileCount = 0;
		function appendHtmlfile(serverData,file){
			var filename =  file.name.split(".");
			var html = "<fieldset id='"+file.id+fileCount+"' ><legend>"+file.name+"</legend><div align='right' style='cursor:pointer' onclick=\"removeFieldSet('"+file.id+fileCount+"')\"><img title='Remove'  style='float:right' width='16' height='16' src='<?php echo JURI::base()."components/com_macgallery/js/swfupload/cancel.png" ?>' /></div><table><tr><td valign='middle' style='width:100px'>Image Name</td><td valign='top'><input type='text' style='width:200px;' name='title[]' value='"+filename[0]+"'  /> <input type='hidden' name='image[]' value='"+serverData+"'/></td></tr>";
			html += "<tr><td valign='middle' style='width:100px'>Description</td><td valign='top'><textarea name='imagedesc[]' style='height:50px;font-size:12px;width:200px'></textarea></td>";
			html += "<td><img height='50' width='50' src='<?php echo JURI::root()."images/macgallery/medium_image/"; ?>"+serverData+"' /></td></tr>";
			html += "</table></fieldset>"; 
			jQuery("#swfupload-control").append(html);
			fileCount ++;
		}
		function showUploader(value){
			if(value!="0"){
				jQuery("#swfupload-control").show();
			}
			else{
				jQuery("#swfupload-control").hide();
			}
		}
		function removeFieldSet(id){
			jQuery("#"+id).remove();
		}
		
		</script>
		
    	<?php 
    }
    ?>
    

<?php } else
    {

        
        $albumId = JREQUEST::getVar('albumid');
        if($albumId!='')
        {
            $albumValue = '&albumid='.$albumId;
        }
        else
        {
            $albumValue = '';
        }


        $mainframe = JFactory::getApplication();
        $search = $mainframe->getUserStateFromRequest( $option.'search','search','','string' );
    ?>

        <form action="<?php echo JRoute::_('index.php?option=com_macgallery&view=images').$albumValue; ?>" method="post" id="adminForm" name="adminForm" >
            <table class="table table-striped" width="100%">
                <tr>
                    <td align="left"  width="100%">
                 <span>  <?php echo JText::_( 'COM_CONTUS_MACGALLERY_SEARCH' ); ?> </span>  
                     <input style="margin-top:6px;" type="text" name="search" id="search" value="<?php if ($search) echo $search;?>" class="text_area"  onchange="document.adminForm.submit();" />
                       
				<button class="btn tip" type="submit" title="Search"><i class="icon-search"></i></button>
				<button class="btn tip" type="button" title="Clear" onclick="document.id('search').value='';this.form.submit();"><i class="icon-remove"></i></button>
	                              

                    </td>
                    <td nowrap="nowrap"><?php echo JText::_('COM_CONTUS_MACGALLERY_SELECT_A_ALBUM') ?>&nbsp;</td>
                    <td align="right" >
                        <?php
                            $albumid = "";
                            $albumid = JRequest::getVar('albumid', '', 'get', 'var');
                        ?>
                        <select id="albumid" name="albumid" onchange="select_albumname()">
                        <?php for ($i = 0; $i < $albumtot; $i++) { ?>
                            <option value="<?php echo $albumval[$i]->id; ?>" <?php
                                if ($albumid == $albumval[$i]->id) {
                                    echo "selected='selected'";
                                }?>>
                            <?php echo $albumval[$i]->albumname; ?>
                            </option>
                        <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <style type="text/css">
			    .button2-left{
			        margin-top: 0px !important;
			        margin-left: 0px !important;
			     }
			</style>
            <table class="table adminlist ">
                <thead>
                    <tr>
                    	<th><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" /></th>
                        <!--  <th ><?php echo JText::_('COM_CONTUS_MACGALLERY_SORT_ORDER') ?></th>-->
                        <th ><?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE') ?></th>
                        
                        <th ><?php echo JHtml::_('grid.sort', 'Title', 'title', @$lists['order_Dir'], @$lists['order']); ?></th>
                        <th  ><?php echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_NAME') ?></th>
                        <th  ><?php echo JText::_('COM_CONTUS_MACGALLERY_COVER_IMAGE') ?></th>
                        <!-- <th width="10%"><?php echo JHTML::_('grid.sort', 'Ordering Position', 'ordering', @$lists['order_Dir'], @$lists['order']); ?></th> -->
                        <th  nowrap="nowrap" style="color:#3366CC"><?php echo JHTML::_('grid.sort', 'Published', 'published', @$lists['order_Dir'], @$lists['order']); ?></th>
                    </tr>
                </thead>
                
                        <?php
                            jimport('joomla.filter.output');
                            $imagepath = JURI::base() . "components/com_macgallery/images";
                            $imagelogopath = str_replace('administrator/', '', $imagepath);


                            $j = 0;
                            for ($i = 0, $n = count($rows); $i < $n; $i++) {
                                $row = &$rows[$i];
                                
                                $checked = JHtml::_('grid.id', $i, $row->id);
                                $published = JHtml::_('jgrid.published', $row->published, $i);
                                
                                $link = JRoute::_('index.php?option=com_macgallery&view=images&task=edit&cid[]=' . $row->id);
                                $link1 = JRoute::_('index.php?option=com_macgallery&view=images&cid[]=' . $row->id . '&albumid=' . $row->albumid . '&set=1');
                                $link0 = JRoute::_('index.php?option=com_macgallery&view=images&cid[]=' . $row->id . '&albumid=' . $row->albumid . '&set=0');?>

                               
                                        <tr>
                                        	<td width="9%" align="center"><?php echo $checked; ?></td>
                                            <!-- <td align="center" width="9%">
                                                <p class="hasTip content" title="Click and Drag" style="padding:6px;">  <img src="<?php echo $imagepath . '/arrow.png'; ?>" alt="move" width="16" height="16" class="handle" /> </p></td> -->
                                            <td width="9%" align="center" class="">
                                                <a href="<?php echo $link; ?><?php echo ($appthaAlbumId = JRequest::getInt("albumid"))? "&albumid=".$appthaAlbumId : ""; ?>"  >  <img height="50" width="50" src="<?php echo JURI::root()."images/macgallery/medium_image/".$row->image; ?>" /></a>
                                            </td>
                                            
                                            <td width="18%" align="center">
                                            <a href="<?php echo $link; ?><?php echo ($appthaAlbumId = JRequest::getInt("albumid"))? "&albumid=".$appthaAlbumId : ""; ?>"><?php echo $row->title; ?></a>
                                            </td>
                                            <td align="center" width="19%"><?php echo $row->albumname; ?></td>
                                            <td style="text-align: center" width="9%">
                                            <?php if ($row->albcover) { ?>
                                                <a  href="<?php echo $link0; ?>"
                                                   title="<?php echo JText::_('Unset default Album Image'); ?>">
                                                   <?php // echo  JHTML::_('image.administrator', 'star-icon.png', 'components/com_macgallery/images/', '', '', JText::_('Set as Album Image')); ?></a>
                                                   <img alt="cover image" src="<?php echo  JURI::base() . "components/com_macgallery/images/star-icon.png" ?>" />
                                                    <?php } else { ?>

                                                <a  href="<?php echo $link1; ?>"
                                                   title="<?php echo JText::_('Set as default Album Image'); ?>">
                                                    <img alt="cover image" src="<?php echo  JURI::base() . "components/com_macgallery/images/star-empty-icon.png" ?>" />
                                                	<?php // echo JHTML::_('image.administrator', 'star-empty-icon.png', 'components/com_macgallery/images/', '', '', JText::_('Set as Album Image')); ?></a>
                                                <?php } ?>
                                            </td>
                                            <!--  <td align="center" id="ordertd_<?php echo $row->id; ?>" width="9%" ><?php echo $row->ordering; ?></td>-->
                                            <td style="text-align: center" width="9%" ><?php echo $published; ?></td>
                                        </tr>
                                    
                                
                            <?php $j++;
                                }?>
                        
                
                <tr><td colspan="9">

                                <?php if(count($rows)) echo $pageval['pageNav']->getListFooter(); ?>
                    </td></tr>
            </table>
            <input type="hidden" name="option" value="com_macgallery" />
            <input type="hidden" name="controller" value="images" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" id="boxchecked" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
        </form>
<?php } ?>

<script type="text/javascript">
    function select_albumname()
    {
        submitvalues1();

        window.open('index.php?option=com_macgallery&view=images&albumid='+album_name_select,'_self',false);

    }
    function submitvalues1()
    {
        album_name_select = document.getElementById("albumid").value;
    }
</script>
<script src='<?php echo JURI::base() . "components/com_macgallery/js/main.js" ?>' type="text/javascript"></script>

 
<script language="JavaScript" type="text/javascript">
Joomla.submitbutton = function(pressbutton)
{
    	if(pressbutton == "regenrate"){
            var confirm=window.confirm("<?php echo JText::_('COM_MACGALLERY_ARE_YOU_REGENERATE'); ?>?")
            if (!confirm)
            return;
        }
        
        submitform( pressbutton );
        return;
    }


// validation for 1.5 
function submitbutton(pressbutton)
{
    	if(pressbutton == "regenrate"){
            var confirm=window.confirm("<?php echo JText::_('COM_MACGALLERY_ARE_YOU_REGENERATE'); ?>?")
            if (!confirm)
            return;
        }
        

        submitform( pressbutton );
        return;
    }





    function removerow(removeid)
    {
        if(document.getElementById('upladtable'))
        {
            var table = document.getElementById('upladtable');
            if(table.rows.length-1 != 0)
            {
                table.deleteRow(removeid);
                uploadimage[removeid]="0";
            }
            else
            {
                var table = document.getElementById('upladtable');
                var rowCount = table.rows.length;
                var row = table.insertRow(rowCount);
                var cell1 = row.insertCell(0);
                row.innerHTML = '<td width="5%" align="right" class="">Image:</td> <td width="35%" > <div id="f0-adminForm" > <input type="file" id="myfile"  name="myfile"  onchange="enableUpload(\'adminForm\');"/><input type="button" id="uploadBtn" name="uploadBtn" value="Upload Image" disabled="disabled" onclick="addQueue(\'adminForm\');" /> <div id="nor"><iframe id="uploadvideo_target0" name="uploadvideo_target0" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div></div> <div id="f0-upload-progress" style="display:none"><img id="f0-upload-image" src="components/com_macgallery/images/empty.gif" style="float:left;"  alt="Uploading" /><span id="f0-upload-filename" style="float:left;font-size:12px;font-weight:bold;background:#FFAFAE;padding:5px 10px 5px 10px;"> </span><span id="f0-upload-cancel"style="float:left;"><a style="padding-right:10px;" href="javascript:cancelUpload(\'adminForm\');" name="submitcancel">Cancel</a></span><label id="f0-upload-status" style="float:left;padding-right:40px;padding-left:20px;">Uploading</label><span id="f0-upload-message" style="float:left;font-size:12px;background:#FFAFAE;padding:5px 10px 5px 10px;"><b>Upload Failed:</b> User Cancelled the upload</span></div></td>';
                row.innerHTML += '<td width="5%" align="right" class="">Title:</td><td width="5%"><input  type="text" name="title[]" id="title" value=""></td><td width="10%" align="right" class="">Album Name:</td>';
                row.innerHTML += '<td width="5%" align="right" class="">Description:</td><td width="5%"><input  type="text" name="description[]" id="description" value=""></td><td width="5%" align="right" class="">Description:</td>';
                row.innerHTML += '<td width="5%" align="right" class="">Published:</td><td width="10%"><input type="radio" name="published0[]" checked="checked" value="1" />Yes<input type="radio" name="published0[]" value="0" />No</td><td  align="right" colspan="2" width="5%"><input type="button" id="removebtn" value="Remove" name="removebtn" onclick="removerow(0)" /></td>';
                table.deleteRow(removeid);
                uploadimage[removeid] = "0";
            }
        }
    }
</script>