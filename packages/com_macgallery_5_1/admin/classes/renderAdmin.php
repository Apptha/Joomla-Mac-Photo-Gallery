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
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');

class macgalleryRenderAdmin
{

        //function for getting icons in control panel
        function quickIconButton( $link, $image, $text )
        {
            
            $lang = &JFactory::getLanguage();
            $button = '';
            if ($lang->isRTL()) {
                $button .= '<div style="float:right;">';
            } else {
                $button .= '<div style="float:left;">';
            }


            
            $button .=	'<div class="icon">'
                       .'<a href="'.$link.'">'
                       //.JHtml::_('image.site',  $image, '/components/com_macgallery/assets/', NULL, NULL, $text )
                       .'<span>'.$text.'</span></a>'
                       .'</div>';

            
            $button .= '</div>';

            

            return $button;
	}
}