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
 /*  No direct access */
defined( '_JEXEC' ) or die( 'Restricted access' );


@include_once JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php";
?>
<style type="text/css">
    .key {
        text-align: left !important;
    }
    .admintable .desc{
    	font-size: 11px;
    	margin-top: 10px;
    }
</style>
<script language="JavaScript" type="text/javascript">
	function submitbutton(pressbutton)
	{
        var form = document.adminForm;
        if(pressbutton == "save" || pressbutton == "apply"){
            if (form.rowimg.value <= 0)
            {
                alert("Please enter No.of images/Row value greater than zero");
                document.getElementById('rowimg').focus();
                return false;
            }
            else if (IsNumeric(form.rowimg.value) == false)
            {
                alert("Please enter No.of images/Row numeric values");
                document.getElementById('rowimg').focus();
                return false;
            }

            if (form.rows.value <= 0)
            {
                alert("Please enter No.of rows value greater than zero");
                document.getElementById('rows').focus();
                return false;
            }
            else if (IsNumeric(form.rows.value) == false)
            {
                alert("Please enter No.of rows numeric values");
                document.getElementById('rows').focus();
                return false;
            }
            if (form.thumbimgwidth.value <= 0)
            {
                alert("Please enter thumb image height & width value greater than zero");
                document.getElementById('thumbimgwidth').focus();
                return false;
            }
            else if (IsNumeric(form.thumbimgwidth.value) == false)
            {
                alert("Please enter thumb image height & width numeric values");
                document.getElementById('thumbimgwidth').focus();
                return false;
            }

            if (form.mouseover_width.value <= 0)
            {
                alert("Please enter mouse over width value greater than zero");
                document.getElementById('mouseover_width').focus();
                return false;
            }
            else if (IsNumeric(form.mouseover_width.value) == false)
            {
                alert("Please enter mouse over width numeric values");
                document.getElementById('mouseover_width').focus();
                return false;
            }

             if (form.fullimgheight.value <= 0)
            {
                alert("Please enter full image height value greater than zero");
                document.getElementById('fullimgheight').focus();
                return false;
            }
            else if (IsNumeric(form.fullimgheight.value) == false)
            {
                alert("Please enter full image height numeric values");
                document.getElementById('fullimgheight').focus();
                return false;
            }

             if (form.fullimgwidth.value <= 0)
            {
                alert("Please enter full image width value greater than zero");
                document.getElementById('fullimgwidth').focus();
                return false;
            }
            else if (IsNumeric(form.fullimgwidth.value) == false)
            {
                alert("Please enter full image width numeric values");
                document.getElementById('fullimgwidth').focus();
                return false;
            }
            //fullimgheight
            if (form.proximity.value <= 0)
            {
                alert("Please enter  proximity value greater than zero");
                document.getElementById('proximity').focus();
                return false;
            }
            else if (IsNumeric(form.proximity.value) == false)
            {
                alert("Please enter proximity  numeric values");
                document.getElementById('proximity').focus();
                return false;
            }
            submitform( pressbutton );
            return true;
        }
        submitform( pressbutton );
        return;
    }
	//Validation for 1.6
	Joomla.submitbutton = function(pressbutton)
	{
        var form = document.adminForm;
        if(pressbutton == "save" || pressbutton == "apply"){
            if (form.rowimg.value <= 0)
            {
                alert("Please enter No.of images/Row value greater than zero");
                document.getElementById('rowimg').focus();
                return false;
            }
            else if (IsNumeric(form.rowimg.value) == false)
            {
                alert("Please enter No.of images/Row numeric values");
                document.getElementById('rowimg').focus();
                return false;
            }

            if (form.rows.value <= 0)
            {
                alert("Please enter No.of rows value greater than zero");
                document.getElementById('rows').focus();
                return false;
            }
            else if (IsNumeric(form.rows.value) == false)
            {
                alert("Please enter No.of rows numeric values");
                document.getElementById('rows').focus();
                return false;
            }
            if (form.thumbimgwidth.value <= 0)
            {
                alert("Please enter thumb image height & width value greater than zero");
                document.getElementById('thumbimgwidth').focus();
                return false;
            }
            else if (IsNumeric(form.thumbimgwidth.value) == false)
            {
                alert("Please enter thumb image height & width numeric values");
                document.getElementById('thumbimgwidth').focus();
                return false;
            }

            if (form.mouseover_width.value <= 0)
            {
                alert("Please enter mouse over width value greater than zero");
                document.getElementById('mouseover_width').focus();
                return false;
            }
            else if (IsNumeric(form.mouseover_width.value) == false)
            {
                alert("Please enter mouse over width numeric values");
                document.getElementById('mouseover_width').focus();
                return false;
            }

             if (form.fullimgheight.value <= 0)
            {
                alert("Please enter full image height value greater than zero");
                document.getElementById('fullimgheight').focus();
                return false;
            }
            else if (IsNumeric(form.fullimgheight.value) == false)
            {
                alert("Please enter full image height numeric values");
                document.getElementById('fullimgheight').focus();
                return false;
            }

             if (form.fullimgwidth.value <= 0)
            {
                alert("Please enter full image width value greater than zero");
                document.getElementById('fullimgwidth').focus();
                return false;
            }
            else if (IsNumeric(form.fullimgwidth.value) == false)
            {
                alert("Please enter full image width numeric values");
                document.getElementById('fullimgwidth').focus();
                return false;
            }
            //fullimgheight
            if (form.proximity.value <= 0)
            {
                alert("Please enter  proximity value greater than zero");
                document.getElementById('proximity').focus();
                return false;
            }
            else if (IsNumeric(form.proximity.value) == false)
            {
                alert("Please enter proximity  numeric values");
                document.getElementById('proximity').focus();
                return false;
            }
            submitform( pressbutton );
            return true;
        }
        submitform( pressbutton );
        return;
    }
	
    //  check for valid numeric strings
    function IsNumeric(strString)
    {
        var strValidChars = "0123456789.-";
        var strChar;
        var blnResult = true;

        if (strString.length == 0)
            return false;

        //  test strString consists of valid characters listed above
        for (i = 0; i < strString.length && blnResult == true; i++)
        {
            strChar = strString.charAt(i);
            if (strValidChars.indexOf(strChar) == -1)
            {
                blnResult = false;
            }
        }
        return blnResult;
    }
    function imgchange()
    {
        document.getElementById('seperate').style.display = 'none';
        if(document.getElementById('singleimg').checked == true)
        document.getElementById('large').style.display = 'block';
        else if(document.getElementById('douimg').checked == true)
        document.getElementById('seperate').style.display = 'block';
    }
</script>

<?php


$rows = $this->settings['row'];


$editor = JFactory::getEditor();

JHtml::_('behavior.tooltip');

if(!isset($option))
            $option = '';

//If user clicks edit the following form is displayed
if(JRequest::getVar('task') == 'edit' ){
     ?>

        <form action="<?php echo JRoute::_('index.php?view=settings'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
        <fieldset class="adminform" style="background-color: white">
            <legend> <?php echo JText::_('COM_CONTUS_MACGALLERY_ALBUMS') ?></legend>
            <table class="admintable" style="width: 100%">                
                <tr>
                   <td class="key" style="width:175px" > <span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_ROW_PAGE_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_ROW_PAGE') ?></span></td>
                   <td><input type="text" name="rows" id="rows" value="<?php echo $rows->rows;?>"/></td>
                </tr>
                <tr>
                   <td class="key" width="300"  ><span class=" editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_ROW_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_ROW') ?></span></td>
                   <td><input type="text" name="rowimg" id="rowimg" value="<?php echo $rows->rowimg;?>"/></td>
                </tr>
                <!--  
                <tr>
                   <td class="key" width="300"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_HEIGHT_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_HEIGHT') ?>(Px)</span></td>
                   <td><input type="text" name="thumbimgheight" id="thumbimgheight" value="<?php echo $rows->thumbimgheight;?>"/> </td>
                </tr>
                -->
                <tr>
                   <td class="key" width="300"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_WIDTH_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_WIDTH') ?>(Px)</span></td>
                   <td><input type="text" name="thumbimgwidth" id="thumbimgwidth" value="<?php echo $rows->thumbimgwidth;?>"/> </td>
                </tr>
                
                <tr>
                   <td class="key" width="300"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_MOUSEOVER_WIDTH_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_MOUSEOVER_WIDTH') ?>(Px)</span></td>
                   <td><input type="text" name="mouseover_width" id="mouseover_width" value="<?php echo $rows->mouseover_width;?>"   /> </td>
                </tr>
                <!--
                <tr>
                   <td class="key" width="300"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_MEDIUMIMAGE_WIDTH_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_MEDIUMIMAGE_WIDTH') ?>(Px)</span></td>
                   <td><input type="text" name="mediumimgwidth" id="mediumimgwidth" value="<?php echo $rows->mediumimgwidth;?>"/> </td>
                </tr>
                 -->
                <tr>
                   <td class="key" width="30"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_HEIGHT_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_HEIGHT') ?>(Px)</span></td>
                   <td><input type="text" name="fullimgheight" id="fullimgheight" value="<?php echo $rows->fullimgheight;?>"/> </td>
                </tr>
                <tr>
                   <td class="key" width="300"  ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_WIDTH_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_WIDTH') ?>(Px)</span></td>
                   <td><input type="text" name="fullimgwidth" id="fullimgwidth" value="<?php echo $rows->fullimgwidth;?>"/> </td>
                </tr>
                <tr>
                   <td class="key" width="20" ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_PROXIMITY_TOOLTIP') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_PROXIMITY') ?></span></td>
                   <td><input type="text" name="proximity" id="proximity" value="<?php echo $rows->proximity;?>"/> </td>
                </tr>
                
                <tr>
                   <td class="key" width="20" ><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_MAC_EFFECT_DIRECTION_TOOLTIP') ?>">
                   
     
     <?php echo JText::_('COM_CONTUS_MACGALLERY_MAC_EFFECT_DIRECTION') ?></span></td>

                        <?php if ($rows->effect_direction == 0)
                        {
                            $bottom = "selected='selected'";
                            $top = "";
                        }
                        else
                        {
                            $top="selected='selected'";
                            $bottom = "";
                        }
                        ?>
                   <td>
                       <select id="effect_direction" name="effect_direction">
                           <option value="0" <?php echo $bottom; ?> ><?php echo JText::_('COM_CONTUS_MACGALLERY_BOTTOM') ?></option>
                           <option value="1" <?php echo $top; ?> ><?php echo JText::_('COM_CONTUS_MACGALLERY_TOP') ?></option>
                    </select>
                   </td>
                </tr>
                 
                <tr>
                    <td width="100" align="right" class="key"><span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY_TOOLTIP') ?>">
                   		<span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY') ?></span>
                    </span></td>
                    <td>
                        <input type="radio" style="float:left" name="imgdisplay" value=0 <?php if($rows->imgdisplay==0){echo 'checked="checked"';}?>/>
                        
                        <span style="float:left;margin-left: 5px;"><?php echo JText::_("COM_CONTUS_MACGALLERY_SETTINGS_RANDOM") ?>&nbsp;</span> <input type="radio" style="float:left" name="imgdisplay"  value=1  <?php if($rows->imgdisplay==1){echo 'checked="checked"';}?>/>
                        
                        
                        <span style="float:left;margin-left: 5px;"><?php echo JText::_('COM_CONTUS_MACGALLERY_ORDER') ?></span>

                    </td>
                </tr>
                <tr>
                   <td width="20" align="right" class="key">
                   <span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DISPLAY_ALBUM_LIST') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_DISPLAY_ALBUM_LIST_TOOLTIP') ?>">
                   <?php echo JText::_('COM_CONTUS_MACGALLERY_DISPLAY_ALBUM_LIST') ?>
                   </span>
                   </td>

                        <?php if ($rows->alblist == 0)
                        {
                            $no="selected='selected'";
                            $yes = "";
                        }
                        else
                        {

                            $yes = "selected='selected'";
                            $no = "";
                        }
                        ?>
                   <td>
                       <select id="alblist" name="alblist">
                           <option value="0" <?php echo $no; ?> ><?php echo JText::_('COM_CONTUS_MACGALLERY_NO') ?></option>
                           <option value="1" <?php echo $yes; ?> ><?php echo JText::_('COM_CONTUS_MACGALLERY_YES') ?></option>
                    </select>
                   </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                    <span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY_STYLE') ?>"><?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY_STYLE') ?>
                    </span>
                    
                    </td>
                    <td>
                        <input type="radio" style="float:left" name="imgdispstyle" value=0 <?php if($rows->imgdispstyle==0){echo 'checked="checked"';}?>/>
                        <span style="float:left;margin-left: 5px;"><?php echo JText::_('COM_CONTUS_MACGALLERY_NORMAL') ?>&nbsp;</span>
                        <input type="radio" style="float:left" name="imgdispstyle"  value=1  <?php if($rows->imgdispstyle==1){echo 'checked="checked"';}?>/>
                        <span style="float:left;margin-left: 5px;"><?php echo JText::_('COM_CONTUS_MACGALLERY_ROUNDED_CORNER') ?>&nbsp;</span>
                        <input type="radio" style="float:left" name="imgdispstyle"  value=2  <?php if($rows->imgdispstyle==2){echo 'checked="checked"';}?>/>
                        <span style="float:left;margin-left: 5px;">
                        <?php echo JText::_('COM_CONTUS_MACGALLERY_WINGED') ?>
                        </span>
                    </td>
                </tr>
                 <tr>
                     <td width="100" align="right" class="key">
                        <span class="editlinktip hasTip" title="<?php echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php echo JText::_('COM_MACGALLERY_CONTROLLERS_FACEBOOK_API_TOOLTIP') ?>"><?php echo JText::_('COM_MACGALLERY_CONTROLLERS_FACEBOOK_API') ?></span>
                    </td>
                    <td><input type="text" name="api_key"  id="api_key" value="<?php echo $rows->api_key;?>"/> 
                    
                    <div class="desc">Please provide the App ID/API Key of Facebook for your domain from the following link <a href="https://developers.facebook.com/apps/" target="_blank">See the link</a>.  You will be able to share a image, only if you provide those.</div>
                    
                    </td>
                </tr>               
            </table>
        </fieldset>

        <input type="hidden" name="id" value="<?php echo $rows->id; ?>" />
        <input type="hidden" name="option" value="com_macgallery" />
        <input type="hidden" name="controller" value="settings" />
        <input type="hidden" name="task" value="edit" />
        <input type="hidden" name="boxchecked" value="1" />
    </form>
<?php
    }else{
?>
        <form action="<?php echo JRoute::_('index.php?option=com_macgallery&view=settings') ;?>" method="post" name="adminForm" >
          <fieldset class="adminform" style="background-color: white">
                <legend>Gallery Settings</legend>
                <table class="admintable" style="width: 100%">
                    <?php
                    jimport('joomla.filter.output');
                    for ($i = 0,$n = count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id );
                        $published = JHTML::_('grid.published', $row, $i );
                        $link = JRoute::_('index.php?option=' .$option . '&task=edit&cid[]='. $row->id );?>

                        <input type="checkbox" style="display:none;"  checked="checked" value="1" name="cid[]" id="cb0"/>

                        <tr class="row0">
                            <td style="width:300px" align="right" class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_ROW_PAGE') ?></td>
                            <td colspan="2"><?php echo $row->rows;?></td>
                        </tr>
                        <tr class="row1">
                            <td width="100" align="right" class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_ROW') ?></td>
                             <td colspan="2"><?php echo $row->rowimg;?></td>
                        </tr>
                        <!-- 
                        <tr>
                            <td width="20" class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_HEIGHT') ?>(Px)</td><td colspan="2"><?php echo $row->thumbimgheight;?></td>
                        </tr>
                         -->
                        <tr class="row0">
                            <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_THUMBIMAGE_WIDTH') ?>(Px)</td><td colspan="2" ><?php echo $row->thumbimgwidth;?></td>
                        </tr>
                          
                        <tr class="row1">
                            <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_MOUSEOVER_WIDTH') ?>(Px)</td><td colspan="2" ><?php echo $row->mouseover_width;?></td>
                        </tr>
                        <tr class="row0">
                            <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_HEIGHT') ?>(Px)</td><td colspan="2"><?php echo $row->fullimgheight;?></td>
                        </tr>
                        <tr class="row1">
                            <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_FULLIMAGE_WIDTH') ?>(Px)</td><td  colspan="2"><?php echo $row->fullimgwidth;?></td>
                        </tr>
                        <tr class="row0">
                           <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_PROXIMITY') ?></td> <td colspan="2" ><?php echo $row->proximity;?></td>
                        </tr>
                         
                        <tr class="row1">
                            <td width="20" class="key" ><?php echo JText::_('COM_CONTUS_MACGALLERY_MAC_EFFECT_DIRECTION') ?></td>
                            <?php
                                if ($row->effect_direction == 0)
                                    $direction = JText::_('COM_CONTUS_MACGALLERY_BOTTOM');
                                else
                                    $direction = JText::_('COM_CONTUS_MACGALLERY_TOP');
                            ?>
                            <td colspan="2" ><?php echo $direction;?></td>
                        </tr>
                        
                        <tr class="row0">
                            <td width="100"  class="key"> <?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY') ?></td>
                            <?php
                                if ($row->imgdisplay == 1)
                                    $imgdisplay = JText::_('COM_CONTUS_MACGALLERY_ORDER');
                                else
                                    $imgdisplay = JText::_('COM_CONTUS_MACGALLERY_RANDOM');
                            ?>
                            <td colspan="2" ><?php echo $imgdisplay;?></td>
                        </tr>

                        <tr class="row1">
                            <td width="20"  class="key"><?php echo JText::_('COM_CONTUS_MACGALLERY_DISPLAY_ALBUM_LIST') ?></td>
                            <?php
                                if ($row->alblist == 0)
                                    $display = JText::_('COM_CONTUS_MACGALLERY_NO');
                                else
                                    $display = JText::_('COM_CONTUS_MACGALLERY_YES');
                            ?>
                            <td  colspan="2"><?php echo $display;?></td>
                        </tr>

                        <tr class="row0">
                            <td width="100"  class="key"> <?php echo JText::_('COM_CONTUS_MACGALLERY_IMAGE_DISPLAY_STYLE') ?></td>
                            <?php
                                if ($row->imgdispstyle == 0)
                                    $imgdispstyle = "Normal";
                                else if($row->imgdispstyle == 1)
                                    $imgdispstyle = "Rounded Corners";
                                else if($row->imgdispstyle == 2)
                                    $imgdispstyle = "Winged";
                                else if($row->imgdispstyle == 3)
                                    $imgdispstyle = "Round";
                            ?>
                            <td colspan="2" ><?php echo $imgdispstyle;?></td>
                        </tr>


                        <tr class="row1">
                            <td   class="key"><?php echo JText::_('COM_MACGALLERY_CONTROLLERS_FACEBOOK_API') ?></td>
                            <td width="200" ><?php echo $row->api_key; ?>&nbsp;
                            </td>
                    		<td>
                            <div class="desc">Please provide the App ID/API Key of Facebook for your domain from the following link <a href="https://developers.facebook.com/apps/" target="_blank">See the link</a>.  You will be able to share a image, only if you provide those.</div>
                            </td>
                        </tr> 
                <?php } ?>
                </table>
          </fieldset>
          <input type="hidden" name="option" value="com_macgallery" />
          <input type="hidden" name="task" value="edit" />
          <input type="hidden" name="controller" value="settings" />
          <input type="hidden" name="boxchecked" value="1" />
          <input type="hidden" name="filter_order" value="" />
          <input type="hidden" name="filter_order_Dir" value="" />
        </form>
<?php }?>