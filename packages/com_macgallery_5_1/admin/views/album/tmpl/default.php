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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
$baseurl=JURI::base()."components/com_macgallery";
JHtml::_('behavior.tooltip');
?>
<style type="text/css">
    .button2-left{
        margin-top: 10px !important;
        margin-left: 0px !important;
     }
     .pull-right{float:left}
</style>
<script language="JavaScript" type="text/javascript">
	function submitbutton(pressbutton)
	{
        var form=document.adminForm;
        if(pressbutton=="save" || pressbutton=="apply")
        {
            if (form.albumname.value == '')
            {
                alert("<?php  echo JText::_('COM_CONTUS_MACGALLERY_JERR') ?>");
                document.getElementById('albumname').focus();
                return false;
            }
        }
        if(pressbutton=="remove"){	
        	if(!confirm("<?php  echo JText::_('COM_MACGALLERY_ARE_YOU_SURE') ?>") ){
        		return false;
        	}
            
        }
        submitform( pressbutton );
        return;
    }

	Joomla.submitbutton = function(pressbutton)
	{
        var form=document.adminForm;
        if(pressbutton=="save" || pressbutton=="apply")
        {
            if (form.albumname.value == '')
            {
                alert("<?php  echo JText::_('COM_CONTUS_MACGALLERY_JERR') ?>");
                document.getElementById('albumname').focus();
                return false;
            }
        }
        if(pressbutton=="remove"){	
        	if(!confirm("<?php  echo JText::_('COM_MACGALLERY_ARE_YOU_SURE') ?>") ){
        		return false;
        	}
            
        }
        submitform( pressbutton );
        return;
    }
</script>


<?php
//$pagesna = $this->album;
if(JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '')
{
    $rows = $this->album['row'];
    $lists = $this->album['lists'];
    
}
if(JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add')
{
    $task_new = JRequest::getVar('task');
?>
    <!-- Display this form when task is edit or add -->

    <form action="<?php echo JRoute::_('index.php?option=com_macgallery&view=album'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
        <fieldset class="adminform" style="background-color: white">
            <legend><?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUMS') ?></legend>
            <input type="hidden" value="<?php echo $task_new?>" id="hdntask"/>
            <table class="admintable table"  style="width: 60%;" cellspacing="2" >
                 <tr>
                    <td width="150" class="key" >
                       <span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_NAME_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_NAME') ?><font color="red">*</font></span>
                    </td>
                    <td>
                        <input  type="text" style="width:380px" name="albumname" id="albumname" value="<?php if($task_new=='edit'){echo $rows->albumname;}?>">
                    </td>
                </tr>
                <tr>
                    <td width="150" class="key" >
                        <span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_DESC_TOOLTIP') ?>"><?php  echo JText::_('COM_CONTUS_MACGALLERY_ALBUM_DESC') ?></span>
                    </td>
                    <td>
                    
                    <?php $editor = & JFactory::getEditor(); 
	                    
	                    $imageDesc = "";
						if (isset($rows->description))
                                $imageDesc = $rows->description;
	                    
	                    echo $editor->display('description', $imageDesc, '350', '200', '60', '20', false);
	                    ?>	  
                    
                    </td>
                </tr>
                <tr>
                    <td width="100" class="key" >
                       <span class="editlinktip hasTip" title="<?php  echo JText::_('COM_CONTUS_MACGALLERY_DESCRIPTION') ?>::<?php  echo JText::_('COM_CONTUS_MACGALLERY_PUBLISHED_ALBUM_TOOLTIP') ?>"> <?php  echo JText::_('COM_CONTUS_MACGALLERY_PUBLISHED') ?></span>
                    </td>
                    <td >
                        <input type="radio" style="float:left" name="published"
                            <?php if($task_new=='edit'){
                                        if($this->album['row']->published==1){
                                            echo 'checked="checked" ';
                                        }
                                   } else {
                                    echo "checked='checked'";
                                    }?> value="1"   />



                        <span style="float:left;margin-left: 5px;"><?php  echo JText::_('COM_CONTUS_MACGALLERY_YES') ?>&nbsp;&nbsp;</span>
                        


                       <input type="radio" style="float:left" name="published"
                            <?php if($task_new=='edit'){
                                    if($this->album['row']->published==0){
                                        echo 'checked="checked" ';
                                    }
                                }?>value="0" />
                                
                                <span style="float:left;margin-left: 5px;"><?php  echo JText::_('COM_CONTUS_MACGALLERY_NO') ?></span>
                    </td>
                </tr>
            </table>
        </fieldset>
        
        <input type="hidden" name="id" value="<?php if($task_new=='edit'){echo $rows->id;} ?>" />
        <input type="hidden" name="option" value="com_macgallery" />
        <input type="hidden" name="controller" value="album" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="1" />
    </form>
<?php
} else {?>
         <!-- Display album listing form in default or when no task is specified -->
         <?php
         
         
        if(!isset($option))
            $option = '';
        $mainframe = JFactory::getApplication();
        $search = $mainframe->getUserStateFromRequest( $option.'search','search','','string' );

        
         $pagesna = $this->album; ?>         
        <form action="<?php echo JRoute::_('index.php?option=com_macgallery&view=album'); ?>" method="post" name="adminForm" id="adminForm" >
            <table class="table table-striped">
                <tr>
                    <td align="left" width="100%">
                     <span>   <?php echo JText::_( 'COM_CONTUS_MACGALLERY_SEARCH' ); ?></span>
                        <input style="margin-top:6px;" type="text" name="search" id="search" value="<?php if (isset($search)) echo $search;?>" class="text_area"  onchange="document.adminForm.submit();" />
                        <button class="btn tip" type="submit" title="Search"><i class="icon-search"></i></button>
		        <button class="btn tip" type="button" title="Clear" onclick="document.id('search').value='';this.form.submit();"><i class="icon-remove"></i></button>
                        
                    </td>
                </tr>
            </table>
            <table class="table table-striped adminlist">
                <thead>
                    <tr>
                        
                        <?php if(JRequest::getCmd("tmpl")==""){ ?><th width="60">
                            <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
                        </th><?php } ?>
                        <th width="70"><?php echo JHTML::_('grid.sort',  JText::_( 'COM_CONTUS_MACGALLERY_ID') , 'id', @$lists['order_Dir'], @$lists['order'] ); ?></th>
                        <th  style="color:#3366CC">
                            <?php
                            echo JHTML::_('grid.sort',  'Album Name', 'albumname ', @$lists['order_Dir'], @$lists['order'] );
                            ?>
                        </th>
                        <th width="5%" nowrap="nowrap" style="color:#3366CC"><?php echo JHTML::_('grid.sort',  JText::_( 'COM_CONTUS_MACGALLERY_PUBLISHED' ), 'published', @$lists['order_Dir'], @$lists['order'] ); ?></th>
                    </tr>
                </thead>
                <?php
                    jimport('joomla.filter.output');
                    $j = 0;
                    for ($i = 0, $n = count( $rows ); $i < $n; $i++) {
                        $row = &$rows[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id );
                        $published = JHTML::_('jgrid.published', $row->published, $i );
                        $link = JRoute::_('index.php?option=com_macgallery&view=album&task=edit&cid[]='. $row->id );?>
                        <tr>
                        	<?php if(JRequest::getCmd("tmpl")==""){ ?><td align="center"><?php echo $checked; ?></td><?php }?>
                            <td align="center"><?php echo $row->id; ?></td>
	                            <?php if(JRequest::getCmd("tmpl")){ ?>
	                            	<td align="center"><a class="pointer" onclick="if (window.parent) window.parent.jSelectArticle('<?php echo $row->id;?>', '<?php echo $row->albumname;?>');"  ><?php echo $row->albumname;?></a></td>
	                            <?php } else{ ?>
									<td align="center"><a href="<?php echo $link; ?>"><?php echo $row->albumname;?></a></td>
								<?php } ?>
                            <td align="center"><?php echo $published;?></td>
                        </tr>
                            <?php
                        $j++;
                    }?>
                <tr><td colspan="6"><?php if(count($rows))  echo $pagesna['pageNav']->getListFooter(); ?></td></tr>
            </table>
            
            <input type="hidden" name="option" value="com_macgallery" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="controller" value="album" />
            <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
        </form>
<?php } ?>