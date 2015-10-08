<?php
/**
* You may not change or alter any portion of this comment or credits
* of supporting developers from this source code or any supporting source code
* which is considered copyrighted (c) material of the original comment or credit authors.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* XIM - Xoops Instant Messenger
*
* A one-on-one messenger written for xoops. Inspired by Anant Garg's -(anantgarg.com | inscripts.com)-
* 2009 tutorial on jquery messenger & by the original facebook messenger and a few more. This module has
* been adapted, written, re-written and extended heavily by Andrax & Culex.
*
* @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
* @license         http://www.fsf.org/copyleft/gpl.html GNU public license
* @package         modules
* @subpackage      xim
* @since           2.4.0
* @author          Andrax - homepage.: http://guxbrasil.org & email.: lcbc@ig.com.br
* @author          Culex  - homepage.: http://culex.dk		& email.: culex@culex.dk
**/
defined('XOOPS_ROOT_PATH') or die('Restricted access');
include_once(XOOPS_ROOT_PATH."/modules/xim/include/functions.php");
class XimCorePreload extends XoopsPreloadItem{

    function eventCoreHeaderAddmeta(){
	global $xoTheme,$xoopsUser;
// 	$style = 0;
	if ($xoopsUser) {
		$module_handler =& xoops_gethandler('module');
		$module = $module_handler->getByDirname('xim');
		$config_handler =& xoops_gethandler('config');
		if ($module) {
			    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	/*	    	if(isset($moduleConfig['chatstyle'])) {
		    		$style = $moduleConfig['chatstyle'];
		    	}
	*/
		    	if(isset($moduleConfig['showfooterbar'])) {
		    		$showFooterBar = $moduleConfig['showfooterbar'];
		    	}
			if(isset($moduleConfig['footerbarstyle'])) {
		    		$footerBarStyle =$moduleConfig['footerbarstyle'];
		    	}
				
			if(isset($moduleConfig['chatwindowstyle'])) {
					$chatwindowstyle = $moduleConfig['chatwindowstyle'];
			}
					if ($chatwindowstyle=='') {
					$chatwindowstyle = 0;
					}
					
				// check styling for chat window
					if ($chatwindowstyle == '0') {
					$cws = 'default';
					}
					if ($chatwindowstyle == '1') {
					$cws = 'white';
					}
					if ($chatwindowstyle == '2') {
					$cws = 'black';
					}
					if ($chatwindowstyle == '3') {
					$cws = 'stiky';
					}
					if ($chatwindowstyle == '4') {
					$cws = 'alert';
				}
			
		}
if ($xoopsUser) {	
	$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/xim.css');
	$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/mbContainer.css');
	$xoTheme->addScript(XOOPS_URL.'/browse.php?Frameworks/jquery/jquery.js');
	$xoTheme->addScript(XOOPS_URL.'/browse.php?Frameworks/jquery/plugins/jquery.ui.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/mbContainer.js');
	$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/jquery.metadata.js');
	
	
    // Check if request url is with www or without
    $urltest = xim_getHostRequest();
    $xoops_url = XOOPS_URL;
    if (!strstr($urltest, 'www.')) {
        $xoops_url = str_replace( 'www.', '', $xoops_url );
    }
	$script= <<<SCRIPT
	var xoops_url="$xoops_url";
	var xim_url="$xoops_url/modules/xim/";
	var showFooterBar = $showFooterBar;
	var footerBarStyle = $footerBarStyle;
	var userSound ='';
	var cws = '$cws';
	var xoops_im = jQuery.noConflict();
	//var $ = jQuery;
SCRIPT;
		$xoTheme->addScript('','',$script);
		$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/chat.js');
		$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/configscript.js');
		$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/soundmanager2.js');
		$xoTheme->addScript(XOOPS_URL.'/modules/xim/js/sm_default.js');
}	
	
			if ($showFooterBar!=0) {
				$xoTheme->addStylesheet(XOOPS_URL.'/modules/xim/css/footer.css.php?style='.$footerBarStyle);
			}
			}
	}
	
	function isActive() {
		$module_handler =& xoops_getHandler('module');
		$module = $module_handler->getByDirname('xim');
		return ($module && $module->getVar('isactive')) ? true : false;
	}
}
?>
