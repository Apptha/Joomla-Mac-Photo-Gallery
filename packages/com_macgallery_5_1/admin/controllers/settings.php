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

/* no direct access */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/* Settings Administrator Controller */
class MacgalleryControllersettings extends JControllerLegacy
{

    function display()
    {
        $viewName = JRequest::getVar( 'view', 'settings' );

        $view =& $this->getView($viewName);
        if ($model =& $this->getModel('settings'))
        {
            $view->setModel($model, true);
        }
        $view->display();
    }

    function edit()
    {
        $this->display();
    }

    function save()
    {
        $detail = JRequest::get( 'POST' );
        $model =& $this->getModel('settings');
        $model->savesettings($detail);
        $this->mac_genenrate();
        
    	$userApiEcom = JRequest::getVar("licenseKey");
        $msg = "";
        if($userApiEcom){
        	$msg = "<p>".JText::_("COM_MACGALLERY_INVALID_LICENSE_KEY")."</p>";	
        	$return  = $this->mac_genenrate($userApiEcom);
        	if($return=="success"){
        		$msg = JText::_("COM_MACGALLERY_THANKYOU_PURCHASE");
        		$fileContent = "<?php define('conf__MAC_GALLERY','1');\n ?> ";
        		$path = JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php";
		        $fp = fopen($path, "w");
		        if ($fp) {
		            fwrite($fp, $fileContent);
		            fclose($fp);
		        }
        	}
        	else{ 
        		$fileContent = "<?php define('conf__MAC_GALLERY','0');\n ?> ";
        		$path = JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php";
		        $fp = fopen($path, "w");
		        if ($fp) {
		            fwrite($fp, $fileContent);
		            fclose($fp);
		        }
        		JError::raiseWarning(500, $msg);
        		$msg = "";
        	}	
        }
        
        $this->setRedirect('index.php?view=settings&option='.JRequest::getVar('option'), JText::_('COM_MACGALLERY_CONTROLLERS_SETTINGS_SAVED').$msg);
    }

    function cancel()
    {
        $this->setRedirect('index.php?view=settings&option='.JRequest::getVar('option'), JText::_('COM_MACGALLERY_CONTROLLERS_SETTINGS_CANCELLED'));
    }

    function apply()
    {
        $settings = JRequest::get( 'POST' );
        $model =& $this->getModel('settings');
        $model->savesettings($settings);
        
        $userApiEcom = JRequest::getVar("licenseKey");
        $msg = "";
        if($userApiEcom){
        	$msg = "<p>Invalid License Key</p>";	
        	$appthEcom =  $this->mac_genenrate();
        	if($userApiEcom==$appthEcom){
        		$msg = " Your license activated";
        		$fileContent = "<?php define('conf__MAC_GALLERY','1');\n ?> ";
        		$path = JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php";
		        $fp = fopen($path, "w");
		        if ($fp) {
		            fwrite($fp, $fileContent);
		            fclose($fp);
		        }
        	}
        	else{ 
        		$fileContent = "<?php define('conf__MAC_GALLERY','0');\n ?> ";
        		$path = JPATH_COMPONENT_ADMINISTRATOR . DS . "classes" . DS . "key.php";
		        $fp = fopen($path, "w");
		        if ($fp) {
		            fwrite($fp, $fileContent);
		            fclose($fp);
		        }
        		JError::raiseWarning(500, $msg);
        		$msg = "";
        	}	
        }
        
        $link = 'index.php?option=com_macgallery&view=settings&task=edit&cid[]='.$settings['id'];
        $this->setRedirect($link, JText::_('COM_MACGALLERY_CONTROLLERS_SETTINGS_SAVED').$msg);
    }
	//For license key generation

    function domainKey($tkey) {

    	
        $message = "EJ-MDPGMP0EFIL9XEV8YZAL7KCIUQ6NI5OREH4TSEB3TSRIF2SI1ROTAIDALG-JW";

        for ($i = 0; $i < strlen($tkey); $i++) {
            $key_array[] = $tkey[$i];
        }
     
        $enc_message = "";
        $kPos = 0;
        $chars_str = "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
        for ($i = 0; $i < strlen($chars_str); $i++) {
            $chars_array[] = $chars_str[$i];
        }
        for ($i = 0; $i < strlen($message); $i++) {
            $char = substr($message, $i, 1);

         $offset = $this->getOffset($key_array[$kPos], $char);
            $enc_message .= $chars_array[$offset];
            $kPos++;
            if ($kPos >= count($key_array)) {
                $kPos = 0;
            }
        }

        return $enc_message;
    }

    function getOffset($start, $end) {

        $chars_str = "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
        for ($i = 0; $i < strlen($chars_str); $i++) {
            $chars_array[] = $chars_str[$i];
        }

        for ($i = count($chars_array) - 1; $i >= 0; $i--) {
            $lookupObj[ord($chars_array[$i])] = $i;
        }

        $sNum = $lookupObj[ord($start)];
        $eNum = $lookupObj[ord($end)];

        $offset = $eNum - $sNum;

        if ($offset < 0) {
            $offset = count($chars_array) + ($offset);
        }

        return $offset;
    }
    function get_domain($domain)
    {
     
        $code = $this->domainKey($domain);
        $domainKey = substr($code, 0, 25) . "CONTUS";
        return $domainKey;
      
    }
     function mac_genenrate()
    {
		$strDomainName = JURI::base();
		preg_match("/^(http:\/\/)?([^\/]+)/i", $strDomainName, $subfolder);
		preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $subfolder[2], $matches);
			
		$customerurl = $matches['domain'];
		$customerurl = str_replace("www.", "", $customerurl);
		$customerurl = str_replace(".", "D", $customerurl);
		$customerurl = strtoupper($customerurl);
		$response     = $this->get_domain($customerurl);
		return $response;
    }
}

?>

