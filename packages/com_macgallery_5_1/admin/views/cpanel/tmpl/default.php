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

defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.sliders');




//$pane =& JHtmlSliders::getInstance('sliders', array('startTransition'=>0,'startOffset'=>2));
$rows = $this->album['row'];
$option = $this->album['option'];
?>
<style type="text/css">
div.cpanel-left {float: left;width: 54%;}
div.cpanel-right {float: right;    width: 45%;}
.row-striped .row-fluid{width:90%}
</style>

<div class="cpanel-left">
       

    <div class="span4">
	<div class="well well-small">
            <div class="module-title nav-header">Quick Icons</div>
            <div class="row-striped">
		<div class="row-fluid">
                    <div class="span12">
                        <a href="index.php?option=com_macgallery&view=album">
                            <i class="icon-pictures"></i>
                            <span><?php echo JText::_( 'COM_CONTUS_MACGALLERY_ALBUMS' ) ?></span>
                        </a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <a href="index.php?option=com_macgallery&view=images">
                            <i class="icon-folder"></i>
                            <span><?php echo JText::_( 'COM_CONTUS_MACGALLERY_IMAGES' ) ?></span>
                        </a>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12">
                        <a href="index.php?option=com_macgallery&view=settings">
                            <i class="icon-cog"></i>
                            <span><?php echo JText::_( 'COM_CONTUS_MACGALLERY_GALLERY' ) ?></span>
                        </a>
                    </div>
                </div>
                
        </div>
    </div>
            


        </div>
       <div class="cpanel-right">
            <?php
//
                echo JHtmlSliders::start( 'panel-sliders' );
                echo JHtmlSliders::start( JText::_('COM_CONTUS_MACGALLERY_WELCOME_DESC') , 'welcome'  );
            ?>
            <table class="adminlist">
                <tr>
                    <td>
                        <div style="border:0px solid #ccc;background:#fff;">
                            
                            <h3><?php echo JText::_('COM_CONTUS_MACGALLERY_VERSION');?></h3>
                            <p>1.0</p>
                            <h3><?php echo JText::_('COM_CONTUS_MACGALLERY_COPYRIGHT');?></h3>
                            <p>&#169;<?php echo date("Y"); ?> 
                            <a href="http://www.apptha.com/" target="_blank">www.apptha.com</a></p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>
        <?php
            echo JHtmlSliders::end();
            echo JHtmlSliders::start( JText::_('COM_CONTUS_MACGALLERY_SUPPORT') , 'welcome' );
        ?>
            <table class="adminlist">
                <tr>
                    <td>
                        <div style="font-weight:700;">
                        <?php echo JText::_('COM_CONTUS_ANOTHER_COMPONENT');?>
                        </div>
                        <p>
                           <?php echo JText::_('COM_CONTUS_MACGALLERY_IF_PROF');?>
                            <a href="http://apptha.com/forum/" target="_blank">
                            http://apptha.com/forum/	
                            </a>
                            <?php echo JText::_('COM_CONTUS_MACGALLERY_FOR_DEVELOPER');?>
                            <a href="mailto:support@apptha.com">support@apptha.com</a>
                        </p>
                    </td>
                </tr>
            </table>
            <?php
                echo JHtmlSliders::end();
                echo JHtmlSliders::start( JText::_('COM_CONTUS_MACGALLERY_ALBUM_LIST') , 'alblist' );
            ?>
            <table class="adminlist">
            <?php
                $j = 0;
                for ($i = 0, $n = count( $rows ); $i < $n; $i++) {
                    $row =& $rows[$i];
                    $link = JRoute::_('index.php?option=com_macgallery&view=images&albumid='. $row->id );
                ?>
                    <tr>
                        <td align="center">
                            <?php echo $j+1;?>
                        </td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $row->albumname;?></a>
                        </td>
                        <td align="center" width="10%">
                        <?php // if( $row->published == 1 )
                                //   echo JHTML::_('image.administrator', 'icon-16-true.png', 'components/com_macgallery/assets/', '', '', JText::_('COM_CONTUS_MACGALLERY_PUBLISHED'));
                               // else
                                 //   echo JHTML::_('image.administrator', 'icon-16-false.png', 'components/com_macgallery/assets/', '', '', JText::_('COM_CONTUS_MACGALLERY_UNPUBLISHED'));?>
                        </td>

                    </tr>
                    <?php
                    $j++;
                }
            ?>
            </table>
            <?php
                echo JHtmlSliders::end();
             ?>
             </div>

	<input type="hidden" name="option" value="com_macgallery" />
	<input type="hidden" name="view" value="cpanel" />
	<input type="hidden" name="<?php //echo JUtility::getToken(); ?>" value="1" />
</div>
