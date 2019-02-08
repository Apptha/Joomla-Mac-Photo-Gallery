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
                        $i = 0;

                       
                        foreach ($albRows as $row) {
?>
                            <li <?php if ($row->id == JRequest::getVar('albumid', '', 'request', 'int'))
                                 ?>>
                                    <a style="text-decoration:none;"
                                       href="<?php echo JRoute::_('index.php?option=com_macgallery&view=images&albumid=' . $row->id); ?>"
                                   title="<?php echo $row->albumname; ?>">
                                    <div style="float:left;">
                                        <img class="curved"
                                             title="<?php echo $row->albumname; ?>"
                                             src="<?php
						                                if ($row->image != '' && $row->published ) {
						                                    echo JURI::base()."images/macgallery/medium_image/".$row->image;
						                                } else {
						                                    echo $baseurl.'/components/com_macgallery/images/uploads/star_thumb.jpeg';
						                                } ?>"
                                             alt=""  height="100" width="100" style="margin:0px;padding: 0px;"/>
                                    </div>

                                </a>
                            </li>
<?php
                                $i = $i + 1;
                            }
?>

