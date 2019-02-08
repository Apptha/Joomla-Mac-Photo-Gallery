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
class Tableimages extends JTable
{
    var $id = null;
    var $image = null;  
    var $title = null;
    var $description = null;
    var $ordering=null;
    var $singleimg=null;
    var $published = null;
    var $albumid = null;
    var $albcover = null;
    function Tableimages(&$db)
    {
        parent::__construct( '#__macgallery_image', 'id', $db );
    }
}

  ?>