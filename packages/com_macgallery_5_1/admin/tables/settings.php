<?php
/*
 ***********************************************************

 * Component Name: Mac-Dock Gallery
 * Description: Mac dock photo gallery component for Joomla 1.5, 1.6 & 1.7
 * Version: 1.3
 * Edited By: Sameera
 * Author URI: http://www.apptha.com/
 * Date : March 14 2011

 **********************************************************

 @Copyright Copyright (C) 2010-2011 Contus Support
 @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,

 **********************************************************/

/* No direct acesss */
defined( '_JEXEC' ) or die( 'restricted access' );

class Tablesettings extends JTable
{
    var $id = null;
    var $rowimg = null;
    var $rows = null;
    var $thumbimgheight = null;
    var $thumbimgwidth=null;
    var $mouseover_width = null;
    var $mediumimgheight = null;
    var $mediumimgwidth=null;
    var $fullimgheight = null;
    var $fullimgwidth=null;

    var $proximity=null;
    var $effect_direction = null;
    var $imgdisplay = null;
    var $published = null;
    var $alblist = null;
    var $imgdispstyle = null;
    var $api_key = null;
    
    function Tablesettings(&$db)
    {
        parent::__construct( '#__macgallery_settings', 'id', $db );
    }
}

  ?>