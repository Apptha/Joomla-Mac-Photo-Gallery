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
// No direct access.
defined('_JEXEC') or die;
?>
<style type="text/css">
    .item {
        border: 1px solid #CCCCCC !important;
        float: left;
        margin: 3px;
        padding: 0 !important;
        position: relative;
      }
      .item a {
            background: none repeat scroll 0 0 #FFFFFF !important;
            color: black;
            display: table-cell !important;
            height: 90px;
            line-height: 90px;
            overflow: hidden;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            width: 80px;
      }
      .item img {
            border: 0 none;
            display: inline;
      }
      .item span {
            background-color: #EEEEEE;
            bottom: 0;
            clear: both;
            display: block;
            font-family: Tahoma,Verdana,sans-serif !important;
            font-size: 11px;
            left: 0;
            line-height: 100%;
            overflow: hidden;
            padding: 2px 0;
            position: absolute;
            width: 100%;
        }
</style>
    <fieldset>
        <div class="fltlft">
            <h3><?php echo JText::_("COM_MACGALLERY_FOLDER_NAME") ?> : <?php echo ucfirst($this->folder); ?></h3>
        </div>
        <div class="fltrt">
            <input type="button" id="insertURL" value="Insert" onclick="window.parent.jInsertFieldValue(document.getElementById('f_url').value,'<?php echo JRequest::getCmd("fieldid"); ?>');window.parent.SqueezeBox.close();" />
            <input type="button" id="cancelURL" value="Cancel" onclick="window.parent.SqueezeBox.close();" />
        </div>
    </fieldset>
<fieldset>
<legend ><?php echo JText::_("COM_MACGALLERY_CHOOSE_FILE") ?></legend>
<?php if (count($this->list["images"]) > 0 || count($this->list["folders"]) > 0) { ?>
<div class="manager">

		<?php for ($i=0,$n=count($this->list["images"]); $i<$n; $i++) :
                $row = &$this->list["images"][$i];
                ?>
                    <div class="item">
			 <a  title="<?php echo "images/$this->folder/".$row->name; ?>" href="javascript:void(0);"  onclick="document.getElementById('f_url').value= this.title; "  >
                                <?php if($row->mime == "image/jpeg" || $row->mime == "image/png" || $row->mime == "image/gif" || $row->mime == "image/bmp"){ ?>
                                            <img width="<?php echo $row->width_60; ?>" height="<?php echo $row->height_60; ?>" alt="<?php echo $row->name; ?> - <?php echo $row->size; ?>" src="<?php echo JURI::root()."images/$this->folder/".$row->name; ?>">
                                <?php }
                                else{
                                ?>
                                            <img  src="<?php echo JURI::root()."media/media/images/con_info.png" ?>" />
                                            <?php } ?>

                                            <span title="<?php echo $row->name; ?>"><?php echo $row->name; ?></span>
                         </a>			
		</div>
		 <?php endfor; ?>

</div>
<?php } else { ?>
	<div id="media-noimages">
		<p><?php echo JText::_('COM_MACGALLERY_NO_FILES_FOUND'); ?></p>
	</div>
<?php } ?>
</fieldset>
        <fieldset>
		<table class="properties">
			<tbody>
                            <tr>
				<td><label for="f_url"><?php echo JText::_('COM_MACGALLERY_IMAGE_URL'); ?></label></td>
                                <td><input style="width: 300px;" type="text" value="" id="f_url"></td>
                            </tr>
                        </tbody>
                </table>
	</fieldset>
	<form action="<?php echo JURI::base(); ?>index.php?option=com_macgallery&view=images&task=macgallery_upload" id="adminform" name="adminform" method="post" enctype="multipart/form-data">
		<fieldset id="uploadform">
			<legend><?php echo JText::_('COM_MACGALLERY_UPLOAD_MAXIMUM_SIZE'); ?></legend>
			<fieldset id="upload-noflash" class="actions">
				<label for="upload-file" class="hidelabeltxt"><?php echo JText::_('COM_MACGALLERY_UPLOAD_FILE'); ?></label>
				<input type="file" id="upload-file" name="Filedata" />
				<label for="upload-submit" class="hidelabeltxt"><?php echo JText::_('COM_MACGALLERY_START_UPLOAD'); ?></label>
				<input type="submit" id="upload-submit" value="<?php echo JText::_('COM_MACGALLERY_START_UPLOAD'); ?>"/>
			</fieldset>
			<ul class="upload-queue" id="upload-queue">
				<li style="display: none"></li>
			</ul>
			<input type="hidden" name="option" value="com_macgallery" />
			<input type="hidden" name="task" value="macgallery_upload" />
			<input type="hidden" name="controller" value="images" />
			
			<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_macgallery&view=media&tmpl=component&fieldid='.JRequest::getCmd("fieldid").'&asset=&author=&folder='.$this->folder); ?>" />
		</fieldset>
	</form>

