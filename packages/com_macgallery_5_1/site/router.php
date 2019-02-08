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

function macgalleryBuildRoute(&$query) {
    $segments = array();

    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:

 */
function macgalleryParseRoute($segments) {
    $vars = array();

    // view is always the first element of the array
    $count = count($segments);

    if ($count) {
        switch ($segments[0]) {
            case 'album':
                $vars['view'] = 'album';

                if (isset($segments[1]))
                    $vars['mode'] = $segments[1];
                if (isset($segments[2]))
                    $vars['pageid'] = $segments[2];
                break;

            case 'images':
                $vars['view'] = 'images';
                if (isset($segments[1]))
                    $vars['albumid'] = $segments[1];
                if (isset($segments[2]))
                    $vars['mode'] = $segments[2];
                if (isset($segments[3]))
                    $vars['pageid'] = $segments[3];
                break;
        }
    }
    return $vars;
}

?>
